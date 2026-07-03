# Duro Ezy Spec — iOS Mobile App  
## Statement of Work (SOW) & Step-by-Step Build Guide

**Client:** Durotech Industries  
**Project:** Duro Ezy Spec mobile app (iOS first)  
**Document version:** 1.0  
**Date:** June 2026  
**Status:** Demo / Phase 1 planning  

---

## 1. Executive summary

Durotech already runs **DuroEzy Specification** on the website (CakePHP admin/employee/staff panels). Kal has requested a **mobile app demo first**, then a full product.

This document defines:

- What the app should do (aligned with the existing web system)
- **iOS-first** delivery (iPhone / iPad)
- Step-by-step phases from demo → App Store
- What the **client must provide**
- What the **developer builds** (app + backend APIs)
- How to develop on a **Windows laptop** while still targeting **iOS**

---

## 2. Background — what exists today (web)

| Area | Location in codebase | Purpose |
|------|----------------------|---------|
| Admin spec list | `MailersController` → `admin_spec_index` | List specs, edit, download PDF, send email |
| Create spec (DWPS) | `admin_create_dwps` | New specification header + products |
| Spec v3 (main flow) | `admin_send_v3` / `employee_send_v3` | Full DuroEzy spec with products, comments, PDF |
| Staff easy spec request | `StaffsController` → `staff_specRequest_form` | Simplified “Easy Spec Request” for staff |
| Spec request approval | `admin_specRequest_index`, approve/disapprove | Admin reviews staff requests |
| AI-assisted specs | `AiSpecsController`, `ClaudeSpecsController` | Optional AI draft (later phase for app) |
| Data store | `mailers` table (+ related product/comment tables) | Track number, client, project, PDF path |

**Typical spec record fields (from web):**

- Track number (`#DES-…`)
- Name / Attn, Email, Company (project), Address
- Specification title / type
- Date, subject, mailer type
- Product rows (title, product, coverage, warranty, serial)
- Comments / notes
- Generated **PDF attachment**
- Email send status

The mobile app should **not rebuild the whole admin website**. It should expose the **most valuable workflows on iPhone** first.

---

## 3. Project goals

### 3.1 Demo goal (Kal: “try making one first”)

Deliver a **working iOS demo** that shows:

1. Durotech branding (logo, colours)
2. Login (or demo mode)
3. **My specs** list (track number, project, date)
4. **Spec detail** screen
5. **View / open PDF** in app or Safari
6. Optional: **Create Easy Spec Request** (simplified form like staff web form)

Demo = prove UX and value before App Store and full feature parity.

### 3.2 Long-term goal

- Native-quality **iOS app** on App Store under Durotech Industries
- Same backend as `durotechindustries.com.au` (secure JSON APIs)
- Later: Android from same React Native codebase (out of scope for Phase 1)

---

## 4. Platform decision — iOS first

| Choice | Decision |
|--------|----------|
| **Primary platform** | **iOS** (iPhone; iPad layout optional in demo) |
| **Framework** | **React Native + Expo** (JavaScript — fits web developer skills) |
| **Backend** | Existing **CakePHP 3** app + new **REST API** layer |
| **Android** | Phase 2+ (same codebase, not in Phase 1 scope) |

### 4.1 Developing on Windows while targeting iOS

| Task | Windows laptop? |
|------|-----------------|
| Write app code (React Native / Expo) | ✅ Yes |
| Test on iPhone with **Expo Go** (scan QR) | ✅ Yes (iPhone + same Wi‑Fi) |
| iOS Simulator | ❌ No (requires Mac) |
| **Demo to Kal on real iPhone** | ✅ Yes via Expo Go or TestFlight |
| **App Store build** | Mac **or** **Expo EAS Build** (cloud) |
| **App Store publish** | Apple Developer account required |

**Recommended path for solo web developer:**

