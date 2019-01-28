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
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home'; //Main (Home) Page
$route['404_override'] = 'CoreErrors/index'; //Default Error Page

//Administrator
$route['dashboard'] = 'CoreMains/index'; //Dashboard

//Users
$route['users'] = 'CoreUsers/index'; //Manage
$route['users/new'] = 'CoreUsers/open/add'; //Create New
$route['users/edit'] = 'CoreUsers/edit/edit'; //Edit
$route['users/save'] = 'CoreUsers/valid/save'; //Validate and Save
$route['users/update'] = 'CoreUsers/valid/update'; //Validate and Update
$route['users/delete'] = 'CoreUsers/valid/delete'; //Delete 
$route['users/multiple'] = 'CoreUsers/valid/bulk'; //Bulk Action 

//Pages
$route['pages'] = 'CorePages/index'; //List
$route['pages/new'] = 'CorePages/open/add'; //Open Create New Form
$route['pages/edit'] = 'CorePages/edit/edit'; // Open Edit  Page
$route['pages/save'] = 'CorePages/valid/save'; // Validate and Save
$route['pages/update'] = 'CorePages/valid/update'; // Validate and Update
$route['pages/delete'] = 'CorePages/valid/delete'; // Delete 
$route['pages/multiple'] = 'CorePages/valid/bulk'; // Bulk Action 

//Settings
$route['general'] = 'CoreSettings/open/general'; //General Settings
$route['general/update'] = 'CoreSettings/valid/general'; //General Settings Update
$route['link'] = 'CoreSettings/open/link'; //URL Settings
$route['link/update'] = 'CoreSettings/valid/link'; //URL Settings Update
$route['mail'] = 'CoreSettings/open/mail'; //Mail Settings
$route['mail/update'] = 'CoreSettings/valid/mail'; //Mail Settings Update
$route['blog'] = 'CoreSettings/open/blog'; //Blog Settings
$route['blog/update'] = 'CoreSettings/valid/blog'; //Blog Settings Update
$route['seo'] = 'CoreSettings/open/seo'; //Seo Settings
$route['seo/update'] = 'CoreSettings/valid/seo'; //Seo Settings Update

//Login
$route['admin'] = 'CoreLogs/index'; //Login Page
$route['admin/login'] = 'CoreLogs/valid/login'; //Login Verification
$route['admin/reset'] = 'CoreLogs/valid/reset'; //Reset Password
$route['admin/logout'] = 'CoreLogs/valid/logout'; //Logout

//Sub Profile
$route['profile'] = 'CoreProfiles/edit/profile'; //My Profile
$route['profile/update'] = 'CoreProfiles/valid/update'; //Validate and Update

//Custom Fields
$route['customfields'] = 'CoreCustomFields/index'; //Manage
$route['customfields/new'] = 'CoreCustomFields/open/add'; //Create New 
$route['customfields/edit'] = 'CoreCustomFields/edit/edit'; //Edit 
$route['customfields/save'] = 'CoreCustomFields/valid/save'; //Validate and Save
$route['customfields/update'] = 'CoreCustomFields/valid/update'; //Validate and Update
$route['customfields/delete'] = 'CoreCustomFields/valid/delete'; //Delete 
$route['customfields/multiple'] = 'CoreCustomFields/valid/bulk'; //Bulk Action  

//Inheritance
$route['inheritances'] = 'CoreInheritances/index'; //Manage
$route['inheritances/new'] = 'CoreInheritances/open/add'; //Create New 
$route['inheritances/edit'] = 'CoreInheritances/edit/edit'; //Edit 
$route['inheritances/save'] = 'CoreInheritances/valid/save'; //Validate and Save
$route['inheritances/update'] = 'CoreInheritances/valid/update'; //Validate and Update
$route['inheritances/delete'] = 'CoreInheritances/valid/delete'; //Delete 
$route['inheritances/multiple'] = 'CoreInheritances/valid/bulk'; //Bulk Action  

/////////////////////////// CONTROLS //////////////////////////

//UserData
$route['userdatas'] = 'FieldUsers/index'; //Manage
$route['userdatas/new'] = 'FieldUsers/open/add'; //Create New 
$route['userdatas/edit'] = 'FieldUsers/edit/edit'; //Edit 
$route['userdatas/save'] = 'FieldUsers/valid/save'; //Validate and Save
$route['userdatas/update'] = 'FieldUsers/valid/update'; //Validate and Update
$route['userdatas/delete'] = 'FieldUsers/valid/delete'; //Delete 
$route['userdatas/multiple'] = 'FieldUsers/valid/bulk'; //Bulk Action  


/////////////////////////// EXTENSIONS //////////////////////////

//Customers
$route['customers'] = 'ExtensionCustomers/index'; //Customer List
$route['customers/new'] = 'ExtensionCustomers/open/add'; //Open Create New Customer Form
$route['customers/edit'] = 'ExtensionCustomers/edit/edit'; // Open Edit Customer Page
$route['customers/save'] = 'ExtensionCustomers/valid/save'; // Validate and Save
$route['customers/update'] = 'ExtensionCustomers/valid/update'; // Validate and Update
$route['customers/delete'] = 'ExtensionCustomers/valid/delete'; // Delete Customer
$route['customers/multiple'] = 'ExtensionCustomers/valid/bulk'; // Bulk Action 


//Choose SUB
$route['category/select'] = 'AjaxList/categories'; //Dynamic Category
$route['translate_uri_dashes'] = FALSE;