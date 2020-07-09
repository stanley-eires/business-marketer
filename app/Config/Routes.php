<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('login', 'Home::login');
$routes->post('login', 'Home::attemptLogin');
$routes->get('logout', 'Home::logout');



$routes->group('bulk', ["filter"=>"authorizedonly"],function ($routes) {
	$routes->get('', 'Bulk::compose');
	$routes->post('', 'Bulk::sendCompose');
	$routes->post('send-email', 'Bulk::sendEmailCompose');

	$routes->get('draft', 'Bulk::draft');
	$routes->post('draft', 'Bulk::saveDraft');
	$routes->delete('draft', 'Bulk::deleteDraft');
	$routes->put('draft', 'Bulk::updateDraft');

	$routes->post('email-draft', 'Bulk::saveEmailDraft');
	$routes->delete('email-draft', 'Bulk::deleteEmailDraft');
	
	$routes->get('history', 'Bulk::history');
	$routes->delete('history', 'Bulk::deleteHistory');
	$routes->delete('email-history', 'Bulk::deleteEmailHistory');




	$routes->get('group', 'Bulk::group');
	$routes->post('group', 'Bulk::createGroup');
	$routes->put('group', 'Bulk::updateGroup');
	$routes->delete('group', 'Bulk::deleteGroup');

	$routes->post('email-group', 'Bulk::createEmailGroup');
    $routes->put('email-group', 'Bulk::updateEmailGroup');
    $routes->delete('email-group', 'Bulk::deleteEmailGroup');

	$routes->get('settings', 'Bulk::settings');
	$routes->post('settings', 'Bulk::saveSettings');
	$routes->post('password-update', 'Bulk::passwordUpdate');


});
$routes->group('scrapper', ["filter"=>"authorizedonly"], function ($routes) {
	$routes->match(['get', 'post'], 'nairaland', 'Scrapper::nairaland');
	$routes->post( 'save-contacts', 'Scrapper::saveContacts');
	$routes->post('save-email-contacts', 'Scrapper::saveEmailContacts');


});


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

