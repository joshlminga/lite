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
$route['default_controller'] = 'CoreMain';
$route['404_override'] = '';

// Administrator
$route['dashboard'] = 'CoreMain/index';

// Users
$route['users'] = 'CoreUsers/index'; //User List
$route['users/new'] = 'CoreUsers/open/add'; //Open Create New User Form
$route['users/edit'] = 'CoreUsers/edit/edit'; // Open Edit User Page
$route['users/save'] = 'CoreUsers/valid/save'; // Validate and Save
$route['users/update'] = 'CoreUsers/valid/update'; // Validate and Update
$route['users/delete'] = 'CoreUsers/valid/delete'; // Delete User
$route['users/multiple'] = 'CoreUsers/valid/bulk'; // Bulk Action 

//Login
$route['admin'] = 'CoreLog/index'; //Login Page
$route['admin/login'] = 'CoreLog/valid/login'; //Login Verification
$route['admin/reset'] = 'CoreLog/valid/reset'; //Reset Password
$route['admin/logout'] = 'CoreLog/valid/logout'; //Reset Password


// Extensions
$route['customers'] = 'ExtensionCustomers/index'; //Customer List
$route['customers/new'] = 'ExtensionCustomers/open/add'; //Open Create New Customer Form
$route['customers/edit'] = 'ExtensionCustomers/edit/edit'; // Open Edit Customer Page
$route['customers/save'] = 'ExtensionCustomers/valid/save'; // Validate and Save
$route['customers/update'] = 'ExtensionCustomers/valid/update'; // Validate and Update
$route['customers/delete'] = 'ExtensionCustomers/valid/delete'; // Delete Customer
$route['customers/multiple'] = 'ExtensionCustomers/valid/bulk'; // Bulk Action 

/* Control */
	//Custom Fields
 	$route['customfields'] = 'CoreCustomfields/index'; //Open Create New 
 	$route['customfields/new'] = 'CoreCustomfields/open/add'; //Open Create New 
 	$route['customfields/edit'] = 'CoreCustomfields/edit/edit'; //Open Edit 
 	$route['customfields/save'] = 'CoreCustomfields/valid/save'; //Validate and Save
	$route['customfields/update'] = 'CoreCustomfields/valid/update'; // Validate and Update
	$route['customfields/delete'] = 'CoreCustomfields/valid/delete'; // Delete 
	$route['customfields/multiple'] = 'CoreCustomfields/valid/bulk'; // Bulk Action  
	//Field Customs
 	$route['fieldcustoms'] = 'CoreFieldcustoms/index'; //Open Create New 
 	$route['fieldcustoms/manage'] = 'CoreFieldcustoms/manage/manage'; // Manage Fields List

 	$route['fieldcustoms/new/(:any)'] = 'CoreFieldcustoms/open/add/null/main/$1'; //Open Create New 
 	$route['fieldcustoms/edit'] = 'CoreFieldcustoms/edit/edit'; //Open Edit 
 	$route['fieldcustoms/save'] = 'CoreFieldcustoms/valid/save'; //Validate and Save
	$route['fieldcustoms/update'] = 'CoreFieldcustoms/valid/update'; // Validate and Update
	$route['fieldcustoms/delete'] = 'CoreFieldcustoms/valid/delete'; // Delete 
	$route['fieldcustoms/multiple'] = 'CoreFieldcustoms/valid/bulk'; // Bulk Action  

	//LISTING
 	$route['listing_configs'] = 'ListingConfig/index'; //Open Create New 
 	$route['listing_configs/new'] = 'ListingConfig/open/add'; //Open Create New 
 	$route['listing_configs/edit'] = 'ListingConfig/edit/edit'; //Open Edit 
 	$route['listing_configs/save'] = 'ListingConfig/valid/save'; //Validate and Save
	$route['listing_configs/update'] = 'ListingConfig/valid/update'; // Validate and Update
	$route['listing_configs/delete'] = 'ListingConfig/valid/delete'; // Delete 
	$route['listing_configs/multiple'] = 'ListingConfig/valid/bulk'; // Bulk Action  

	//COMPANIES
 	$route['listing_companies'] = 'ListingCompanies/index'; //Open Create New 
 	$route['listing_companies/new'] = 'ListingCompanies/open/add'; //Open Create New 
 	$route['listing_companies/edit'] = 'ListingCompanies/edit/edit'; //Open Edit 
 	$route['listing_companies/save'] = 'ListingCompanies/valid/save'; //Validate and Save
	$route['listing_companies/update'] = 'ListingCompanies/valid/update'; // Validate and Update
	$route['listing_companies/delete'] = 'ListingCompanies/valid/delete'; // Delete 
	$route['listing_companies/multiple'] = 'ListingCompanies/valid/bulk'; // Bulk Action  

	//PRODUCTS
 	$route['listing_products'] = 'ListingProducts/index'; //Open Create New 
 	$route['listing_products/new'] = 'ListingProducts/open/add'; //Open Create New 
 	$route['listing_products/edit'] = 'ListingProducts/edit/edit'; //Open Edit 
 	$route['listing_products/save'] = 'ListingProducts/valid/save'; //Validate and Save
	$route['listing_products/update'] = 'ListingProducts/valid/update'; // Validate and Update
	$route['listing_products/delete'] = 'ListingProducts/valid/delete'; // Delete 
	$route['listing_products/multiple'] = 'ListingProducts/valid/bulk'; // Bulk Action  

	//PRODUCTS
 	$route['listing_logos'] = 'ListingLogos/index'; //Open Create New 
 	$route['listing_logos/new'] = 'ListingLogos/open/add'; //Open Create New 
 	$route['listing_logos/edit'] = 'ListingLogos/edit/edit'; //Open Edit 
 	$route['listing_logos/save'] = 'ListingLogos/valid/save'; //Validate and Save
	$route['listing_logos/update'] = 'ListingLogos/valid/update'; // Validate and Update
	$route['listing_logos/delete'] = 'ListingLogos/valid/delete'; // Delete 
	$route['listing_logos/multiple'] = 'ListingLogos/valid/bulk'; // Bulk Action  

//Choose SUB
$route['category/select'] = 'AjaxList/categories'; //Dynamic Category


$route['translate_uri_dashes'] = FALSE;
