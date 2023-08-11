<?php
declare(strict_types=1);

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
require __DIR__ . DIRECTORY_SEPARATOR . 'paths.php';

/*
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Database\Type\StringType;
use Cake\Database\TypeFactory;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorTrap;
use Cake\Error\ExceptionTrap;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\Routing\Router;
use Cake\Utility\Security;

/*
 * See https://github.com/josegonzalez/php-dotenv for API details.
 *
 * Uncomment block of code below if you want to use `.env` file during development.
 * You should copy `config/.env.example` to `config/.env` and set/modify the
 * variables as required.
 *
 * The purpose of the .env file is to emulate the presence of the environment
 * variables like they would be present in production.
 *
 * If you use .env files, be careful to not commit them to source control to avoid
 * security risks. See https://github.com/josegonzalez/php-dotenv#general-security-information
 * for more information for recommended practices.
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
 * Notice: For security reasons app_local.php **should not** be included in your git repo.
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
(new ErrorTrap(Configure::read('Error')))->register();
(new ExceptionTrap(Configure::read('Error')))->register();

/*
 * Include the CLI bootstrap overrides.
 */
if (PHP_SAPI === 'cli') {
    require CONFIG . 'bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 */
$fullBaseUrl = Configure::read('App.fullBaseUrl');
if (!$fullBaseUrl) {
    /*
     * When using proxies or load balancers, SSL/TLS connections might
     * get terminated before reaching the server. If you trust the proxy,
     * you can enable `$trustProxy` to rely on the `X-Forwarded-Proto`
     * header to determine whether to generate URLs using `https`.
     *
     * See also https://book.cakephp.org/4/en/controllers/request-response.html#trusting-proxy-headers
     */
    $trustProxy = false;

    $s = null;
    if (env('HTTPS') || ($trustProxy && env('HTTP_X_FORWARDED_PROTO') === 'https')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        $fullBaseUrl = 'http' . $s . '://' . $httpHost;
    }
    unset($httpHost, $s);
}
if ($fullBaseUrl) {
    Router::fullBaseUrl($fullBaseUrl);
}
unset($fullBaseUrl);


Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
TransportFactory::setConfig(Configure::consume('EmailTransport'));
Mailer::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::setSalt(Configure::consume('Security.salt'));
/*
 * Setup detectors for mobile and tablet.
 * If you don't use these checks you can safely remove this code
 * and the mobiledetect package from composer.json.
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
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
// \Cake\Database\TypeFactory::build('time')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('date')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('datetime')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('timestamp')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('datetimefractional')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('timestampfractional')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('datetimetimezone')
//    ->useLocaleParser();
// \Cake\Database\TypeFactory::build('timestamptimezone')
//    ->useLocaleParser();

// There is no time-specific type in Cake
TypeFactory::map('time', StringType::class);

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['dontinflectme']);




Configure::write('gmapKey', 'AIzaSyD2EC1RqRSh1Rm6NC4_cMt2CHtrZBKzUTE');

Configure::write('roles', [
	'admin.root'=>'admin.root', 

]);
Configure::write('AdminRoles', [
	'admin.root'=>'admin.root', 

]);

Configure::write('languages', [1=>'ar', 2=>'en', 3=>'ru']);
Configure::write('languages_ids', ['ar'=>1, 'en'=>2, 'ru'=>3]);
Configure::write('app_folder',  in_array(env('SERVER_NAME'), ['localhost', 'devzonia.com']) ? '/'.basename(dirname(__DIR__))  : '' );
Configure::write('isLocal',  in_array(env('SERVER_NAME'), ['localhost']) ? true : false );


Configure::write('targetTables', ['Sales'=>'Sales','Clients'=>'Clients']);
Configure::write('current_stage', [3=>'CC',4=>'Supervisior']);
Configure::write('statusID', [ 1=>'isNew', 2=>'isCalled', 3=>'isSpoken', 4=>'isMessaged', 5=>'isWhatsapped', 6=>'noSale', 7=>'cancelled']);
Configure::write('currencies', [4=>'GBP', 1=>'EUR', 2=>'USD', 3=>'TRY']);
Configure::write('currencies_icons', [4=>'£', 1=>'€', 2=>'$', 3=>'₺']);
Configure::write('stats', [[0=>__("disabled"), 1=>__("enabled"), 2=>__('sold')]]);
Configure::write('clientSpecs', [
    ['spec_name' => 'Address', 'spec_value' => ''],
    ['spec_name' => 'Email', 'spec_value' => ''],
    ['spec_name' => 'Mobile', 'spec_value' => ''],
    ['spec_name' => 'Phone', 'spec_value' => ''],
    ['spec_name' => 'Country', 'spec_value' => ''],
    ['spec_name' => 'City', 'spec_value' => ''],
]);
Configure::write('clientspecs', [
    'Address'=>'Address','Mobile'=>'Mobile','Email'=>'Email','Email Secondary 1'=>'Email Secondary 1','Email Secondary 2'=>'Email Secondary 2','Telephone'=>'Telephone','Origin Counrty'=>'Origin Counrty','Country'=>'Country','City'=>'City','Area'=>'Area','Source of Query'=>'Source of Query','Referred To'=>'Referred To','Sale Agent'=>'Sale Agent','Next Call Date'=>'Next Call Date','Support Manager Next Call Date'=>'Support Manager Next Call Date','Booking Date'=>'Booking Date','Client Category'=>'Client Category','Priorty'=>'Priorty','Verified'=>'Verified'
]);

Configure::write('ROLES', [
	'admin.root'=>[//     (technical top level admin) 
		'categories'=>['create'=>1, 'read'=>1, 'update'=>1, 'delete'=>1, 'allids'=>1],
		'contents'=>['create'=>1, 'read'=>1, 'update'=>1, 'delete'=>1, 'allids'=>1],
		'configs'=>['create'=>1, 'read'=>1, 'update'=>1, 'delete'=>1, 'allids'=>1],
		'users'=>['create'=>1, 'read'=>1, 'update'=>1, 'delete'=>1, 'allids'=>1],
		'logs'=>['create'=>1, 'read'=>1, 'update'=>1, 'delete'=>1, 'allids'=>1],
		'clients'=>['create'=>1, 'read'=>1, 'update'=>1, 'delete'=>1, 'allids'=>1],
        'sales'=>['create'=>1, 'read'=>1, 'update'=>1, 'delete'=>1, 'allids'=>1],
        'permissions'=>['create'=>1, 'read'=>1, 'update'=>1, 'delete'=>1, 'allids'=>1],
	],
    
]);
$features_categories = [
];
Configure::write('FEATURES_CATEGORIES', $features_categories);