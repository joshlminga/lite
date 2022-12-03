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
// Directory
$Api_Folder = "Api";
$Core_Folder = "Core";
$Field_Folder = "Field";
$Extension_Folder = "Extension";

// Initialize Database
require_once(BASEPATH . "database/DB.php");
$db = &DB();

/**
 * Todo: Default Routes
 */
$route["default_controller"] = "Home"; //Main (Home) Page
$route["404"] = "HomeError"; //Theme Error Page For Front-end
$route["404_override"] = "CoreErrors/index"; //Default Error Page

//404
$route["not-found"] = "CoreErrors/index"; //Default Error Page
$route["not-allowed"] = "CoreErrors/open"; //Default Not Allowed Page

/**
 * Todo: API Default Routes
 */
// Inheritance
$route["coreapi/token"] = "$Api_Folder/CoreApi/getToken";
$route["coreapi/find/inheritance"] = "$Api_Folder/CoreApi/getInheritance";
$route["coreapi/find/inheritance/(:any)"] = "$Api_Folder/CoreApi/getInheritance/$1";
// CustomFields & Fields
$route["coreapi/find/field"] = "$Api_Folder/CoreApi/getField";
$route["coreapi/find/field/(:any)"] = "$Api_Folder/CoreApi/getField/$1";
// Select Single
$route["coreapi/find/single"] = "$Api_Folder/CoreApi/getSingle";
// Select Multiple
$route["coreapi/find/multiple"] = "$Api_Folder/CoreApi/getMultiple";
// Select loadAutoData
$route["coreapi/find/autodata"] = "$Api_Folder/CoreApi/getAutoData";
// Get CoreField->load
$route["coreapi/find/load"] = "$Api_Folder/CoreApi/getLoad";
// Capture Erors - Any Wrong API Call
$route["coreapi/(:any)"] = "$Api_Folder/CoreApi/failed";
$route["coreapi/(.+)"] = "$Api_Folder/CoreApi/failed";
/******** END API *********/

/**
 * Todo: Admin Routes
 */

// Login
$route["admin"] = "$Core_Folder/Logs/index"; //Login Page
$route["admin/login"] = "$Core_Folder/Logs/valid/login"; //Login Verification
$route["admin/reset"] = "$Core_Folder/Logs/valid/reset"; //Reset Password
$route["admin/logout"] = "$Core_Folder/Logs/valid/logout"; //Logout

// Administrator
$route["dashboard"] = "$Core_Folder/Dashboard/index"; //Dashboard

// Users
$route["users"] = "$Core_Folder/Users/index"; //Manage
$route["users/new"] = "$Core_Folder/Users/open/add"; //Create New
$route["users/edit"] = "$Core_Folder/Users/edit/edit"; //Edit
$route["users/save"] = "$Core_Folder/Users/valid/save"; //Validate and Save
$route["users/update"] = "$Core_Folder/Users/valid/update"; //Validate and Update
$route["users/delete"] = "$Core_Folder/Users/valid/delete"; //Delete 
$route["users/multiple"] = "$Core_Folder/Users/valid/bulk"; //Bulk Action 

// Blogs
$route["blogs"] = "$Core_Folder/Blogs/index"; //List
$route["blogs/new"] = "$Core_Folder/Blogs/open/add"; //Open Create New Form
$route["blogs/edit"] = "$Core_Folder/Blogs/edit/edit"; // Open Edit  Page
$route["blogs/save"] = "$Core_Folder/Blogs/valid/save"; // Validate and Save
$route["blogs/update"] = "$Core_Folder/Blogs/valid/update"; // Validate and Update
$route["blogs/delete"] = "$Core_Folder/Blogs/valid/delete"; // Delete 
$route["blogs/multiple"] = "$Core_Folder/Blogs/valid/bulk"; // Bulk Action 

// Blog Tags
$route["blogtag"] = "$Core_Folder/BlogTags/index"; //Manage
$route["blogtag/edit"] = "$Core_Folder/BlogTags/edit/edit"; //Edit 
$route["blogtag/save"] = "$Core_Folder/BlogTags/valid/save"; //Validate and Save
$route["blogtag/update"] = "$Core_Folder/BlogTags/valid/update"; //Validate and Update
$route["blogtag/delete"] = "$Core_Folder/BlogTags/valid/delete"; //Delete 
$route["blogtag/multiple"] = "$Core_Folder/BlogTags/valid/bulk"; //Bulk Action  

// Blog Categories
$route["blogcategory"] = "$Core_Folder/BlogCategories/index"; //Manage
$route["blogcategory/edit"] = "$Core_Folder/BlogCategories/edit/edit"; //Edit 
$route["blogcategory/save"] = "$Core_Folder/BlogCategories/valid/save"; //Validate and Save
$route["blogcategory/update"] = "$Core_Folder/BlogCategories/valid/update"; //Validate and Update
$route["blogcategory/delete"] = "$Core_Folder/BlogCategories/valid/delete"; //Delete 
$route["blogcategory/multiple"] = "$Core_Folder/BlogCategories/valid/bulk"; //Bulk Action  