1. Develop on Windows with Expo  
2. Test daily on **physical iPhone** (Expo Go)  
3. Use **EAS Build** for iOS `.ipa` when ready for TestFlight / App Store  
4. Obtain **Mac access** or use EAS for all iOS builds long-term  

---

## 5. Client requirements (before App Store)

Kal / Durotech must provide:

| # | Requirement | Notes |
|---|-------------|-------|
| 1 | **Apple Developer Program** | ~USD $99/year, company account preferred |
| 2 | **App Store Connect access** | Invite developer as Admin or App Manager |
| 3 | **Company details** | Legal name, ABN, address for listing |
| 4 | **Privacy Policy URL** | Live page on durotechindustries.com.au |
| 5 | **Support email** | e.g. sales@durotechindustries.com.au |
| 6 | **Branding** | Logo, app icon 1024×1024, brand colours |
| 7 | **Target users** | Staff, employees, dealers, or admins only? |
| 8 | **Phase 1 features sign-off** | See Section 6 below |

**For demo only:** items 1–6 can wait; demo runs via Expo Go without App Store.

---

## 6. App scope — screens & features

### Phase 0 — Demo (2–3 weeks)

| Screen | Description | Maps to web |
|--------|-------------|-------------|
| **Splash** | Durotech logo | Branding |
| **Login** | Username/password (employee or staff) | Session auth → API token |
| **Home** | Shortcuts: My Specs, New Request, Profile | Dashboard |
| **Spec list** | Paginated list: track #, project, date, status | `admin_spec_index` / employee list |
| **Spec detail** | Header fields + product summary | View mailer record |
| **PDF viewer** | Open `pdf_attachment` URL | Download button on web |
| **New Easy Spec Request** (optional) | Name, project, address, email, date, products | `staff_specRequest_form` |
| **Success / error** | Toast messages | Flash messages |

**Demo data option:** Start with **mock JSON** for UI, then connect live API.

### Phase 1 — MVP (App Store internal test)

Everything in Phase 0, plus:

- Secure token refresh / logout
- Pull-to-refresh on spec list
- Offline-friendly list cache (read-only)
- Push notification when spec request approved (optional)
- App icons, splash, TestFlight build

### Phase 2 — Full parity (later)

- Full spec v3 create/edit (products grid, comments)
- Send spec email from app
- Claude / AI spec assistant integration
- Admin approve/disapprove spec requests
- Android build

---

## 7. Technical architecture

```
┌─────────────────────────────────────┐
│  Duro Ezy Spec iOS App              │
│  React Native + Expo                │
│  - Navigation (React Navigation)    │
│  - API client (fetch / axios)       │
│  - Secure token storage             │
└──────────────┬──────────────────────┘
               │ HTTPS JSON
               ▼
┌─────────────────────────────────────┐
│  CakePHP 3 API (new)                │
│  e.g. /api/v1/specs                 │
│  - POST /auth/login                 │
│  - GET  /specs                      │
│  - GET  /specs/{id}                 │
│  - POST /spec-requests              │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  MySQL (existing)                   │
│  mailers, users, products, …        │
└─────────────────────────────────────┘
```

### 7.1 New backend work (CakePHP)

API endpoints to add (suggested):

| Method | Endpoint | Purpose |
|--------|----------|---------|
| `POST` | `/api/v1/auth/login` | Return JWT or API token |
| `POST` | `/api/v1/auth/logout` | Invalidate token |
| `GET` | `/api/v1/specs` | List specs for logged-in user |
| `GET` | `/api/v1/specs/{id}` | Spec detail + products |
| `GET` | `/api/v1/specs/{id}/pdf` | PDF URL or stream |
| `POST` | `/api/v1/spec-requests` | Staff easy spec request |
| `GET` | `/api/v1/products/search` | Product autocomplete (optional) |

**Security:** HTTPS only, token auth, rate limiting, same roles as web (employee vs staff vs admin).

### 7.2 Mobile app folder structure (recommended)

