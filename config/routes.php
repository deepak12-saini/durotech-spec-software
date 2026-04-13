<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true,
        'skipCheckCallback' => function ($request) {
            // Skip CSRF for AJAX sheet actions
            $controller = strtolower($request->getParam('controller') ?? '');
            $action = $request->getParam('action') ?? '';
            $path = $request->getPath();
            
            // Skip for Sheets controller AJAX actions (case-insensitive)
            if ($controller === 'sheets') {
                $skipActions = [
                    'adminaddnew',
                    'admin_addnew',
                    'adminsetcall',
                    'adminsetreminder',
                    'adminsavedata',
                    'admindoctrash',
                    'adminchangepermission',
                    'admincommentdownload',
                    'updatetasktracking',
                    'savedata'
                ];
                if (in_array(strtolower($action), $skipActions)) {
                    return true;
                }
            }

            // Skip for Mailers list (AJAX product list e.g. staff spec request form)
            if ($controller === 'mailers' && in_array(strtolower($action), ['list', 'adminlist'], true)) {
                return true;
            }
            if (stripos($path, 'mailers/list') !== false) {
                return true;
            }
            
            // Also check by path as fallback
            $skipPaths = [
                'admin/mailers/list',
                '/admin/mailers/list',
                '/cake3app/admin/mailers/list',
                '/admin/sheets/addnew',
                '/cake3app/admin/sheets/addnew',
                '/admin/sheets/setcall',
                '/admin/sheets/setreminder',
                '/admin/sheets/savedata',
                '/admin/sheets/doctrash',
                '/admin/sheets/changepermission',
                '/admin/sheets/commentdownload',
                '/sheets/savedata',
                '/sheets/updatetasktracking'
            ];
            foreach ($skipPaths as $skipPath) {
                if (strpos($path, $skipPath) !== false) {
                    return true;
                }
            }
            return false;
        }
    ]));

    /*
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered through `Application::routes()` with `registerMiddleware()`
     */
    $routes->applyMiddleware('csrf');

    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    // $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

        $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/register', ['controller' => 'Users', 'action' => 'register']);

    // Legal Actions (staff) – ensure controller name is LegalActions
    $routes->connect('/legal_actions', ['controller' => 'LegalActions', 'action' => 'index']);
    $routes->connect('/legal_actions/:action/*', ['controller' => 'LegalActions']);

    // Site Visits (staff) – ensure controller name is SiteVisits
    $routes->connect('/site_visits', ['controller' => 'SiteVisits', 'action' => 'index']);
    $routes->connect('/site_visits/:action/*', ['controller' => 'SiteVisits']);

    // Category slug → CategoryController (forwards to Products::index so "Controller Category could not be found" is avoided)
    $routes->connect('/category/*', ['controller' => 'Category', 'action' => 'index']);

    // Admin panel: use UsersController (no AdminController)
    $routes->connect('/admin', ['controller' => 'Users', 'action' => 'adminLogin']);
    $routes->connect('/admin/dashboard', ['controller' => 'Users', 'action' => 'adminDashboard']);
    $routes->connect('/admin/users/logout', ['controller' => 'Users', 'action' => 'admin_logout']);

    // Admin user menu: profile, settings, change password (avoid "Controller Admin could not be found")
    $routes->connect('/admin/users/profile', ['controller' => 'Users', 'action' => 'admin_profile']);
    $routes->connect('/admin/users/change_password', ['controller' => 'Users', 'action' => 'admin_change_password']);
    $routes->connect('/admin/users/web_setting', ['controller' => 'Users', 'action' => 'admin_web_setting']);
    $routes->connect('/admin/users/payment_setting', ['controller' => 'Users', 'action' => 'admin_payment_setting']);
    $routes->connect('/admin/users/dashboard', ['controller' => 'Users', 'action' => 'adminDashboard']);
    $routes->connect('/admin/users/loginhisotry', ['controller' => 'Users', 'action' => 'admin_loginhisotry']);
    $routes->connect('/admin/users/staff', ['controller' => 'Users', 'action' => 'admin_staff']);
    $routes->connect('/admin/users/customer', ['controller' => 'Users', 'action' => 'admin_customer']);
    $routes->connect('/admin/users/labfile', ['controller' => 'Users', 'action' => 'admin_labfile']);
    $routes->connect('/admin/users/quizz', ['controller' => 'Users', 'action' => 'admin_quizz']);
    $routes->connect('/admin/users/subscriber_list', ['controller' => 'Users', 'action' => 'admin_subscriber_list']);
    $routes->connect('/admin/users/contactus', ['controller' => 'Users', 'action' => 'adminContactus']);
    $routes->connect('/admin/users/contact', ['controller' => 'Users', 'action' => 'admin_contact']);
    $routes->connect('/admin/users/logintostaff', ['controller' => 'Users', 'action' => 'admin_logintostaff']);
    $routes->connect('/admin/users/add_staff', ['controller' => 'Users', 'action' => 'admin_add_staff']);
    $routes->connect('/admin/users/edit_staff/:id', ['controller' => 'Users', 'action' => 'admin_edit_staff'], ['pass' => ['id']]);
    $routes->connect('/admin/users/edit_new_staff/:id', ['controller' => 'Users', 'action' => 'admin_edit_new_staff'], ['pass' => ['id']]);
    $routes->connect('/admin/users/permission/:id', ['controller' => 'Users', 'action' => 'admin_permission'], ['pass' => ['id']]);
    $routes->connect('/admin/users/access/:id', ['controller' => 'Users', 'action' => 'admin_access'], ['pass' => ['id']]);
    $routes->connect('/admin/users/customerpermission/:id', ['controller' => 'Users', 'action' => 'admin_customerpermission'], ['pass' => ['id']]);
    $routes->connect('/admin/users/natspec_presentation_status/:user_id/:status/:type', ['controller' => 'Users', 'action' => 'admin_natspec_presentation_status'], ['pass' => ['user_id', 'status', 'type']]);
    $routes->connect('/admin/users/natspec_presentation_status/:user_id/:status', ['controller' => 'Users', 'action' => 'admin_natspec_presentation_status'], ['pass' => ['user_id', 'status']]);
    $routes->connect('/admin/users/cpd_presentation_status/:user_id/:status/:type', ['controller' => 'Users', 'action' => 'admin_cpd_presentation_status'], ['pass' => ['user_id', 'status', 'type']]);
    $routes->connect('/admin/users/cpd_presentation_status/:user_id/:status', ['controller' => 'Users', 'action' => 'admin_cpd_presentation_status'], ['pass' => ['user_id', 'status']]);
    $routes->connect('/admin/users/contact_delete/:id', ['controller' => 'Users', 'action' => 'admin_contact_delete'], ['pass' => ['id']]);
    $routes->connect('/admin/users/updatelabfile/:id', ['controller' => 'Users', 'action' => 'admin_updatelabfile'], ['pass' => ['id']]);

    // Admin Sheets (Smart Sheets - task management)
    $routes->connect('/admin/sheets', ['controller' => 'Sheets', 'action' => 'admin_index']);
    $routes->connect('/admin/sheets/index', ['controller' => 'Sheets', 'action' => 'admin_index']);
    $routes->connect('/admin/sheets/addnew', ['controller' => 'Sheets', 'action' => 'admin_addnew']);
    $routes->connect('/admin/sheets/sheet/:id', ['controller' => 'Sheets', 'action' => 'admin_sheet'], ['pass' => ['id']]);
    $routes->connect('/admin/sheets/column/:sheet_id', ['controller' => 'Sheets', 'action' => 'admin_column'], ['pass' => ['sheet_id']]);
    $routes->connect('/admin/sheets/column/:sheet_id/:colum_id', ['controller' => 'Sheets', 'action' => 'admin_column'], ['pass' => ['sheet_id', 'colum_id']]);
    $routes->connect('/admin/sheets/share/:sheet_id', ['controller' => 'Sheets', 'action' => 'admin_share'], ['pass' => ['sheet_id']]);
    $routes->connect('/admin/sheets/share/:sheet_id/:status', ['controller' => 'Sheets', 'action' => 'admin_share'], ['pass' => ['sheet_id', 'status']]);
    $routes->connect('/admin/sheets/sheetdetail/:user_id/:sheet_id/:task_id', ['controller' => 'Sheets', 'action' => 'admin_sheetdetail'], ['pass' => ['user_id', 'sheet_id', 'task_id']]);
    $routes->connect('/admin/sheets/comment/:argu', ['controller' => 'Sheets', 'action' => 'admin_comment'], ['pass' => ['argu']]);
    $routes->connect('/admin/sheets/addcomment/:argu', ['controller' => 'Sheets', 'action' => 'admin_addcomment'], ['pass' => ['argu']]);
    $routes->connect('/admin/sheets/document/:argu', ['controller' => 'Sheets', 'action' => 'admin_document'], ['pass' => ['argu']]);
    $routes->connect('/admin/sheets/adddocument/:argu', ['controller' => 'Sheets', 'action' => 'admin_adddocument'], ['pass' => ['argu']]);
    $routes->connect('/admin/sheets/sendtoclient/:argu', ['controller' => 'Sheets', 'action' => 'admin_sendtoclient'], ['pass' => ['argu']]);
    $routes->connect('/admin/sheets/addclientcomment/:argu', ['controller' => 'Sheets', 'action' => 'admin_addclientcomment'], ['pass' => ['argu']]);
    $routes->connect('/admin/sheets/savedata/:userid', ['controller' => 'Sheets', 'action' => 'admin_savedata'], ['pass' => ['userid']]);
    $routes->connect('/admin/sheets/setcall/:type/:id', ['controller' => 'Sheets', 'action' => 'admin_setcall'], ['pass' => ['type', 'id']]);
    $routes->connect('/admin/sheets/setreminder/:type/:id', ['controller' => 'Sheets', 'action' => 'admin_setreminder'], ['pass' => ['type', 'id']]);
    $routes->connect('/admin/sheets/deletesheet/:id/:sheet_id', ['controller' => 'Sheets', 'action' => 'admin_deletesheet'], ['pass' => ['id', 'sheet_id']]);
    $routes->connect('/admin/sheets/trash/:sheet_id/:colum_id', ['controller' => 'Sheets', 'action' => 'admin_trash'], ['pass' => ['sheet_id', 'colum_id']]);
    $routes->connect('/admin/sheets/changepermission/:argu', ['controller' => 'Sheets', 'action' => 'admin_changepermission'], ['pass' => ['argu']]);
    $routes->connect('/admin/sheets/commentdownload/:id', ['controller' => 'Sheets', 'action' => 'admin_commentdownload'], ['pass' => ['id']]);
    $routes->connect('/admin/sheets/doctrash/:argu', ['controller' => 'Sheets', 'action' => 'admin_doctrash'], ['pass' => ['argu']]);
    $routes->connect('/admin/sheets/viewdtaa/:argu', ['controller' => 'Sheets', 'action' => 'admin_viewdtaa'], ['pass' => ['argu']]);
    $routes->connect('/admin/sheets/dailer/:argu', ['controller' => 'Sheets', 'action' => 'admin_dailer'], ['pass' => ['argu']]);

    // Staff Sheets (non-admin)
    $routes->connect('/sheets', ['controller' => 'Sheets', 'action' => 'index']);
    $routes->connect('/sheets/index', ['controller' => 'Sheets', 'action' => 'index']);
    $routes->connect('/sheets/sheet/:id', ['controller' => 'Sheets', 'action' => 'sheet'], ['pass' => ['id']]);
    $routes->connect('/sheets/sheetdetail/:sheet_id', ['controller' => 'Sheets', 'action' => 'sheetdetail'], ['pass' => ['sheet_id']]);
    $routes->connect('/sheets/sheetdetail/:sheet_id/:userId', ['controller' => 'Sheets', 'action' => 'sheetdetail'], ['pass' => ['sheet_id', 'userId']]);
    $routes->connect('/sheets/sheetdetail/:sheet_id/:userId/:task_id', ['controller' => 'Sheets', 'action' => 'sheetdetail'], ['pass' => ['sheet_id', 'userId', 'task_id']]);
    $routes->connect('/sheets/savedata/:userid', ['controller' => 'Sheets', 'action' => 'savedata'], ['pass' => ['userid']]);
    $routes->connect('/sheets/updatetasktracking/:formid/:status', ['controller' => 'Sheets', 'action' => 'updatetasktracking'], ['pass' => ['formid', 'status']]);

    // Admin Careers
    $routes->connect('/admin/careers', ['controller' => 'Careers', 'action' => 'admin_index']);
    $routes->connect('/admin/careers/index', ['controller' => 'Careers', 'action' => 'admin_index']);
    $routes->connect('/admin/careers/add', ['controller' => 'Careers', 'action' => 'admin_add']);
    $routes->connect('/admin/careers/edit/:id', ['controller' => 'Careers', 'action' => 'admin_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/careers/delete/:id', ['controller' => 'Careers', 'action' => 'admin_delete'], ['pass' => ['id']]);
    $routes->connect('/admin/careers/apply/:id', ['controller' => 'Careers', 'action' => 'admin_apply'], ['pass' => ['id']]);

    // Public Careers
    $routes->connect('/careers', ['controller' => 'Careers', 'action' => 'index']);
    $routes->connect('/careers/index', ['controller' => 'Careers', 'action' => 'index']);
    $routes->connect('/careers/apply/:id', ['controller' => 'Careers', 'action' => 'apply'], ['pass' => ['id']]);

    // Admin HR
    $routes->connect('/admin/hrs', ['controller' => 'Hrs', 'action' => 'admin_index']);
    $routes->connect('/admin/hrs/index', ['controller' => 'Hrs', 'action' => 'admin_index']);
    $routes->connect('/admin/hrs/hr_appraisal_form', ['controller' => 'Hrs', 'action' => 'admin_hr_appraisal_form']);
    $routes->connect('/admin/hrs/format_evaluation_employe', ['controller' => 'Hrs', 'action' => 'admin_format_evaluation_employe']);
    $routes->connect('/admin/hrs/format_training_calendars', ['controller' => 'Hrs', 'action' => 'admin_format_training_calendars']);
    $routes->connect('/admin/hrs/res_during_leave', ['controller' => 'Hrs', 'action' => 'admin_res_during_leave']);
    $routes->connect('/admin/hrs/reportorganization', ['controller' => 'Hrs', 'action' => 'admin_reportorganization']);
    $routes->connect('/admin/hrs/newjoining', ['controller' => 'Hrs', 'action' => 'admin_newjoining']);
    $routes->connect('/admin/hrs/performancefeedback', ['controller' => 'Hrs', 'action' => 'admin_performancefeedback']);
    $routes->connect('/admin/hrs/attendence', ['controller' => 'Hrs', 'action' => 'admin_attendence']);

    // Admin Organisations
    $routes->connect('/admin/organisations', ['controller' => 'Organisations', 'action' => 'admin_index']);
    $routes->connect('/admin/organisations/index', ['controller' => 'Organisations', 'action' => 'admin_index']);
    $routes->connect('/admin/organisations/result/:circular_id', ['controller' => 'Organisations', 'action' => 'admin_result'], ['pass' => ['circular_id']]);
    $routes->connect('/admin/organisations/detail/:complaint_id/:type', ['controller' => 'Organisations', 'action' => 'admin_detail'], ['pass' => ['complaint_id', 'type']]);
    $routes->connect('/admin/organisations/detail/:complaint_id', ['controller' => 'Organisations', 'action' => 'admin_detail'], ['pass' => ['complaint_id']]);

    // Admin Audits (Quality Assurance)
    $routes->connect('/admin/audits', ['controller' => 'Audits', 'action' => 'admin_index']);
    $routes->connect('/admin/audits/index', ['controller' => 'Audits', 'action' => 'admin_index']);
    $routes->connect('/admin/audits/circularinternalauditlist', ['controller' => 'Audits', 'action' => 'admin_circularinternalauditlist']);
    $routes->connect('/admin/audits/circularinternalauditresult/:id', ['controller' => 'Audits', 'action' => 'admin_circularinternalauditresult'], ['pass' => ['id']]);

    // Admin Purchases (must be before fallbacks to avoid "Controller Admin could not be found")
    $routes->connect('/admin/purchases', ['controller' => 'Purchases', 'action' => 'admin_index'], ['_name' => 'adminPurchases']);
    $routes->connect('/admin/purchases/index', ['controller' => 'Purchases', 'action' => 'admin_index'], ['_name' => 'adminPurchasesIndex']);
    $routes->connect('/admin/purchases/resource_requirement', ['controller' => 'Purchases', 'action' => 'admin_resource_requirement'], ['_name' => 'adminPurchasesResourceRequirement']);

    // Staff portal (CakePHP 2 URLs mapped to StaffsController in CakePHP 3)
    $routes->connect('/staffs/dashboard', ['controller' => 'Staffs', 'action' => 'dashboard']);
    $routes->connect('/staffs/profile', ['controller' => 'Staffs', 'action' => 'profile']);
    $routes->connect('/staffs/change_password', ['controller' => 'Staffs', 'action' => 'change_password']);
    $routes->connect('/staffs/staff_spec_request_form', ['controller' => 'Staffs', 'action' => 'staff_specRequest_form']);
    $routes->connect('/staffs/logout', ['controller' => 'Staffs', 'action' => 'logout']);
    $routes->connect('/staffs/autologin/:id', ['controller' => 'Staffs', 'action' => 'autologin'], ['pass' => ['id']]);

    // Admin staff conformance URLs used by legacy views/redirects
    $routes->connect('/admin/staffs/conformancelist', ['controller' => 'Staffs', 'action' => 'admin_conformancelist']);
    $routes->connect('/admin/staffs/replyto/:id', ['controller' => 'Staffs', 'action' => 'adminReplyto'], ['pass' => ['id'], 'id' => '[^/]+']);
    $routes->connect('/admin/staffs/detail/:nc_number/:type', ['controller' => 'Staffs', 'action' => 'admin_detail'], ['pass' => ['nc_number', 'type']]);
    $routes->connect('/admin/staffs/edit/:id', ['controller' => 'Staffs', 'action' => 'admin_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/staffs/reminder/:id/:emp_id', ['controller' => 'Staffs', 'action' => 'adminReminder'], ['pass' => ['id', 'emp_id'], 'emp_id' => '[^/]+']);
    $routes->connect('/admin/staffs/reminder/:id', ['controller' => 'Staffs', 'action' => 'adminReminder'], ['pass' => ['id'], 'id' => '[^/]+']);

    // Admin Complaints routes
    $routes->connect('/admin/complaints', ['controller' => 'Complaints', 'action' => 'adminIndex']);
    $routes->connect('/admin/complaints/index', ['controller' => 'Complaints', 'action' => 'adminIndex']);
    $routes->connect('/admin/complaints/detail/:complaint_id/:type', ['controller' => 'Complaints', 'action' => 'adminDetail'], ['pass' => ['complaint_id', 'type'], 'complaint_id' => '[^/]+']);
    $routes->connect('/admin/complaints/detail/:complaint_id', ['controller' => 'Complaints', 'action' => 'adminDetail'], ['pass' => ['complaint_id'], 'complaint_id' => '[^/]+']);
    $routes->connect('/admin/complaints/autologin/:complaint_id/:user_id', ['controller' => 'Complaints', 'action' => 'adminAutologin'], ['pass' => ['complaint_id', 'user_id']]);
    $routes->connect('/admin/complaints/isapproveddisapproved/:type/:complaint_id/:user_id', ['controller' => 'Complaints', 'action' => 'adminIsapproveddisapproved'], ['pass' => ['type', 'complaint_id', 'user_id']]);

    // Admin Documents routes
    $routes->connect('/admin/documents', ['controller' => 'Documents', 'action' => 'adminIndex']);
    $routes->connect('/admin/documents/index', ['controller' => 'Documents', 'action' => 'adminIndex']);
    $routes->connect('/admin/documents/nc_closure', ['controller' => 'Documents', 'action' => 'adminNcClosure']);
    $routes->connect('/admin/documents/receiving_insepction', ['controller' => 'Documents', 'action' => 'adminReceivingInsepction']);
    $routes->connect('/admin/documents/preventive_maintenance', ['controller' => 'Documents', 'action' => 'adminPreventiveMaintenance']);
    $routes->connect('/admin/documents/executive_duty_requisition', ['controller' => 'Documents', 'action' => 'adminExecutiveDutyRequisition']);
    $routes->connect('/admin/documents/calibration_equipment', ['controller' => 'Documents', 'action' => 'adminCalibrationEquipment']);

    // Admin Products menu (CategoriesController, ProductsController - no AdminController)
    $routes->connect('/admin/categories', ['controller' => 'Categories', 'action' => 'adminIndex']);
    $routes->connect('/admin/categories/add', ['controller' => 'Categories', 'action' => 'adminAdd']);
    $routes->connect('/admin/categories/edit/:id', ['controller' => 'Categories', 'action' => 'adminEdit'], ['pass' => ['id']]);
    $routes->connect('/admin/products', ['controller' => 'Products', 'action' => 'admin_index']);
    $routes->connect('/admin/products/label', ['controller' => 'Products', 'action' => 'admin_label']);
    $routes->connect('/admin/products/addlabel', ['controller' => 'Products', 'action' => 'admin_addlabel']);
    $routes->connect('/admin/products/editlabel/:id', ['controller' => 'Products', 'action' => 'admin_editlabel'], ['pass' => ['id']]);
    $routes->connect('/admin/products/deletelabel/:id', ['controller' => 'Products', 'action' => 'admin_deletelabel'], ['pass' => ['id']]);
    $routes->connect('/admin/products/edit_label', ['controller' => 'Products', 'action' => 'admin_edit_label']);
    $routes->connect('/admin/products/edit/:id', ['controller' => 'Products', 'action' => 'admin_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/products/project/:id', ['controller' => 'Products', 'action' => 'project'], ['pass' => ['id']]);
    $routes->connect('/admin/products/project/add/:id', ['controller' => 'Products', 'action' => 'adminProjectadd'], ['pass' => ['id']]);
    $routes->connect('/admin/products/voc_vertificate', ['controller' => 'Products', 'action' => 'adminVocVertificate']);

    // Admin Broucher Products (brochure products - sidebar "Broucher Product" -> Product List)
    $routes->connect('/admin/broucher_products', ['controller' => 'BroucherProducts', 'action' => 'admin_index']);
    $routes->connect('/admin/broucher_products/index', ['controller' => 'BroucherProducts', 'action' => 'admin_index']);
    $routes->connect('/admin/broucher_products/add', ['controller' => 'BroucherProducts', 'action' => 'admin_add']);
    $routes->connect('/admin/broucher_products/edit/:id', ['controller' => 'BroucherProducts', 'action' => 'admin_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/broucher_products/delete/:id', ['controller' => 'BroucherProducts', 'action' => 'admin_delete'], ['pass' => ['id']]);
    $routes->connect('/admin/broucher_products/project/:id', ['controller' => 'Products', 'action' => 'project'], ['pass' => ['id']]);
    $routes->connect('/admin/broucher_products/projectdelete/:product_id/:id', ['controller' => 'BroucherProducts', 'action' => 'admin_projectdelete'], ['pass' => ['product_id', 'id']]);

    // Admin Mailers (specification mailer, EOI, visitor, price list)
    $routes->connect('/admin/mailers', ['controller' => 'Mailers', 'action' => 'admin_index']);
    $routes->connect('/admin/mailers/visitor', ['controller' => 'Mailers', 'action' => 'admin_visitor']);
    $routes->connect('/admin/mailers/eoi', ['controller' => 'Mailers', 'action' => 'admin_eoi']);
    $routes->connect('/admin/mailers/eoisend', ['controller' => 'Mailers', 'action' => 'eoisend']);
    $routes->connect('/admin/mailers/index_v3', ['controller' => 'Mailers', 'action' => 'admin_index_v3']);
    $routes->connect('/admin/mailers/send_v3', ['controller' => 'Mailers', 'action' => 'admin_send_v3']);
    $routes->connect('/admin/mailers/editsend_v3/:id', ['controller' => 'Mailers', 'action' => 'admin_editsend_v3'], ['pass' => ['id']]);
    $routes->connect('/admin/mailers/send', ['controller' => 'Mailers', 'action' => 'admin_send']);
    $routes->connect('/admin/mailers/create_dwps', ['controller' => 'Mailers', 'action' => 'admin_create_dwps']);
    $routes->connect('/admin/mailers/create-dwps', ['controller' => 'Mailers', 'action' => 'admin_create_dwps']);
    $routes->connect('/admin/mailers/editv/:id', ['controller' => 'Mailers', 'action' => 'admin_editv'], ['pass' => ['id']]);
    $routes->connect('/admin/mailers/sendemail/:id', ['controller' => 'Mailers', 'action' => 'admin_sendemail'], ['pass' => ['id']]);
    $routes->connect('/admin/mailers/editsend/:id', ['controller' => 'Mailers', 'action' => 'admin_editsend'], ['pass' => ['id']]);
    $routes->connect('/admin/mailers/review_edit/:id', ['controller' => 'Mailers', 'action' => 'admin_review_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/mailers/approve/:id', ['controller' => 'Mailers', 'action' => 'admin_approve'], ['pass' => ['id']]);
    $routes->connect('/admin/mailers/list/:id/:newdiv', ['controller' => 'Mailers', 'action' => 'admin_list'], ['pass' => ['id', 'newdiv']]);
    $routes->connect('/admin/mailers/spec_index', ['controller' => 'Mailers', 'action' => 'admin_spec_index']);
    $routes->connect('/admin/mailers/emp_spec_index', ['controller' => 'Mailers', 'action' => 'admin_emp_spec_index']);
    $routes->connect('/admin/mailers/specRequest_index', ['controller' => 'Mailers', 'action' => 'admin_specRequest_index']);
    $routes->connect('/admin/mailers/specRequest_approved', ['controller' => 'Mailers', 'action' => 'admin_specRequest_approved']);
    $routes->connect('/admin/mailers/specRequest_disapproved', ['controller' => 'Mailers', 'action' => 'admin_specRequest_disapproved']);
    $routes->connect('/mailers/download/:id', ['controller' => 'Mailers', 'action' => 'download'], ['pass' => ['id']]);

    // Admin NATA (avoid "Controller Admin could not be found")
    $routes->connect('/admin/natas', ['controller' => 'Natas', 'action' => 'admin_index']);
    $routes->connect('/admin/natas/index/:nextdate', ['controller' => 'Natas', 'action' => 'admin_index'], ['pass' => ['nextdate']]);
    $routes->connect('/admin/natas/clienttype', ['controller' => 'Natas', 'action' => 'admin_clienttype']);
    $routes->connect('/admin/natas/clienttype_add', ['controller' => 'Natas', 'action' => 'admin_clienttype_add']);
    $routes->connect('/admin/natas/clienttype_edit/:id', ['controller' => 'Natas', 'action' => 'admin_clienttype_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/natas/addevent', ['controller' => 'Natas', 'action' => 'admin_addevent']);
    $routes->connect('/admin/natas/update/:id/:status', ['controller' => 'Natas', 'action' => 'admin_update'], ['pass' => ['id', 'status']]);

    // Admin Duro Orders (avoid "Controller Admin could not be found")
    $routes->connect('/admin/duro_orders', ['controller' => 'DuroOrders', 'action' => 'admin_index']);
    $routes->connect('/admin/duro_orders/index', ['controller' => 'DuroOrders', 'action' => 'admin_index']);
    $routes->connect('/admin/duro_orders/edit/:id', ['controller' => 'DuroOrders', 'action' => 'admin_edit'], ['pass' => ['id']]);

    // Staff panel Duro Orders (explicit routes so controller resolves to DuroOrders, not Duro_orders)
    $routes->connect('/duro_orders', ['controller' => 'DuroOrders', 'action' => 'index']);
    $routes->connect('/duro_orders/index', ['controller' => 'DuroOrders', 'action' => 'index']);
    $routes->connect('/duro_orders/add', ['controller' => 'DuroOrders', 'action' => 'add']);
    $routes->connect('/duro_orders/edit/:id', ['controller' => 'DuroOrders', 'action' => 'edit'], ['pass' => ['id']]);
    $routes->connect('/duro_orders/driver', ['controller' => 'DuroOrders', 'action' => 'driver']);
    $routes->connect('/duro_orders/editdriver/:id', ['controller' => 'DuroOrders', 'action' => 'editdriver'], ['pass' => ['id']]);
    $routes->connect('/duro_orders/delivery', ['controller' => 'DuroOrders', 'action' => 'delivery']);
    $routes->connect('/duro_orders/delivery_add', ['controller' => 'DuroOrders', 'action' => 'delivery_add']);
    $routes->connect('/duro_orders/delivery_edit/:id', ['controller' => 'DuroOrders', 'action' => 'delivery_edit'], ['pass' => ['id']]);
    $routes->connect('/duro_orders/delivery_delete/:id', ['controller' => 'DuroOrders', 'action' => 'delivery_delete'], ['pass' => ['id']]);

    // Staff panel Debit Collections (explicit routes so controller resolves to DebitCollections, not Debit_collections)
    $routes->connect('/debit_collections', ['controller' => 'DebitCollections', 'action' => 'index']);
    $routes->connect('/debit_collections/index', ['controller' => 'DebitCollections', 'action' => 'index']);
    $routes->connect('/debit_collections/addnew', ['controller' => 'DebitCollections', 'action' => 'addnew']);
    $routes->connect('/debit_collections/edit/:id', ['controller' => 'DebitCollections', 'action' => 'edit'], ['pass' => ['id']]);
    $routes->connect('/debit_collections/sendnotification', ['controller' => 'DebitCollections', 'action' => 'sendnotification']);
    $routes->connect('/debit_collections/send_notification', ['controller' => 'DebitCollections', 'action' => 'send_notification']);
    $routes->connect('/debit_collections/send_notification_second', ['controller' => 'DebitCollections', 'action' => 'send_notification_second']);
    $routes->connect('/debit_collections/send_notification_third', ['controller' => 'DebitCollections', 'action' => 'send_notification_third']);
    $routes->connect('/debit_collections/send_notification_fourth', ['controller' => 'DebitCollections', 'action' => 'send_notification_fourth']);

    // Staff panel Meets (minute meetings, staff in/out) – explicit routes so controller resolves to Meets
    $routes->connect('/meets', ['controller' => 'Meets', 'action' => 'meetingform']);
    $routes->connect('/meets/meetingform', ['controller' => 'Meets', 'action' => 'meetingform']);
    $routes->connect('/meets/informalmeeting', ['controller' => 'Meets', 'action' => 'informalmeeting']);
    $routes->connect('/meets/view/:id', ['controller' => 'Meets', 'action' => 'view'], ['pass' => ['id']]);
    $routes->connect('/meets/sendpdf/:referid', ['controller' => 'Meets', 'action' => 'sendpdf'], ['pass' => ['referid']]);
    $routes->connect('/meets/staffinoutlist', ['controller' => 'Meets', 'action' => 'staffinoutlist']);
    $routes->connect('/meets/sendurl', ['controller' => 'Meets', 'action' => 'sendurl']);
    $routes->connect('/meets/autologin/:unique_id/:user_id', ['controller' => 'Meets', 'action' => 'autologin'], ['pass' => ['unique_id', 'user_id']]);
    $routes->connect('/meets/noexist/:referid', ['controller' => 'Meets', 'action' => 'noexist'], ['pass' => ['referid']]);
    $routes->connect('/meets/staffinout/:referid', ['controller' => 'Meets', 'action' => 'staffinout'], ['pass' => ['referid']]);
    $routes->connect('/meets/starttime/:id/:name/:phone', ['controller' => 'Meets', 'action' => 'starttime'], ['pass' => ['id', 'name', 'phone']]);
    $routes->connect('/meets/newtemplate', ['controller' => 'Meets', 'action' => 'newtemplate']);

    // Admin Sales (sales staff, attendance, dashboard, reports)
    $routes->connect('/admin/sales', ['controller' => 'Sales', 'action' => 'admin_index']);
    $routes->connect('/admin/sales/index', ['controller' => 'Sales', 'action' => 'admin_index']);
    $routes->connect('/admin/sales/attendance', ['controller' => 'Sales', 'action' => 'admin_attendance']);
    $routes->connect('/admin/sales/attendance_report/:staff_id', ['controller' => 'Sales', 'action' => 'admin_attendance_report'], ['pass' => ['staff_id']]);
    $routes->connect('/admin/sales/saledasboard', ['controller' => 'Sales', 'action' => 'admin_saledasboard']);
    $routes->connect('/admin/sales/report/:staff_id', ['controller' => 'Sales', 'action' => 'admin_report'], ['pass' => ['staff_id']]);
    $routes->connect('/admin/sales/settarget/:staff_id', ['controller' => 'Sales', 'action' => 'admin_settarget'], ['pass' => ['staff_id']]);
    $routes->connect('/admin/sales/salereminder', ['controller' => 'Sales', 'action' => 'admin_salereminder']);
    $routes->connect('/admin/sales/salesreport/:unique_id', ['controller' => 'Sales', 'action' => 'admin_salesreport'], ['pass' => ['unique_id']]);

    // Admin Productions (Batch Register / Batch Count Sheet)
    $routes->connect('/admin/productions', ['controller' => 'Productions', 'action' => 'adminIndex']);
    $routes->connect('/admin/productions/index', ['controller' => 'Productions', 'action' => 'adminIndex']);
    $routes->connect('/admin/productions/batch_register_add', ['controller' => 'Productions', 'action' => 'adminBatchRegisterAdd']);
    $routes->connect('/admin/productions/batch_register_edit/:id', ['controller' => 'Productions', 'action' => 'adminBatchRegisterEdit'], ['pass' => ['id']]);
    $routes->connect('/admin/productions/batch_count_sheet', ['controller' => 'Productions', 'action' => 'adminBatchCountSheet']);

    // Admin POS (DT PO - Purchase Orders)
    $routes->connect('/admin/pos', ['controller' => 'Pos', 'action' => 'admin_index']);
    $routes->connect('/admin/pos/index', ['controller' => 'Pos', 'action' => 'admin_index']);

    // Admin Fronts (Push Notifications)
    $routes->connect('/admin/fronts', ['controller' => 'Fronts', 'action' => 'admin_index']);
    $routes->connect('/admin/fronts/index', ['controller' => 'Fronts', 'action' => 'admin_index']);
    $routes->connect('/admin/fronts/send', ['controller' => 'Fronts', 'action' => 'admin_send']);
    $routes->connect('/admin/fronts/delete/:id', ['controller' => 'Fronts', 'action' => 'admin_delete'], ['pass' => ['id']]);

    // Staff POS (DT PO - Purchase Orders)
    $routes->connect('/pos', ['controller' => 'Pos', 'action' => 'index']);
    $routes->connect('/pos/index', ['controller' => 'Pos', 'action' => 'index']);
    $routes->connect('/pos/add', ['controller' => 'Pos', 'action' => 'add']);
    $routes->connect('/pos/edit/:id', ['controller' => 'Pos', 'action' => 'edit'], ['pass' => ['id']]);

    // Admin Clients (Sales menu – customer list, categories, comments, assign)
    $routes->connect('/admin/clients', ['controller' => 'Clients', 'action' => 'admin_index']);
    $routes->connect('/admin/clients/index', ['controller' => 'Clients', 'action' => 'admin_index']);
    $routes->connect('/admin/clients/index/:id', ['controller' => 'Clients', 'action' => 'admin_index'], ['pass' => ['id']]);
    $routes->connect('/admin/clients/add', ['controller' => 'Clients', 'action' => 'admin_add']);
    $routes->connect('/admin/clients/edit/:id', ['controller' => 'Clients', 'action' => 'admin_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/clients/import', ['controller' => 'Clients', 'action' => 'admin_import']);
    $routes->connect('/admin/clients/assign', ['controller' => 'Clients', 'action' => 'admin_assign']);
    $routes->connect('/admin/clients/clienttype', ['controller' => 'Clients', 'action' => 'admin_clienttype']);
    $routes->connect('/admin/clients/clienttype_add', ['controller' => 'Clients', 'action' => 'admin_clienttype_add']);
    $routes->connect('/admin/clients/clienttype_edit/:id', ['controller' => 'Clients', 'action' => 'admin_clienttype_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/clients/comment/:client_id', ['controller' => 'Clients', 'action' => 'admin_comment'], ['pass' => ['client_id']]);
    $routes->connect('/admin/clients/addcomment/:client_id', ['controller' => 'Clients', 'action' => 'admin_addcomment'], ['pass' => ['client_id']]);
    $routes->connect('/admin/clients/commentdownload/:id', ['controller' => 'Clients', 'action' => 'admin_commentdownload'], ['pass' => ['id']]);

    // Staff clients (sales person customer list)
    $routes->connect('/clients', ['controller' => 'Clients', 'action' => 'index']);
    $routes->connect('/clients/index', ['controller' => 'Clients', 'action' => 'index']);
    $routes->connect('/clients/index/:id', ['controller' => 'Clients', 'action' => 'index'], ['pass' => ['id']]);
    $routes->connect('/clients/add', ['controller' => 'Clients', 'action' => 'add']);
    $routes->connect('/clients/edit/:id', ['controller' => 'Clients', 'action' => 'edit'], ['pass' => ['id']]);
    $routes->connect('/clients/comment/:client_id', ['controller' => 'Clients', 'action' => 'comment'], ['pass' => ['client_id']]);
    $routes->connect('/clients/addcomment/:client_id', ['controller' => 'Clients', 'action' => 'addcomment'], ['pass' => ['client_id']]);

    // Admin Material Orders (avoid "Controller Admin could not be found")
    $routes->connect('/admin/materials', ['controller' => 'Materials', 'action' => 'admin_index']);
    $routes->connect('/admin/materials/index', ['controller' => 'Materials', 'action' => 'admin_index']);
    $routes->connect('/admin/materials/add', ['controller' => 'Materials', 'action' => 'admin_add']);
    $routes->connect('/admin/materials/edit/:id', ['controller' => 'Materials', 'action' => 'admin_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/materials/order/:type', ['controller' => 'Materials', 'action' => 'admin_order'], ['pass' => ['type']]);
    $routes->connect('/admin/materials/status/:status/:orderid/:type', ['controller' => 'Materials', 'action' => 'admin_status'], ['pass' => ['status', 'orderid', 'type']]);
    $routes->connect('/admin/materials/autologin/:id', ['controller' => 'Materials', 'action' => 'admin_autologin'], ['pass' => ['id']]);

    // Staff/material order routes (staff portal and public readqrcode/success)
    $routes->connect('/materials', ['controller' => 'Materials', 'action' => 'index']);
    $routes->connect('/materials/index', ['controller' => 'Materials', 'action' => 'index']);
    $routes->connect('/materials/order/:type', ['controller' => 'Materials', 'action' => 'order'], ['pass' => ['type']]);
    $routes->connect('/materials/status/:status/:orderid/:type', ['controller' => 'Materials', 'action' => 'status'], ['pass' => ['status', 'orderid', 'type']]);
    $routes->connect('/materials/update/:status/:orderid/:type', ['controller' => 'Materials', 'action' => 'update'], ['pass' => ['status', 'orderid', 'type']]);
    $routes->connect('/materials/readqrcode/:qrcode', ['controller' => 'Materials', 'action' => 'readqrcode'], ['pass' => ['qrcode']]);
    $routes->connect('/materials/success', ['controller' => 'Materials', 'action' => 'success']);
    $routes->connect('/materials/autologin/:id', ['controller' => 'Materials', 'action' => 'autologin'], ['pass' => ['id']]);
    $routes->connect('/materials/signature', ['controller' => 'Materials', 'action' => 'signature']);

    // Staff Productions (Batch Register / Batch Count Sheet)
    $routes->connect('/productions', ['controller' => 'Productions', 'action' => 'index']);
    $routes->connect('/productions/index', ['controller' => 'Productions', 'action' => 'index']);
    $routes->connect('/productions/batch_register_add', ['controller' => 'Productions', 'action' => 'batchRegisterAdd']);
    $routes->connect('/productions/batch_register_edit/:id', ['controller' => 'Productions', 'action' => 'batchRegisterEdit'], ['pass' => ['id']]);
    $routes->connect('/productions/batch_count_sheet', ['controller' => 'Productions', 'action' => 'batchCountSheet']);
    $routes->connect('/productions/batch_count_sheet_add', ['controller' => 'Productions', 'action' => 'batchCountSheetAdd']);
    $routes->connect('/productions/batch_count_sheet_edit/:id', ['controller' => 'Productions', 'action' => 'batchCountSheetEdit'], ['pass' => ['id']]);

    $routes->connect('/', ['controller' => 'Fronts', 'action' => 'index']);

    $routes->connect('/product', ['controller' => 'Products', 'action' => 'index']);
    $routes->connect('/files/category/*', ['controller' => 'Categories', 'action' => 'serveImage']);
    $routes->connect('/category/:slug', [
        'controller' => 'Products',
        'action' => 'index',
    ], ['pass' => ['slug']]);
    $routes->connect('/product/:slug', [
        'controller' => 'Products',
        'action' => 'detail',
    ], ['pass' => ['slug']]);
    // Admin product edit (support both /products/edit/:id and /admin/products/edit/:id)
    $routes->connect('/products/edit/:id', ['controller' => 'Products', 'action' => 'admin_edit'], ['pass' => ['id']]);
    $routes->connect('/products/project/:id', ['controller' => 'Products', 'action' => 'project'], ['pass' => ['id']]);
    $routes->connect('/products/delete/:id', ['controller' => 'Products', 'action' => 'delete'], ['pass' => ['id']]);

    // ---------- STATIC PAGES ----------
    $routes->connect('/health-safety', ['controller' => 'Fronts', 'action' => 'healthSafety']);
    $routes->connect('/specification', ['controller' => 'Fronts', 'action' => 'specification']);
    $routes->connect('/specifiers', ['controller' => 'Fronts', 'action' => 'specification']);
    $routes->connect('/about', ['controller' => 'Fronts', 'action' => 'about']);

    $routes->connect('/projects', ['controller' => 'Fronts', 'action' => 'projects']);
    $routes->connect('/faqs', ['controller' => 'Fronts', 'action' => 'faq']);
    $routes->connect('/contact', ['controller' => 'Fronts', 'action' => 'contact']);
    $routes->connect('/fronts/captch', ['controller' => 'Fronts', 'action' => 'captch']);

    // ---------- CASE STUDY ----------
    $routes->connect(
        '/case-study/:slug',
        ['controller' => 'Fronts', 'action' => 'caseStudy'],
        ['pass' => ['slug']]
    );
    // Admin Case Studies (avoid "Controller class Admin could not be found")
    $routes->connect('/admin/case_studies', ['controller' => 'CaseStudies', 'action' => 'adminIndex']);
    $routes->connect('/admin/case_studies/add', ['controller' => 'CaseStudies', 'action' => 'adminAdd']);
    $routes->connect('/admin/case_studies/edit/:id', ['controller' => 'CaseStudies', 'action' => 'adminEdit'], ['pass' => ['id']]);
    $routes->connect('/admin/case_studies/delete/:id', ['controller' => 'CaseStudies', 'action' => 'adminDelete'], ['pass' => ['id']]);
    $routes->connect('/admin/case_studies/view/:slug', ['controller' => 'CaseStudies', 'action' => 'adminView'], ['pass' => ['slug']]);
    $routes->connect('/admin/case_studies/approve/:id', ['controller' => 'CaseStudies', 'action' => 'adminApprove'], ['pass' => ['id']]);
    $routes->connect('/admin/case_studies/delete_image/:id', ['controller' => 'CaseStudies', 'action' => 'adminDeleteImage'], ['pass' => ['id']]);
    $routes->connect('/admin/case_studies/admin-delete-image/:id', ['controller' => 'CaseStudies', 'action' => 'adminDeleteImage'], ['pass' => ['id']]);

    // ---------- FILES: all /files/* go to ProductsController (never FilesController) ----------
    $routes->connect('/files/datasheets/*', [
        'controller' => 'Products',
        'action' => 'serveDatasheet',
    ]);
    $routes->connect('/files/vocsheets/*', [
        'controller' => 'Products',
        'action' => 'serveVocsheet',
    ]);
    $routes->connect('/files/colour_charts/*', [
        'controller' => 'Products',
        'action' => 'serveColourChart',
    ]);
    // Catch-all: /files/view/123 or any other /files/... so we never hit missing FilesController
    $routes->connect('/files/*', [
        'controller' => 'Products',
        'action' => 'serveFileLegacy',
    ]);
    // Product PDFs in webroot/dompdf/ (e.g. /dompdf/22-DTSPEC 19-03-004.pdf)
    $routes->connect('/dompdf/*', [
        'controller' => 'Products',
        'action' => 'serveDompdf',
    ]);
    // Product datasheets in webroot/wp-content/uploads/datasheet/ (DB: /wp-content/uploads/datasheet/xxxxx.pdf)
    $routes->connect('/wp-content/uploads/datasheet/*', [
        'controller' => 'Products',
        'action' => 'serveWpDatasheet',
    ]);
    // Product MSDS files in webroot/uploads/msds/
    $routes->connect('/uploads/msds/*', [
        'controller' => 'Products',
        'action' => 'serveMsds',
    ]);
    // Product MSDS files in webroot/wp-content/uploads/msds/ (DB: /wp-content/uploads/msds/xxxxx.pdf)
    $routes->connect('/wp-content/uploads/msds/*', [
        'controller' => 'Products',
        'action' => 'serveWpMsds',
    ]);
    // Catch-all for other wp-content/uploads/* files (brochures, PDFs, etc.)
    $routes->connect('/wp-content/uploads/*', [
        'controller' => 'Products',
        'action' => 'serveWpUploads',
    ]);

    // ---------- PRODUCT / DOWNLOAD ----------
    $routes->connect('/color-chart/download', ['controller' => 'Products', 'action' => 'download']);
    $routes->connect('/col-chart.jpg', ['controller' => 'Products', 'action' => 'downloadImage']);
    $routes->connect('/col-chartds.jpg', ['controller' => 'Products', 'action' => 'downloadImgchart']);

    // ---------- WATERPROOFING ----------
    $routes->connect('/terrace-waterproofing', ['controller' => 'Fronts', 'action' => 'terraceWaterproofing']);
    $routes->connect('/retaining-walls', ['controller' => 'Fronts', 'action' => 'retainingWalls']);

    // ---------- MISC ----------
    $routes->connect('/tmclead', ['controller' => 'Fronts', 'action' => 'newlead']);
    $routes->connect('/technical-literature/*', ['controller' => 'Fronts', 'action' => 'technicalLiteratureNew']);

    $routes->connect('/durooem', ['controller' => 'Fronts', 'action' => 'durooem']);
    $routes->connect('/durolab', ['controller' => 'Fronts', 'action' => 'durolab']);
    $routes->connect('/flake', ['controller' => 'Fronts', 'action' => 'flake']);
    $routes->connect('/video', ['controller' => 'Fronts', 'action' => 'video']);

    // Admin Stocks (index by type, Warranty Request, Product Warranty Request)
    $routes->connect('/admin/stocks', ['controller' => 'Stocks', 'action' => 'admin_index']);
    $routes->connect('/admin/stocks/index', ['controller' => 'Stocks', 'action' => 'admin_index']);
    $routes->connect('/admin/stocks/index/:type', ['controller' => 'Stocks', 'action' => 'admin_index'], ['pass' => ['type']]);
    $routes->connect('/admin/stocks/status/:status/:id/:type', ['controller' => 'Stocks', 'action' => 'admin_status'], ['pass' => ['status', 'id', 'type']]);
    $routes->connect('/admin/stocks/delete/:id/:type', ['controller' => 'Stocks', 'action' => 'admin_delete'], ['pass' => ['id', 'type']]);
    $routes->connect('/admin/stocks/comment/:id', ['controller' => 'Stocks', 'action' => 'admin_comment'], ['pass' => ['id']]);
    $routes->connect('/admin/stocks/warrant_request', ['controller' => 'Stocks', 'action' => 'admin_warrant_request']);
    $routes->connect('/admin/stocks/preview_warranty_certificate/:id', ['controller' => 'Stocks', 'action' => 'admin_preview_warranty_certificate'], ['pass' => ['id']]);
    $routes->connect('/admin/stocks/approve_warranty_request/:id', ['controller' => 'Stocks', 'action' => 'admin_approve_warranty_request'], ['pass' => ['id']]);
    $routes->connect('/admin/stocks/product_warranty_request', ['controller' => 'Stocks', 'action' => 'admin_product_warranty_request']);
    $routes->connect('/admin/stocks/preview_product_warranty_certificate/:id', ['controller' => 'Stocks', 'action' => 'admin_preview_product_warranty_certificate'], ['pass' => ['id']]);
    $routes->connect('/admin/stocks/delete_product_warranty/:id', ['controller' => 'Stocks', 'action' => 'admin_delete_product_warranty'], ['pass' => ['id']]);
    $routes->connect('/admin/stocks/approveWarranty', ['controller' => 'Stocks', 'action' => 'admin_approve_warranty']);
    $routes->connect('/admin/stocks/admin-approve-warranty', ['controller' => 'Stocks', 'action' => 'admin_approve_warranty']);
    $routes->connect('/admin/stocks/sendformtocsutomer/:id', ['controller' => 'Stocks', 'action' => 'admin_sendformtocsutomer'], ['pass' => ['id']]);

    $routes->connect('/warranty/*', ['controller' => 'Stocks', 'action' => 'warranty']);
    $routes->connect('/product_warranty', ['controller' => 'Fronts', 'action' => 'productWarranty']);

    $routes->connect('/durotech-institute-of-waterproofing', [
        'controller' => 'Fronts',
        'action' => 'instituteWaterproofing'
    ]);

    $routes->connect('/chatbot', ['controller' => 'ChatBot', 'action' => 'chatbot']);

    $routes->connect('/testimonials', ['controller' => 'Fronts', 'action' => 'testimonials']);

    // Admin Testimonials (avoid "Controller class Admin could not be found")
    $routes->connect('/admin/testimonials', ['controller' => 'Testimonials', 'action' => 'admin_index']);
    $routes->connect('/admin/testimonials/add', ['controller' => 'Testimonials', 'action' => 'admin_add']);
    $routes->connect('/admin/testimonials/edit/:id', ['controller' => 'Testimonials', 'action' => 'admin_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/testimonials/delete/:id', ['controller' => 'Testimonials', 'action' => 'admin_delete'], ['pass' => ['id']]);
    $routes->connect('/admin/testimonials/toggle-status/:id', ['controller' => 'Testimonials', 'action' => 'admin_toggleStatus'], ['pass' => ['id']]);

    // Admin Tasks (DuroLab)
    $routes->connect('/admin/tasks/type', ['controller' => 'Tasks', 'action' => 'admin_type']);
    $routes->connect('/admin/tasks/type/:data', ['controller' => 'Tasks', 'action' => 'admin_type'], ['pass' => ['data']]);
    $routes->connect('/admin/tasks', ['controller' => 'Tasks', 'action' => 'admin_index']);
    $routes->connect('/admin/tasks/index', ['controller' => 'Tasks', 'action' => 'admin_index']);
    $routes->connect('/admin/tasks/add', ['controller' => 'Tasks', 'action' => 'admin_add']);
    $routes->connect('/admin/tasks/edit/:id', ['controller' => 'Tasks', 'action' => 'admin_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/tasks/assign/:task_id', ['controller' => 'Tasks', 'action' => 'admin_assign'], ['pass' => ['task_id']]);
    $routes->connect('/admin/tasks/completetask/:task_id/:status', ['controller' => 'Tasks', 'action' => 'admin_completetask'], ['pass' => ['task_id', 'status']]);
    $routes->connect('/admin/tasks/comment/:task_id', ['controller' => 'Tasks', 'action' => 'admin_comment'], ['pass' => ['task_id']]);
    $routes->connect('/admin/tasks/taskdocument/:task_id', ['controller' => 'Tasks', 'action' => 'admin_taskdocument'], ['pass' => ['task_id']]);
    $routes->connect('/admin/tasks/uploaddoc/:task_id', ['controller' => 'Tasks', 'action' => 'admin_uploaddoc'], ['pass' => ['task_id']]);
    $routes->connect('/admin/tasks/download/:id', ['controller' => 'Tasks', 'action' => 'admin_download'], ['pass' => ['id']]);
    $routes->connect('/admin/tasks/commentdownload/:id', ['controller' => 'Tasks', 'action' => 'admin_commentdownload'], ['pass' => ['id']]);
    $routes->connect('/admin/tasks/delete/:id', ['controller' => 'Tasks', 'action' => 'admin_delete'], ['pass' => ['id']]);
    $routes->connect('/admin/tasks/adminautologin/:user_id/:type/:param', ['controller' => 'Tasks', 'action' => 'adminautologin'], ['pass' => ['user_id', 'type', 'param']]);

    // Admin COA (Duro COA)
    $routes->connect('/admin/coas', ['controller' => 'Coas', 'action' => 'admin_index']);
    $routes->connect('/admin/coas/create', ['controller' => 'Coas', 'action' => 'admin_create']);
    $routes->connect('/admin/coas/edit/:id', ['controller' => 'Coas', 'action' => 'admin_edit'], ['pass' => ['id']]);
    $routes->connect('/admin/coas/sendemail/:id', ['controller' => 'Coas', 'action' => 'admin_sendemail'], ['pass' => ['id']]);
    $routes->connect('/admin/coas/download/:id', ['controller' => 'Coas', 'action' => 'admin_download'], ['pass' => ['id']]);

    // Admin Hero Sections
    $routes->connect('/admin/hero_sections', ['controller' => 'HeroSections', 'action' => 'admin_index']);
    $routes->connect('/admin/hero_sections/manage', ['controller' => 'HeroSections', 'action' => 'admin_manage']);
    $routes->connect('/admin/hero_sections/manage/:id', ['controller' => 'HeroSections', 'action' => 'admin_manage'], ['pass' => ['id']]);
    $routes->connect('/admin/hero_sections/delete/:id', ['controller' => 'HeroSections', 'action' => 'admin_delete'], ['pass' => ['id']]);

    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /*
     * Price-list PDF tokens: LabFile.dir values often look like "Durotech…labelprice".
     * Old/wrong links used SITEURL+dir only, so the app saw /{dir} as a controller name.
     * Map /anything-ending-with-labelprice -> Users::labelpdffile($dir).
     */
    $routes->connect(
        '/:dir',
        ['controller' => 'Users', 'action' => 'labelpdffile'],
        [
            'pass' => ['dir'],
            'dir' => '[^/]+labelprice',
        ]
    );

    /*
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *
     * ```
     * $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
     * $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
     * ```
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * Router::scope('/api', function (RouteBuilder $routes) {
 *     // No $routes->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */
