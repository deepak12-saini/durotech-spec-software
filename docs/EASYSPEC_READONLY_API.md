# EasySpec read-only API (client)

Private JSON API for **one Durotech user**. Read EasySpec (DuroEzy) jobs only. No create, update, clone, or delete.

Internal / mobile notes: [API_V1_SPECS.md](API_V1_SPECS.md).

## Base URL

| Environment | Base |
|---|---|
| Local | `http://localhost/cake3app/api/v1` |
| Live | `https://specs.durotechindustries.com.au/api/v1` |

All responses are JSON. Append `.json` to paths (CakePHP).

## Auth (you only)

Same login as EasySpec web: **employee** username (`employees.name`), not admin staff.

`POST /auth/login.json`

Do **not** open this URL in a browser (that is GET and will not log in). Use POST with JSON, or curl below.

```json
{
  "username": "YOUR_EMPLOYEE_NAME",
  "password": "YOUR_PASSWORD"
}
```

**Success (200):**

```json
{
  "success": true,
  "token": "64-char-hex-bearer-token",
  "user": {
    "id": 1,
    "name": "James Harrington",
    "username": "james.h",
    "email": "j.harrington@durotech.com.au",
    "role": "employee"
  }
}
```

Use this header on every later call:

```
Authorization: Bearer YOUR_TOKEN
```

Token lasts **30 days**. Account must be `is_active = 1`. Specs returned are only jobs owned by that employee (`mailers.employee_id`).

`GET /auth/me.json` — current user.  
`POST /auth/logout.json` — drop this token.

## 1. List specs

`GET /specs.json?search=&page=1&limit=20`

| Query | Meaning |
|---|---|
| `search` | Track number, company, name, or specification |
| `page` | Page number (default `1`) |
| `limit` | Rows per page (default `20`, max `100`) |

Examples: `?page=2` · `?page=2&limit=10` · `?search=DTSPEC&page=1&limit=20`

`meta` includes `total`, `page`, `limit`, `total_pages`, `has_prev`, `has_next`, `from`, `to`.

Each list item is the **same shape as one spec** (mailer fields, spec options, use areas, comments). See below.

Status: `Approved`, `Pending` (list excludes drafts).

## 2. One spec

`GET /specs/1.json`

**Success (200):**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "track_number": "DTSPEC 18-06-089",
    "name": "Contact name",
    "email": "procurement@example.com",
    "company": "Riverside Development Group",
    "address": "42 Riverside Drive, Melbourne VIC 3000",
    "specification": "External Liquid WPM",
    "created": "2024-06-18 09:00:00",
    "date": "2024-06-18",
    "project": "Riverside Development Group",
    "mailer_type_id": 3,
    "mailer_type": "External Liquid WPM",
    "subject": "Durotech: External Liquid WPM",
    "spec_type": "With Warranty Column",
    "spec_type_code": 1,
    "status": "Approved",
    "has_pdf": true,
    "use_areas": [
      {
        "title": "Lift Pit - Positive",
        "products": [
          {
            "id": 10,
            "serial": "1",
            "product_type": "Epoxy Primer",
            "product": "WBE Epoxy Primer",
            "mft": "SC",
            "warranty_period": "10 years"
          }
        ]
      }
    ],
    "comments": [
      { "id": 1, "comment": "Site note" }
    ]
  }
}
```

**404** if the id is missing or not yours.

## 3. PDF link

`GET /specs/1/pdf.json`

**Success (200):**

```json
{
  "success": true,
  "url": "https://specs.durotechindustries.com.au/dompdf/....pdf",
  "filename": "1-DTSPEC_18-06-089.pdf"
}
```

**404** if no PDF is attached yet (`has_pdf` is false on detail).

## curl examples (local)

```bash
# Login
curl -X POST http://localhost/cake3app/api/v1/auth/login.json \
  -H "Content-Type: application/json" \
  -d "{\"username\":\"YOUR_EMPLOYEE_NAME\",\"password\":\"YOUR_PASSWORD\"}"

# List
curl "http://localhost/cake3app/api/v1/specs.json?limit=10" \
  -H "Authorization: Bearer YOUR_TOKEN"

# One spec
curl http://localhost/cake3app/api/v1/specs/1.json \
  -H "Authorization: Bearer YOUR_TOKEN"

# PDF link
curl http://localhost/cake3app/api/v1/specs/1/pdf.json \
  -H "Authorization: Bearer YOUR_TOKEN"
```

Live: replace the host with `https://specs.durotechindustries.com.au/api/v1`.

## Not included

- Create / update / clone / delete a spec  
- Warranty portal  
- Spec Hub write  
- Public unauthenticated access  

## Setup (staff)

If login returns a server error, create the token table once:

```bash
php bin/setup_api_tokens.php
```

Schema: `config/schema/api_tokens.sql`.
