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
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get("f", "Post::f");

//user
$routes->get('/signin', 'User::signin_form');
$routes->post('/signin', 'User::signin');
$routes->get('/signup', 'User::signup_form');
$routes->post('/signup', 'User::signup');
$routes->get('/logout', 'User::logout');
$routes->get('/profile/(:any)', 'User::profile/$1');
$routes->get('/notifications/(:any)', 'User::user_notifications/$1');
$routes->get('/num-notifications', 'User::num_notifications');
//post
$routes->get("/add", "Post::add_form");
$routes->post("/add-challenge", "Post::add_challenge");
$routes->post("/add-post", "Post::add_post");
$routes->post("/vote", "Post::vote");
$routes->post("/like", "Post::like");
$routes->post("/comment", "Post::comment");
$routes->get("/posts/(:num)", "Post::posts/$1"); //used in spa
$routes->get("/osco-post/(:num)", "Post::osco_post/$1"); //without spa
$routes->get("/delete/(:num)", "Post::delete_post/$1"); 




/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
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