```
duro-ezy-spec-app/
├── app/                    # Expo Router screens (or src/screens/)
│   ├── (auth)/
│   │   └── login.tsx
│   ├── (tabs)/
│   │   ├── index.tsx       # Home
│   │   ├── specs.tsx       # List
│   │   └── profile.tsx
│   ├── spec/
│   │   └── [id].tsx        # Detail
│   └── request/
│       └── new.tsx         # Easy spec request
├── components/
│   ├── SpecCard.tsx
│   ├── Header.tsx
│   └── PdfButton.tsx
├── services/
│   ├── api.ts
│   └── auth.ts
├── constants/
│   └── theme.ts            # Durotech blue #2f95cd
├── app.json                # Expo config (iOS bundle id)
└── eas.json                # EAS Build profiles (ios)
```

---

## 8. Step-by-step build plan

### Step 1 — Environment setup (Day 1–2)

**On Windows laptop:**

1. Install [Node.js LTS](https://nodejs.org) (v20+)
2. Install VS Code + extensions (ESLint, React Native Tools)
3. Install Git
4. Create project:
   ```bash
   npx create-expo-app@latest duro-ezy-spec-app
   cd duro-ezy-spec-app
   npx expo install react-navigation native-stack
   ```
5. Install **Expo Go** on iPhone (App Store)
6. Run `npx expo start` → scan QR → confirm “Hello World” on iPhone

**Deliverable:** App runs on Kal’s/iPhone via Expo Go.

---

### Step 2 — UI shell & branding (Day 3–5)

1. Add Durotech colours (`#2f95cd`, `#4da3d9`, white/grey)
2. Splash screen + app icon placeholder
3. Navigation: Login → Tabs (Home, Specs, Profile)
4. Static mock screens (no API yet)

**Deliverable:** Clickable demo flow with fake data.

---

### Step 3 — Mock data & spec list/detail (Day 6–8)

1. Create `mock/specs.json` matching mailer fields
2. Spec list: FlatList with track number, project, date
3. Spec detail: show all header fields
4. “View PDF” opens sample PDF URL in in-app browser

**Deliverable:** Kal can review list + detail UX on iPhone.

---

### Step 4 — Backend API (Week 2)

**In `cake3app` (CakePHP):**

1. Create `src/Controller/Api/` namespace
2. Add `Api/V1/SpecsController`, `Api/V1/AuthController`
3. Enable JSON responses + CORS for mobile (if needed)
4. Implement login + list + detail endpoints
5. Test with Postman

**Deliverable:** API documented + tested before wiring app.

---

### Step 5 — Connect app to live API (Week 2–3)

1. Replace mock data with `fetch()` to production/staging API
2. Store auth token in `expo-secure-store`
3. Handle loading, errors, empty states
4. PDF link uses `pdf_attachment` from API response

**Deliverable:** Real specs from Durotech server on iPhone.

---

### Step 6 — Easy Spec Request form (Week 3, optional for demo)

1. Form screens mirroring `staff_specRequest_form.php` core fields
2. `POST /api/v1/spec-requests`
3. Success confirmation screen

**Deliverable:** Staff can submit request from phone.

---

### Step 7 — iOS build for Kal (TestFlight) (Week 4)

1. Register **bundle identifier** e.g. `com.durotechindustries.duroezyspec`
2. Configure `eas.json` for iOS
3. Run `eas build --platform ios` (cloud build from Windows)
4. Upload to **TestFlight** (needs Apple Developer account)
5. Invite Kal as tester

**Deliverable:** Installable app without Expo Go.

---

### Step 8 — App Store submission (after client sign-off)

1. App Store screenshots (6.7", 6.5", iPad if required)
2. Description, keywords, privacy policy URL
3. Submit for Apple review (typically 1–7 days)
4. Release to production

---

## 9. iOS-specific configuration checklist

| Item | Value / action |
|------|----------------|
| Bundle ID | `com.durotechindustries.duroezyspec` (confirm with client) |
| Display name | **Duro Ezy Spec** |
| Minimum iOS | 15.0+ (recommended) |
| Permissions | None for demo; later: notifications |
| ATS | All API calls HTTPS to durotechindustries.com.au |
| Icons | 1024×1024 PNG, no transparency |
| Launch screen | Durotech logo on white |

---

## 10. Timeline estimate (solo developer)

| Phase | Duration | Output |
|-------|----------|--------|
| Step 1–3 Demo UI | 1–1.5 weeks | Expo Go demo with mock data |
| Step 4 API | 1 week | CakePHP JSON endpoints |
| Step 5 Live integration | 0.5–1 week | Real data on iPhone |
| Step 6 Spec request form | 0.5–1 week | Optional for demo |
| Step 7 TestFlight | 0.5 week | Needs Apple account |
| Step 8 App Store | 1 week + review | Production release |

**Total to demo:** ~2 weeks  
**Total to TestFlight:** ~4 weeks (with client Apple account)  

---

## 11. Success criteria

### Demo sign-off (Kal)

- [ ] App opens on iPhone with Durotech branding  
- [ ] User can log in (or demo account)  
- [ ] Spec list loads with real or realistic data  
- [ ] Spec detail shows correct fields  
- [ ] PDF opens from spec record  
- [ ] UI feels professional and on-brand  

### MVP sign-off

- [ ] TestFlight build installed on Kal’s iPhone  
- [ ] Live API on production server  
- [ ] No critical crashes in 1 week of use  
- [ ] Privacy policy linked in app / App Store  

---

## 12. Out of scope (Phase 1)

- Android Play Store release  
- Full admin panel in app  
- Offline spec editing with sync  
- Claude AI spec generation in app  
- Replacing entire DuroEzy web mailer UI  
- Product warranty module (separate project — already automated on web)  

---

## 13. Risks & mitigations

| Risk | Mitigation |
|------|------------|
| No Mac for iOS builds | Use **Expo EAS Build** (cloud) |
| Apple rejects app | Privacy policy, clear purpose, test account for reviewer |
| API security | Token auth, HTTPS, role checks |
| Large PDFs on mobile | Open in Safari / native PDF viewer, don’t embed huge files |
| Scope creep | Lock Phase 0 demo features; Phase 2 for full v3 editor |

---

## 14. Message to send Kal (summary)

> We will build **Duro Ezy Spec** as an **iOS app first** (iPhone), starting with a **demo** you can open on your phone: login, spec list, spec detail, and PDF view. Development uses the same Durotech server data via new secure APIs.  
>  
> For the **demo**, no App Store is required — we use TestFlight-style testing or Expo Go.  
>  
> For **App Store release**, we need the Apple Developer account ($99/year), privacy policy URL, logo/app icon, and confirmation of who uses the app (staff/employees) and which features are in version 1.

---

## 15. Next actions

| # | Owner | Action |
|---|-------|--------|
| 1 | Developer | Create Expo project `duro-ezy-spec-app` |
| 2 | Developer | Build mock UI (Steps 1–3) |
| 3 | Kal | Confirm target users + Phase 0 feature list |
| 4 | Developer | Design API spec (`docs/API_V1_SPECS.md` — optional follow-up) |
| 5 | Developer | Implement CakePHP API endpoints |
| 6 | Kal | Apple Developer account when ready for TestFlight |

---

## 16. Reference — related web routes

| Feature | URL pattern (web) |
|---------|-------------------|
| Admin spec list | `/admin/mailers/spec_index` |
| Create spec v3 | `/admin/mailers/send_v3` |
| Employee spec v3 | `/employees/employee_send_v3` |
| Staff spec request | `/staffs/staff_spec_request_form` |
| Spec request admin | `/admin/mailers/specRequest_index` |

---

*End of document — use this as the master plan for building the Duro Ezy Spec iOS app step by step.*
