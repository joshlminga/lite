<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

// initialize database
require_once(BASEPATH . 'database/DB.php');
$db = &DB();

$route['default_controller'] = 'Home'; //Main (Home) Page
$route['404.html'] = 'HomeError'; //Theme Error Page For Front-end
$route['404_override'] = 'CoreErrors/index'; //Default Error Page

/******** API *********/

// Inheritance
$route['coreapi/token'] = 'Api/CoreApi/getToken';
$route['coreapi/find/inheritance'] = 'Api/CoreApi/getInheritance';
$route['coreapi/find/inheritance/(:any)'] = 'Api/CoreApi/getInheritance/$1';
// CustomFields & Fields
$route['coreapi/find/field'] = 'Api/CoreApi/getField';
$route['coreapi/find/field/(:any)'] = 'Api/CoreApi/getField/$1';
// Select Single
$route['coreapi/find/single'] = 'Api/CoreApi/getSingle';
// Select Multiple
$route['coreapi/find/multiple'] = 'Api/CoreApi/getMultiple';
// Select loadAutoData
$route['coreapi/find/autodata'] = 'Api/CoreApi/getAutoData';
// Get CoreField->load
$route['coreapi/find/load'] = 'Api/CoreApi/getLoad';
// Capture Erors - Any Wrong API Call
$route['coreapi/(:any)'] = 'Api/CoreApi/failed';
$route['coreapi/(.+)'] = 'Api/CoreApi/failed';

/******** END API *********/

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

//Blogs
$route['blogs'] = 'CoreBlogs/index'; //List
$route['blogs/new'] = 'CoreBlogs/open/add'; //Open Create New Form
$route['blogs/edit'] = 'CoreBlogs/edit/edit'; // Open Edit  Page
$route['blogs/save'] = 'CoreBlogs/valid/save'; // Validate and Save
$route['blogs/update'] = 'CoreBlogs/valid/update'; // Validate and Update
$route['blogs/delete'] = 'CoreBlogs/valid/delete'; // Delete 
$route['blogs/multiple'] = 'CoreBlogs/valid/bulk'; // Bulk Action 

//Blog Tags
$route['blogtag'] = 'CoreBlogTags/index'; //Manage
$route['blogtag/edit'] = 'CoreBlogTags/edit/edit'; //Edit 
$route['blogtag/save'] = 'CoreBlogTags/valid/save'; //Validate and Save
$route['blogtag/update'] = 'CoreBlogTags/valid/update'; //Validate and Update
$route['blogtag/delete'] = 'CoreBlogTags/valid/delete'; //Delete 
$route['blogtag/multiple'] = 'CoreBlogTags/valid/bulk'; //Bulk Action  

//Blog Categories
$route['blogcategory'] = 'CoreBlogCategories/index'; //Manage
$route['blogcategory/edit'] = 'CoreBlogCategories/edit/edit'; //Edit 
$route['blogcategory/save'] = 'CoreBlogCategories/valid/save'; //Validate and Save
$route['blogcategory/update'] = 'CoreBlogCategories/valid/update'; //Validate and Update
$route['blogcategory/delete'] = 'CoreBlogCategories/valid/delete'; //Delete 
$route['blogcategory/multiple'] = 'CoreBlogCategories/valid/bulk'; //Bulk Action  

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
$route['inheritance'] = 'CoreSettings/open/inheritance'; //Inheritance Type Settings
$route['inheritance/update'] = 'CoreSettings/valid/inheritance'; //Inheritance Type Settings Update
$route['module'] = 'CoreSettings/open/module'; //ModuleSettings
$route['module/update'] = 'CoreSettings/valid/module'; //Module Settings Update

//Blog Categories
$route['level'] = 'CoreLevels/index'; //Manage
$route['level/edit'] = 'CoreLevels/edit/edit'; //Edit 
$route['level/save'] = 'CoreLevels/valid/save'; //Validate and Save
$route['level/update'] = 'CoreLevels/valid/update'; //Validate and Update
$route['level/delete'] = 'CoreLevels/valid/delete'; //Delete 
$route['level/multiple'] = 'CoreLevels/valid/bulk'; //Bulk Action  

//Login
$route['admin'] = 'CoreLogs/index'; //Login Page
$route['admin/login'] = 'CoreLogs/valid/login'; //Login Verification
$route['admin/reset'] = 'CoreLogs/valid/reset'; //Reset Password
$route['admin/logout'] = 'CoreLogs/valid/logout'; //Logout

//Sub Profile
$route['profile'] = 'CoreProfiles/edit/profile'; //My Profile
$route['profile/update'] = 'CoreProfiles/valid/update'; //Validate and Update

//AutoFields
$route['autofields'] = 'CoreAutoFields/index'; //List
$route['autofields/new'] = 'CoreAutoFields/open/add'; //Create New
$route['autofields/edit'] = 'CoreAutoFields/edit/edit'; // Edit 
$route['autofields/save'] = 'CoreAutoFields/valid/save'; // Validate and Save
$route['autofields/update'] = 'CoreAutoFields/valid/update'; // Validate and Update
$route['autofields/delete'] = 'CoreAutoFields/valid/delete'; // Delete 
$route['autofields/multiple'] = 'CoreAutoFields/valid/bulk'; // Bulk Action 

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

