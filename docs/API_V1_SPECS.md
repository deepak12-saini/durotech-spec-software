# API v1 — Duro Ezy Spec (Employee)

JSON API for the Duro Ezy Spec mobile app. Authentication uses the **`employees`** table (same as web employee login at `/employees/login`), **not** staff `napp_users`.

Base URL (local): `http://localhost/cake3app/api/v1`

All responses are JSON. Append `.json` to URLs (CakePHP extension).

## Authentication

### Login

`POST /api/v1/auth/login.json`

**Body:**

```json
{
  "username": "employee.username",
  "password": "plain-text-password"
}
```

- `username` maps to `employees.name`
- Password is verified as `md5(plain)` (legacy, same as web)
- Account must have `is_active = 1`

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

**Errors:** `401` wrong credentials, `403` inactive account, `422` missing fields.

Login is recorded in `login_histories` with `role = 'Employee'`. A row is created in `api_tokens` (30-day expiry).

### Current user

`GET /api/v1/auth/me.json`

**Header:** `Authorization: Bearer <token>`

**Success (200):**

```json
{
  "success": true,
  "user": { "...": "same shape as login" }
}
```

### Logout

`POST /api/v1/auth/logout.json`

**Header:** `Authorization: Bearer <token>` (optional but recommended)

Deletes the token row. Always returns success.

---

## Specifications

All spec endpoints require `Authorization: Bearer <token>`.

Specs are scoped to `mailers.employee_id = <logged-in employee>` and `mailers.type = 3`. Drafts (`save_status = 'draft'`) are excluded from the list (same as web employee index). Soft-deleted mailers (`deleted_at`) are excluded when that column exists.

### List specs

`GET /api/v1/specs.json`

**Query parameters:**

| Param | Description |
|-------|-------------|
| `search` | Track number, company, name, or specification |
| `page` | Page number (default `1`) |
| `limit` | Page size (default `20`, max `100`) |

**Success (200):**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "track_number": "DTSPEC 18-06-089",
      "project": "Riverside Commercial Complex",
      "client": "Riverside Development Group",
      "status": "Approved",
      "date": "2024-06-18"
    }
  ],
  "meta": {
    "total": 47,
    "page": 1,
    "limit": 20,
    "stats": {
      "total": 47,
      "this_month": 12,
      "pending": 3
    }
  }
}
```

**Status values:** `Approved`, `Pending`, `Draft` (draft only on detail if accessed directly).

Status is derived from `is_review`, `status`, `save_status`, and `pdf_attachment` (aligned with web employee list).

### Spec detail

`GET /api/v1/specs/:id.json`

**Success (200):**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "track_number": "DTSPEC 18-06-089",
    "project": "Riverside Commercial Complex",
    "project_full": "Riverside Commercial Complex",
    "client": "Riverside Development Group",
    "address": "42 Riverside Drive, Melbourne VIC 3000",
    "email": "procurement@example.com",
    "spec_type": "Below-Grade Waterproofing",
    "status": "Approved",
    "date": "2024-06-18",
    "has_pdf": true
  }
}
```

**404** if the spec does not belong to the employee.

### PDF URL

`GET /api/v1/specs/:id/pdf.json`

**Success (200):**

```json
{
  "success": true,
  "url": "https://example.com/dompdf/spec.pdf",
  "filename": "1-DTSPEC_18-06-089.pdf"
}
```

URL is built from `SITEURL` + `mailers.pdf_attachment` (same as web “View PDF”).

**404** if no PDF is attached.

---

## Database setup

Run once:

```bash
php bin/setup_api_tokens.php
```

Or apply `config/schema/api_tokens.sql` manually.

## Mobile app configuration

Set `EXPO_PUBLIC_API_URL` to your CakePHP base (use LAN IP for Expo Go, not `localhost`):

```
EXPO_PUBLIC_API_URL=http://192.168.x.x/cake3app
```

Set `USE_MOCK_API = true` in `mobile/duro-ezy-spec-app/constants/config.ts` to use local mock data during UI development.

## Example curl

```bash
# Login
curl -X POST http://localhost/cake3app/api/v1/auth/login.json \
  -H "Content-Type: application/json" \
  -d '{"username":"YOUR_EMPLOYEE_NAME","password":"YOUR_PASSWORD"}'

# Me
curl http://localhost/cake3app/api/v1/auth/me.json \
  -H "Authorization: Bearer YOUR_TOKEN"

# Specs list
curl "http://localhost/cake3app/api/v1/specs.json?limit=10" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## CORS

API controllers send `Access-Control-Allow-Origin: *` for development. Restrict origins in production.

## Deferred

`POST /api/v1/spec-requests` (new spec submission) is not implemented; the mobile “New Request” flow remains mock until the employee `employee_send_v3` flow is API-ready.
