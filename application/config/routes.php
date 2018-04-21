<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'main_controller/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* main page */
$route['page'] = "main_controller/loadData";

/* login */
$route['login']['get'] = "user_controller/login_index";
$route['login']['post'] = "user_controller/login";

/* logout */
$route['logout']['get'] = "user_controller/logout";

/* register */
$route['register']['get'] = "user_controller/register_index";
$route['register']['post'] = "user_controller/register";

/* forgot password */
$route['forgot']['get'] = "user_controller/forgot_index";
$route['forgot']['post'] = "user_controller/forgot";

/* reset password */
$route['reset_password/(:any)']['get'] = "user_controller/reset_password_index/$1";
$route['reset_password/(:any)']['post'] = "user_controller/reset_password/$1";

/* upload */
$route['upload']['get'] = "board_controller/upload_index";
$route['upload']['post'] = "board_controller/upload";

/* view page */
$route['view/(:num)']['get'] = "board_controller/view/$1";
$route['view/download/(:num)']['get'] = "board_controller/download/$1";
$route['delete/(:num)']['get'] = "board_controller/delete/$1";
$route['update/(:num)']['get'] = "board_controller/update_view/$1";
$route['update/(:num)']['post'] = "board_controller/update/$1";