/** API - Customer Extension -> Users */
$route['api-customer/add'] = 'Api/Extension_Customers/valid/save';
$route['api-customer/update'] = 'Api/Extension_Customers/valid/update';
$route['api-customer/delete'] = 'Api/Extension_Customers/valid/delete';
$route['api-customer/get'] = 'Api/Extension_Customers/valid/get';

/** API - [Members] Field_Members */
$route['api-members/add'] = 'Api/Field_Members/valid/save';
$route['api-members/update'] = 'Api/Field_Members/valid/update';
$route['api-members/delete'] = 'Api/Field_Members/valid/delete';
$route['api-members/get'] = 'Api/Field_Members/valid/get';

/////////////////////////// EXTENSIONS //////////////////////
$query = $db->select('setting_value')->where(array('setting_title' => 'extension_menu', 'setting_flg' => 1))->get('settings');
$settValue = $query->result();
// Routes
$routeNames = null;
for ($i = 0; $i < count($settValue); $i++) {
	$setting_value = $settValue[$i]->setting_value; //Menu Data
	$values = json_decode($setting_value, True);
	if (array_key_exists('route', $values)) {
		$routeNames[$i] = $values['route']; // Menu Path
	}
}

// Reset
$routeNames = (is_array($routeNames)) ? array_values($routeNames) : $routeNames;

// Values
$routeNames = (is_array($routeNames)) ? array_values($routeNames) : null;
if (is_array($routeNames)) {
	for ($i = 0; $i < count($routeNames); $i++) {
		$routeLine = $routeNames[$i];
		foreach ($routeLine as $key => $value) {
			$ky = trim($key);
			$val = trim($value);
			$route[$ky] = "$val"; // Assign Route
		}
	}
}

/////////////////////////// FIELDS //////////////////////////
$query = $db->select('setting_value')->where(array('setting_title' => 'field_menu', 'setting_flg' => 1))->get('settings');
$settValue = $query->result();

// Routes
$routeNames = null;
for ($i = 0; $i < count($settValue); $i++) {
	$setting_value = $settValue[$i]->setting_value; //Menu Data
	$values = json_decode($setting_value, True);
	if (array_key_exists('route', $values)) {
		$routeNames[$i] = $values['route']; // Menu Path
	}
}

// Reset
$routeNames = (is_array($routeNames)) ? array_values($routeNames) : $routeNames;

// Values
$routeNames = (is_array($routeNames)) ? array_values($routeNames) : null;
if (is_array($routeNames)) {
	for ($i = 0; $i < count($routeNames); $i++) {
		$routeLine = $routeNames[$i];
		foreach ($routeLine as $key => $value) {
			$ky = trim($key);
			$val = trim($value);
			$route[$ky] = "$val"; // Assign Route
		}
	}
}

/////////////////////////// CONTROLS ///////////////////////
$query = $db->select('setting_value')->where(array('setting_title' => 'control_menu', 'setting_flg' => 1))->get('settings');
$settValue = $query->result();

// Routes
$routeNames = null;
for ($i = 0; $i < count($settValue); $i++) {
	$setting_value = $settValue[$i]->setting_value; //Menu Data
	$values = json_decode($setting_value, True);
	if (array_key_exists('route', $values)) {
		$routeNames[$i] = $values['route']; // Menu Path
	}
}

// Reset
$routeNames = (is_array($routeNames)) ? array_values($routeNames) : $routeNames;

// Values
$routeNames = (is_array($routeNames)) ? array_values($routeNames) : null;
if (is_array($routeNames)) {
	for ($i = 0; $i < count($routeNames); $i++) {
		$routeLine = $routeNames[$i];
		foreach ($routeLine as $key => $value) {
			$ky = trim($key);
			$val = trim($value);
			$route[$ky] = "$val"; // Assign Route
		}
	}
}

/////////////////////////// MENU //////////////////////////
$query = $db->select('setting_value')->where(array('setting_title' => 'menu_menu', 'setting_flg' => 1))->get('settings');
$settValue = $query->result();

// Routes
$routeNames = null;
for ($i = 0; $i < count($settValue); $i++) {
	$setting_value = $settValue[$i]->setting_value; //Menu Data
	$values = json_decode($setting_value, True);
	if (array_key_exists('route', $values)) {
		$routeNames[$i] = $values['route']; // Menu Path
	}
}

// Reset
$routeNames = (is_array($routeNames)) ? array_values($routeNames) : $routeNames;

// Values
$routeNames = (is_array($routeNames)) ? array_values($routeNames) : null;
if (is_array($routeNames)) {
	for ($i = 0; $i < count($routeNames); $i++) {
		$routeLine = $routeNames[$i];
		foreach ($routeLine as $key => $value) {
			$ky = trim($key);
			$val = trim($value);
			$route[$ky] = "$val"; // Assign Route
		}
	}
}

$route['translate_uri_dashes'] = FALSE;

/////////////////////////END IN-BUILT ROUTES ///////////////////
