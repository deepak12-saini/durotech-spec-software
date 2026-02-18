<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

/*
 * Configure paths required to find CakePHP + general filepath constants
 */
require __DIR__ . '/paths.php';

/*
 * Bootstrap CakePHP (only if not already loaded by webroot/index.php).
 * Prevents "Constant TIME_START already defined" and basics.php constant notices.
 */
if (!defined('TIME_START')) {
    require CORE_PATH . 'config' . DS . 'bootstrap.php';
}

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\Utility\Inflector;
use Cake\Utility\Security;

/*
 * Uncomment block of code below if you want to use `.env` file during development.
 * You should copy `config/.env.example` to `config/.env` and set/modify the
 * variables as required.
 *
 * It is HIGHLY discouraged to use a .env file in production, due to security risks
 * and decreased performance on each request. The purpose of the .env file is to emulate
 * the presence of the environment variables like they would be present in production.
 */
// if (!env('APP_NAME') && file_exists(CONFIG . '.env')) {
//     $dotenv = new \josegonzalez\Dotenv\Loader([CONFIG . '.env']);
//     $dotenv->parse()
//         ->putenv()
//         ->toEnv()
//         ->toServer();
// }

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

/*
 * Load an environment local configuration file to provide overrides to your configuration.
 * Notice: For security reasons app_local.php will not be included in your git repo.
 */
if (file_exists(CONFIG . 'app_local.php')) {
    Configure::load('app_local', 'default');
}

/*
 * When debug = true the metadata cache should only last
 * for a short time.
 */
if (Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+2 minutes');
    Configure::write('Cache._cake_core_.duration', '+2 minutes');
    // disable router cache during development
    Configure::write('Cache._cake_routes_.duration', '+2 seconds');
}

/*
 * Set the default server timezone. Using UTC makes time calculations / conversions easier.
 * Check http://php.net/manual/en/timezones.php for list of valid timezone strings.
 */
date_default_timezone_set(Configure::read('App.defaultTimezone'));

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Register application error and exception handlers.
 */
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new ErrorHandler(Configure::read('Error')))->register();
}

/*
 * Include the CLI bootstrap overrides.
 */
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links (e.g. SITEURL for assets).
 * When the app is in a subfolder (e.g. /cake3app/), include that path so CSS/JS/images load correctly.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    $baseUrl = 'http' . $s . '://' . (isset($httpHost) ? $httpHost : 'localhost');

    // Include subdirectory path when app is not at document root (e.g. /cake3app/)
    $scriptName = env('SCRIPT_NAME', '');
    if ($scriptName !== '') {
        $basePath = str_replace('\\', '/', dirname($scriptName));
        if ($basePath !== '/' && $basePath !== '') {
            $baseUrl .= $basePath;
        }
    }
    Configure::write('App.fullBaseUrl', $baseUrl);
    unset($httpHost, $s, $scriptName, $basePath, $baseUrl);
}

Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
TransportFactory::setConfig(Configure::consume('EmailTransport'));
Email::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::setSalt(Configure::consume('Security.salt'));

/*
 * Site constants for Fronts layouts/views (CakePHP 2 compatibility).
 */
if (!defined('SITEURL')) {
    $baseUrl = Configure::read('App.fullBaseUrl');
    define('SITEURL', $baseUrl ? rtrim($baseUrl, '/') . '/' : '/');
}
if (!defined('SITENAME')) {
    define('SITENAME', Configure::read('Site.name') ?: 'Durotech Industries');
}
if (!defined('META_TITLE')) {
    define('META_TITLE', Configure::read('Site.metaTitle') ?: 'Durotech Industries');
}
if (!defined('META_DESCRIPTION')) {
    define('META_DESCRIPTION', Configure::read('Site.metaDescription') ?: '');
}
if (!defined('META_KEYWORD')) {
    define('META_KEYWORD', Configure::read('Site.metaKeyword') ?: '');
}
if (!defined('MAILTO')) {
    define('MAILTO', Configure::read('Site.email') ?: 'info@durotechindustries.com.au');
}
if (!defined('PHONE')) {
    define('PHONE', Configure::read('Site.phone') ?: '1300 434 272');
}
if (!defined('ADDRESS')) {
    define('ADDRESS', Configure::read('Site.address') ?: '12 Production Ave, Taren Point NSW 2229, Australia');
}
if (!defined('EMAIL')) {
    define('EMAIL', Configure::read('Site.email') ?: 'info@durotechindustries.com.au');
}
if (!defined('FACEBOOK')) {
    define('FACEBOOK', Configure::read('Site.facebook') ?: 'https://www.facebook.com/durotechindustries');
}
if (!defined('TWITER')) {
    define('TWITER', Configure::read('Site.twitter') ?: 'https://twitter.com/durotech');
}
if (!defined('GOOGLE_PLUS')) {
    define('GOOGLE_PLUS', Configure::read('Site.googlePlus') ?: 'https://plus.google.com/durotech');
}

/*
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
//Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/*
 * Setup detectors for mobile and tablet.
 */
ServerRequest::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
ServerRequest::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link https://book.cakephp.org/3/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
Type::build('time')
    ->useImmutable();
Type::build('date')
    ->useImmutable();
Type::build('datetime')
    ->useImmutable();
Type::build('timestamp')
    ->useImmutable();

/*
 * Use SafeIntegerType so integer columns never throw on non-numeric strings
 * (e.g. empty string or bad data from DB/forms).
 */
Type::map('integer', \App\Database\Type\SafeIntegerType::class);
Type::map('tinyinteger', \App\Database\Type\SafeIntegerType::class);
Type::map('smallinteger', \App\Database\Type\SafeIntegerType::class);
Type::map('biginteger', \App\Database\Type\SafeIntegerType::class);

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['dontinflectme']);
//Inflector::rules('transliteration', ['/å/' => 'aa']);
