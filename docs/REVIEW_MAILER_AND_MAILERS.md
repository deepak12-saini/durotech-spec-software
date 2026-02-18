# Review: Mailer (ContactMailer) and MailersController + Related Views/Templates

## Summary

| Component | Status | Notes |
|-----------|--------|--------|
| **ContactMailer** + contact email | ✅ CakePHP 3 style, good | Used by FrontsController for contact form |
| **MailersController** + Mailers views | ⚠️ CakePHP 2 style | Incompatible with Cake 3; will fail if invoked |
| **Email templates** (contact_form, default) | ✅ OK | Proper escaping and layout |
| **Model/Table Mailer** | ⚠️ Legacy | File is Cake 2 AppModel in Table folder |

---

## 1. ContactMailer and Related Email Templates (CakePHP 3)

### 1.1 `src/Mailer/ContactMailer.php`

- **Style:** CakePHP 3.10 Mailer.
- **Usage:** `FrontsController` calls `$this->getMailer('Contact')->send('contactForm', [$data])`.
- **Behaviour:** Sets From/To, subject, view vars, template `contact_form`, layout `default`, then `deliver()`.
- **Recommendation:** No changes required. Optional: use `Configure::read('Site.email')` / `Site.name` only (drop `defined('EMAIL')` / `SITENAME`) if you want config-only.

### 1.2 `src/Template/Email/html/contact_form.ctp`

- **View vars:** `name`, `email`, `phone`, `message`.
- **Security:** Uses `h()` and null coalescing (`?? ''`) for all output; `nl2br(h($message))` for the message.
- **Recommendation:** Keep as is.

### 1.3 `src/Template/Email/html/default.ctp` and `text/default.ctp`

- Standard CakePHP email content templates (`$content` as lines or raw).
- **Recommendation:** No change.

### 1.4 `src/Template/Layout/Email/html/default.ctp`

- Simple HTML wrapper with `fetch('title')` and `fetch('content')`.
- **Recommendation:** No change.

---

## 2. MailersController (CakePHP 2 – Incompatible with Cake 3)

### 2.1 File and class

- **Path:** `src/Controller/MailersController.php`
- **Issue:** Written for CakePHP 2. In a Cake 3 app it will not load or run correctly.

### 2.2 Cake 2 vs Cake 3 incompatibilities

| Cake 2 usage in MailersController | Cake 3 equivalent / note |
|-----------------------------------|----------------------------|
| `App::uses('AppController', 'Controller');` | Use `namespace App\Controller;` and `use App\Controller\AppController;` |
| No namespace | Must be in `namespace App\Controller;` |
| `public $uses = array('User','Mailer',...);` | Remove; use `$this->loadModel('Mailer')` etc. in actions or `initialize()` |
| `public $components = array('Session','Paginator');` | Remove; Session via `$this->request->getSession()`, Paginator via `$this->Paginator` (component loaded by default in Cake 3) |
| `$this->layout = 'admin_layout';` | `$this->viewBuilder()->setLayout('admin_layout');` |
| `$this->Session->read('User.id')` | `$this->request->getSession()->read('User.id')` |
| `$this->Session->setFlash(...)` | `$this->Flash->success()` / `$this->Flash->error()` |
| `$this->Mailer->bindModel(array(...))` | Define associations on `MailerTable` (e.g. `belongsTo('User')`, `belongsTo('NappUser')`); no runtime bindModel |
| `$this->Mailer->find('all', array('conditions'=>...))` | `$this->Mailer->find()->where([...])->all()` or `$this->Mailer->find()->where([...])` |
| `$this->Mailer->save($inserty)` with array | `$entity = $this->Mailer->newEntity($data); $this->Mailer->save($entity);` (or patchEntity for edit) |
| `$this->request->data` | `$this->request->getData()` |
| `$this->request->params['form']` | `$this->request->getData()` (form body) or `$this->request->getUploadedFile()` for files |
| `$this->Mailer->id` after save | `$entity->id` from the saved entity |
| `$this->Mailer->create()` | Not used in Cake 3 |
| `return $this->redirect(array('action' => 'index'));` | `return $this->redirect(['action' => 'index']);` (same but use short array) |
| `Sanitize::escape()` | Prefer parameterised queries / ORM; do not build SQL with string escape |
| `$this->SpecUsearea->query($query)` with concatenated SQL | Use `$this->SpecUsearea->find()` with `where()` to avoid SQL injection |

### 2.3 Routes

- **Current:** No `admin/mailers` routes in `config/routes.php`. So `/admin/mailers`, `/admin/mailers/visitor`, etc. rely on default routing and will resolve to `MailersController` only if the controller is loadable.
- **Issue:** The controller uses Cake 2 syntax and will typically cause parse/load errors or missing method errors in Cake 3.
- **Recommendation:** Either:
  - Add explicit routes for Mailers only after the controller is ported to Cake 3, or
  - Leave as-is and accept that admin mailer URLs will not work until ported.

### 2.4 Security / data handling

- **admin_list / admin_title_list:** Use raw or concatenated input in SQL (`$_REQUEST["keyword"]`, `addslashes`). **Risk:** SQL injection. Use ORM and parameterised conditions.
- **admin_send / admin_send_v3 and similar:** File uploads and `$this->request->data` should be read via `getData()` and validated; use `getUploadedFile()` for files and validate type/size.
- **admin_sendemail:** Calls undefined `$this->sendemail()` (likely legacy helper). Needs to be replaced with Cake 3 Mailer or Email class and proper template.

---

## 3. Mailers Views (`src/Template/Mailers/`)

### 3.1 Data shape expected by views

- **admin_index.php** (and similar list views) expect:
  - `$mailers` as a list of **arrays** with keys `Mailer`, `User` (e.g. `$mailer['Mailer']['id']`, `$mailer['User']['name']`).
- In Cake 3, `$this->Mailer->find()->contain(['User', 'NappUser'])->all()` returns **entities**. So either:
  - Convert in controller: `foreach ($results as $row) { $mailers[] = ['Mailer' => $row->toArray(), 'User' => $row->user ? $row->user->toArray() : []]; }`, or
  - Change views to use entity access: `$mailer->id`, `$mailer->tracknumber`, `$mailer->user->name`, etc.

### 3.2 Session / Flash in views

- If any Mailers view uses `$this->Session`, replace with `$this->request->getSession()` (same as admin header fix) to avoid SessionHelper deprecation.

### 3.3 Other view files

- **price_list_mailers.php:** Form uses `data[NewPriceListLog][...]` and `Form->create('Mailer', ...)`. When porting, align with Cake 3 form naming and controller `getData('NewPriceListLog')` or the table you use for price list emails.
- **admin_send.php, admin_send_v3.php, admin_editsend.php, etc.:** Depend on controller providing the same structure as before; after porting, ensure view vars and form field names match the new controller and entities.

---

## 4. Model/Table `Mailer`

- **Path:** `src/Model/Table/Mailer.php`
- **Current content:** Same as old Cake 2 model: `App::uses('AppModel','Model'); class Mailer extends AppModel { var $name='Mailer'; }`.
- **Issue:** In Cake 3, Table classes live in `Model/Table`, extend `Cake\ORM\Table`, and use a different API (e.g. `$this->setTable('mailers')`, `$this->belongsTo('User')`). This file is not a valid Cake 3 table class.
- **Recommendation:** Replace with a proper Cake 3 Table class, e.g.:

```php
<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class MailersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('mailers'); // or whatever the DB table name is
        $this->belongsTo('User', ['foreignKey' => 'admin_id']);
        $this->belongsTo('NappUser', ['foreignKey' => 'user_id']);
        $this->hasMany('MailerComment', ['foreignKey' => 'mailer_id']);
        $this->hasMany('SpecUsearea', ['foreignKey' => 'mailer_id']);
    }
}
```

- Table name convention in Cake 3 is usually plural (`mailers`). Confirm the actual table name and use it in `setTable()` if different.

---

## 5. Checklist for Making Mailers Work in Cake 3

1. **Mailer table class:** Implement `MailersTable` (or `MailerTable` if you keep singular) in `src/Model/Table/` with associations and correct table name.
2. **MailersController:** Port to Cake 3: namespace, `loadModel()`, `viewBuilder()->setLayout()`, `getSession()`, `Flash`, `getData()`, `getUploadedFile()`, ORM `find()->where()->contain()`, `newEntity()`/`patchEntity()`/`save($entity)`, and remove `bindModel`, `$uses`, `$components`, `request->data`/`request->params`.
3. **Routes:** Add explicit routes for `/admin/mailers`, `/admin/mailers/visitor`, `/admin/mailers/send`, etc., pointing to the correct controller actions (with camelCase action names if required by your dispatcher).
4. **Views:** Either keep array shape and convert in controller, or update views to entity access; replace any `$this->Session` with `$this->request->getSession()`.
5. **Email sending:** Replace any legacy `sendemail()` / `Email` usage with a Cake 3 Mailer class and email templates (similar to ContactMailer).
6. **SQL:** Remove raw `query()` with concatenated user input; use `$this->SpecUsearea->find()->where(...)` (and similar) only.

---

## 6. Files Referenced in This Review

| Path | Type |
|------|------|
| `src/Mailer/ContactMailer.php` | Mailer (Cake 3) |
| `src/Controller/MailersController.php` | Controller (Cake 2) |
| `src/Model/Table/Mailer.php` | Model/Table (Cake 2 style) |
| `src/Template/Email/html/contact_form.ctp` | Email template |
| `src/Template/Email/html/default.ctp` | Email template |
| `src/Template/Email/text/default.ctp` | Email template |
| `src/Template/Layout/Email/html/default.ctp` | Email layout |
| `src/Template/Mailers/admin_index.php` | View |
| `src/Template/Mailers/price_list_mailers.php` | View |
| Other `src/Template/Mailers/*.php` | Views (same data/structure considerations) |