// Pages
$route["pages"] = "$Core_Folder/Pages/index"; //List
$route["pages/new"] = "$Core_Folder/Pages/open/add"; //Open Create New Form
$route["pages/edit"] = "$Core_Folder/Pages/edit/edit"; // Open Edit  Page
$route["pages/save"] = "$Core_Folder/Pages/valid/save"; // Validate and Save
$route["pages/update"] = "$Core_Folder/Pages/valid/update"; // Validate and Update
$route["pages/delete"] = "$Core_Folder/Pages/valid/delete"; // Delete 
$route["pages/multiple"] = "$Core_Folder/Pages/valid/bulk"; // Bulk Action 

// Settings
$route["general"] = "$Core_Folder/Settings/open/general"; //General Settings
$route["general/update"] = "$Core_Folder/Settings/valid/general"; //General Settings Update
$route["site"] = "$Core_Folder/Settings/open/site"; //Site Config
$route["site/update"] = "$Core_Folder/Settings/valid/site"; //Site Config Update
$route["link"] = "$Core_Folder/Settings/open/link"; //URL Settings
$route["link/update"] = "$Core_Folder/Settings/valid/link"; //URL Settings Update
$route["mail"] = "$Core_Folder/Settings/open/mail"; //Mail Settings
$route["mail/update"] = "$Core_Folder/Settings/valid/mail"; //Mail Settings Update
$route["blog"] = "$Core_Folder/Settings/open/blog"; //Blog Settings
$route["blog/update"] = "$Core_Folder/Settings/valid/blog"; //Blog Settings Update
$route["seo"] = "$Core_Folder/Settings/open/seo"; //Seo Settings
$route["seo/update"] = "$Core_Folder/Settings/valid/seo"; //Seo Settings Update
$route["inheritance"] = "$Core_Folder/Settings/open/inheritance"; //Inheritance Type Settings
$route["inheritance/update"] = "$Core_Folder/Settings/valid/inheritance"; //Inheritance Type Settings Update
$route["module"] = "$Core_Folder/Settings/open/module"; //ModuleSettings
$route["module/update"] = "$Core_Folder/Settings/valid/module"; //Module Settings Update
$route["theme"] = "$Core_Folder/Settings/open/theme"; //Theme Settings
$route["theme/update"] = "$Core_Folder/Settings/valid/theme"; //Theme Settings Update

// Access Levels
$route["level"] = "$Core_Folder/Levels/index"; //Manage
$route["level/edit"] = "$Core_Folder/Levels/edit/edit"; //Edit 
$route["level/save"] = "$Core_Folder/Levels/valid/save"; //Validate and Save
$route["level/update"] = "$Core_Folder/Levels/valid/update"; //Validate and Update
$route["level/delete"] = "$Core_Folder/Levels/valid/delete"; //Delete 
$route["level/multiple"] = "$Core_Folder/Levels/valid/bulk"; //Bulk Action  

// Sub Profile
$route["profile"] = "$Core_Folder/Profile/edit/profile"; //My Profile
$route["profile/update"] = "$Core_Folder/Profile/valid/update"; //Validate and Update

// AutoFields
$route["autofields"] = "$Core_Folder/AutoFields/index"; //List
$route["autofields/new"] = "$Core_Folder/AutoFields/open/add"; //Create New
$route["autofields/edit"] = "$Core_Folder/AutoFields/edit/edit"; // Edit 
$route["autofields/save"] = "$Core_Folder/AutoFields/valid/save"; // Validate and Save
$route["autofields/update"] = "$Core_Folder/AutoFields/valid/update"; // Validate and Update
$route["autofields/delete"] = "$Core_Folder/AutoFields/valid/delete"; // Delete 
$route["autofields/multiple"] = "$Core_Folder/AutoFields/valid/bulk"; // Bulk Action 

// Extends | For Extend Fields,Extensions & Conrtols
$route["extends"] = "$Core_Folder/RouteExtends/index"; //List
$route["extends/new"] = "$Core_Folder/RouteExtends/open/add"; //Create New
$route["extends/edit"] = "$Core_Folder/RouteExtends/edit/edit"; // Edit 
$route["extends/save"] = "$Core_Folder/RouteExtends/valid/save"; // Validate and Save
$route["extends/update"] = "$Core_Folder/RouteExtends/valid/update"; // Validate and Update
$route["extends/delete"] = "$Core_Folder/RouteExtends/valid/delete"; // Delete 
$route["extends/multiple"] = "$Core_Folder/RouteExtends/valid/bulk"; // Bulk Action 

// Custom Fields
$route["customfields"] = "$Core_Folder/CustomFields/index"; //Manage
$route["customfields/new"] = "$Core_Folder/CustomFields/open/add"; //Create New 
$route["customfields/edit"] = "$Core_Folder/CustomFields/edit/edit"; //Edit 
$route["customfields/save"] = "$Core_Folder/CustomFields/valid/save"; //Validate and Save
$route["customfields/update"] = "$Core_Folder/CustomFields/valid/update"; //Validate and Update
$route["customfields/delete"] = "$Core_Folder/CustomFields/valid/delete"; //Delete 
$route["customfields/multiple"] = "$Core_Folder/CustomFields/valid/bulk"; //Bulk Action  

