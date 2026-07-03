# Production email setup (fix "Connection refused")

## Symptom

Admin **Duro Warranty Request** → **Send Form Request** shows:

> Email could not be sent… **Connection refused**

The warranty row stays **Pending** because SMTP never connected.

## Root cause

**Connection refused** means the web server cannot open a TCP connection to the configured SMTP **host:port** (network/firewall/wrong host)—not a wrong password. Wrong passwords usually show *authentication* errors after connecting.

The **Send Form Request** action calls `AppController::sendemail()` using the `Email.default` profile (`config/app.php` → transport `durotech`).

## Interim: Gmail until client provides Durotech mailbox

If company SMTP is not available yet, set in **`config/.env`** on the server (or environment variables):

```
EMAIL_TRANSPORT=gmail
EMAIL_USE_SMTP_AUTH_AS_FROM=true
DUROTECH_SMTP_HOST=smtp.gmail.com
DUROTECH_SMTP_PORT=587
DUROTECH_SMTP_USER=your@gmail.com
DUROTECH_SMTP_PASSWORD=your_gmail_app_password
DUROTECH_SMTP_TLS=true
```

Emails will send **from the Gmail address** until you switch to `EMAIL_TRANSPORT=durotech` with `sales@durotechindustries.com.au`.

---

## Production configuration (required)

On the **live server**, do **not** rely on the repo root `.env` (local dev / Gmail). Use **`config/app_local.php`** (not committed) or server environment variables.

### 1. Create `config/app_local.php` on production

```php
<?php
return [
    'debug' => false,

    'Email' => [
        'default' => ['transport' => 'durotech'],
        'useSmtpAuthAddressAsFrom' => false,
    ],

    'EmailTransport' => [
        'durotech' => [
            'className' => 'Smtp',
            'host' => 'mail.durotechindustries.com.au',
            'port' => 587,
            'username' => 'sales@durotechindustries.com.au',
            'password' => 'YOUR_MAILBOX_PASSWORD',
            'tls' => true,
            'timeout' => 30,
        ],
    ],
];
```

Use the mailbox password from your hosting control panel (cPanel / Plesk → Email Accounts → `sales@durotechindustries.com.au`).

### 2. Or set environment variables (Apache / PHP-FPM)

```
EMAIL_TRANSPORT=durotech
DUROTECH_SMTP_HOST=mail.durotechindustries.com.au
DUROTECH_SMTP_PORT=587
DUROTECH_SMTP_USER=sales@durotechindustries.com.au
DUROTECH_SMTP_PASSWORD=your_password
DUROTECH_SMTP_TLS=true
DEBUG=false
```

### 3. If port 587 is blocked (common on shared hosting)

Ask the host for SMTP settings. Often:

| Setting | Value |
|---------|--------|
| Host | `localhost` or `mail.durotechindustries.com.au` |
| Port | `25`, `587`, or `465` |
| TLS | `true` for 587; try port `465` if 587 is refused |

Update `port` / `tls` in `app_local.php` to match the host’s documentation.

## Verify from the production server (SSH)

```bash
# Test if SMTP port is reachable (Linux)
nc -zv mail.durotechindustries.com.au 587
# or
telnet mail.durotechindustries.com.au 587
```

If this fails, the hosting provider must allow outbound SMTP or provide a local relay (`localhost:25`).

## Check application logs

After a failed send, see:

```
logs/error.log
```

Look for:

```
Email SMTP failure [transport=durotech host=... port=... user=...]: Connection refused
```

## Important

| Do | Don't |
|----|--------|
| Use `sales@durotechindustries.com.au` (or company mailbox) on production | Use personal Gmail credentials on live |
| Set `debug` => **false** on production | Leave `DEBUG=true` on live (exposes errors to admins) |
| Store passwords in `app_local.php` or server env | Commit passwords to git |
| Remove or ignore repo `.env` on production if it points to Gmail | Deploy local `.env` to production |

## Related code

- Send action: `StocksController::admin_sendformtocsutomer()`
- Email send: `AppController::sendemail()`
- Transport config: `config/app.php` → `EmailTransport.durotech`