// Inheritance
$route["inheritances"] = "$Core_Folder/Inheritances/index"; //Manage
$route["inheritances/new"] = "$Core_Folder/Inheritances/open/add"; //Create New 
$route["inheritances/edit"] = "$Core_Folder/Inheritances/edit/edit"; //Edit 
$route["inheritances/save"] = "$Core_Folder/Inheritances/valid/save"; //Validate and Save
$route["inheritances/update"] = "$Core_Folder/Inheritances/valid/update"; //Validate and Update
$route["inheritances/delete"] = "$Core_Folder/Inheritances/valid/delete"; //Delete 
$route["inheritances/multiple"] = "$Core_Folder/Inheritances/valid/bulk"; //Bulk Action 

// Helpers
$route["helpers"] = "$Core_Folder/Helpers/index"; //List
$route["helpers/new"] = "$Core_Folder/Helpers/open/add"; //Create New
$route["helpers/edit"] = "$Core_Folder/Helpers/edit/edit"; // Edit 
$route["helpers/save"] = "$Core_Folder/Helpers/valid/save"; // Validate and Save
$route["helpers/update"] = "$Core_Folder/Helpers/valid/update"; // Validate and Update
$route["helpers/delete"] = "$Core_Folder/Helpers/valid/delete"; // Delete 
$route["helpers/multiple"] = "$Core_Folder/Helpers/valid/bulk"; // Bulk Action 

/** API - Customer Extension -> Users */
$route["api-customer/add"] = "$Api_Folder/Extension_Customers/valid/save";
$route["api-customer/update"] = "$Api_Folder/Extension_Customers/valid/update";
$route["api-customer/delete"] = "$Api_Folder/Extension_Customers/valid/delete";
$route["api-customer/get"] = "$Api_Folder/Extension_Customers/valid/get";

/** API - [Members] Field_Members */
$route["api-members/add"] = "$Api_Folder/Field_Members/valid/save";
$route["api-members/update"] = "$Api_Folder/Field_Members/valid/update";
$route["api-members/delete"] = "$Api_Folder/Field_Members/valid/delete";
$route["api-members/get"] = "$Api_Folder/Field_Members/valid/get";


$route['translate_uri_dashes'] = FALSE;
/** END IN-BUILT ROUTES */


/**
 * Todo: route_menu Routes
 */
$query = $db->select("setting_value")->where(array("setting_title" => "route_menu", "setting_flg" => 1))->get("settings");
$settValue = $query->result();

// Routes
$routeNames = null;
for ($i = 0; $i < count($settValue); $i++) {
	$setting_value = $settValue[$i]->setting_value; //Menu Data
	$values = json_decode($setting_value, True);
	if (array_key_exists("route", $values)) {
		$routeNames[$i] = $values["route"]; // Menu Path
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

/**
 * Todo: extension_menu Routes
 */
$query = $db->select("setting_value")->where(array("setting_title" => "extension_menu", "setting_flg" => 1))->get("settings");
$settValue = $query->result();
// Routes
$routeNames = null;
for ($i = 0; $i < count($settValue); $i++) {
	$setting_value = $settValue[$i]->setting_value; //Menu Data
	$values = json_decode($setting_value, True);
	if (array_key_exists("route", $values)) {
		$routeNames[$i] = $values["route"]; // Menu Path
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

/**
 * Todo: field_menu Routes
 */
$query = $db->select("setting_value")->where(array("setting_title" => "field_menu", "setting_flg" => 1))->get("settings");
$settValue = $query->result();

// Routes
$routeNames = null;
for ($i = 0; $i < count($settValue); $i++) {
	$setting_value = $settValue[$i]->setting_value; //Menu Data
	$values = json_decode($setting_value, True);
	if (array_key_exists("route", $values)) {
		$routeNames[$i] = $values["route"]; // Menu Path
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

/**
 * Todo: control_menu Routes
 */
$query = $db->select("setting_value")->where(array("setting_title" => "control_menu", "setting_flg" => 1))->get("settings");
$settValue = $query->result();

// Routes
$routeNames = null;
for ($i = 0; $i < count($settValue); $i++) {
	$setting_value = $settValue[$i]->setting_value; //Menu Data
	$values = json_decode($setting_value, True);
	if (array_key_exists("route", $values)) {
		$routeNames[$i] = $values["route"]; // Menu Path
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

/**
 * Todo: menu_menu Routes
 */
$query = $db->select("setting_value")->where(array("setting_title" => "menu_menu", "setting_flg" => 1))->get("settings");
$settValue = $query->result();

// Routes
$routeNames = null;
for ($i = 0; $i < count($settValue); $i++) {
	$setting_value = $settValue[$i]->setting_value; //Menu Data
	$values = json_decode($setting_value, True);
	if (array_key_exists("route", $values)) {
		$routeNames[$i] = $values["route"]; // Menu Path
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

