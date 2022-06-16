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

$route["default_controller"] = "Home"; //Main (Home) Page
$route["404.html"] = "HomeError"; //Theme Error Page For Front-end
$route["404_override"] = "$Core_Folder/CoreErrors/index"; //Default Error Page

/******** API *********/

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

//Administrator
$route["dashboard"] = "$Core_Folder/CoreMains/index"; //Dashboard

//Users
$route["users"] = "$Core_Folder/CoreUsers/index"; //Manage
$route["users/new"] = "$Core_Folder/CoreUsers/open/add"; //Create New
$route["users/edit"] = "$Core_Folder/CoreUsers/edit/edit"; //Edit
$route["users/save"] = "$Core_Folder/CoreUsers/valid/save"; //Validate and Save
$route["users/update"] = "$Core_Folder/CoreUsers/valid/update"; //Validate and Update
$route["users/delete"] = "$Core_Folder/CoreUsers/valid/delete"; //Delete 
$route["users/multiple"] = "$Core_Folder/CoreUsers/valid/bulk"; //Bulk Action 

//Blogs
$route["blogs"] = "$Core_Folder/CoreBlogs/index"; //List
$route["blogs/new"] = "$Core_Folder/CoreBlogs/open/add"; //Open Create New Form
$route["blogs/edit"] = "$Core_Folder/CoreBlogs/edit/edit"; // Open Edit  Page
$route["blogs/save"] = "$Core_Folder/CoreBlogs/valid/save"; // Validate and Save
$route["blogs/update"] = "$Core_Folder/CoreBlogs/valid/update"; // Validate and Update
$route["blogs/delete"] = "$Core_Folder/CoreBlogs/valid/delete"; // Delete 
$route["blogs/multiple"] = "$Core_Folder/CoreBlogs/valid/bulk"; // Bulk Action 

//Blog Tags
$route["blogtag"] = "$Core_Folder/CoreBlogTags/index"; //Manage
$route["blogtag/edit"] = "$Core_Folder/CoreBlogTags/edit/edit"; //Edit 
$route["blogtag/save"] = "$Core_Folder/CoreBlogTags/valid/save"; //Validate and Save
$route["blogtag/update"] = "$Core_Folder/CoreBlogTags/valid/update"; //Validate and Update
$route["blogtag/delete"] = "$Core_Folder/CoreBlogTags/valid/delete"; //Delete 
$route["blogtag/multiple"] = "$Core_Folder/CoreBlogTags/valid/bulk"; //Bulk Action  

//Blog Categories
$route["blogcategory"] = "$Core_Folder/CoreBlogCategories/index"; //Manage
$route["blogcategory/edit"] = "$Core_Folder/CoreBlogCategories/edit/edit"; //Edit 
$route["blogcategory/save"] = "$Core_Folder/CoreBlogCategories/valid/save"; //Validate and Save
$route["blogcategory/update"] = "$Core_Folder/CoreBlogCategories/valid/update"; //Validate and Update
$route["blogcategory/delete"] = "$Core_Folder/CoreBlogCategories/valid/delete"; //Delete 
$route["blogcategory/multiple"] = "$Core_Folder/CoreBlogCategories/valid/bulk"; //Bulk Action  

//Pages
$route["pages"] = "$Core_Folder/CorePages/index"; //List
$route["pages/new"] = "$Core_Folder/CorePages/open/add"; //Open Create New Form
$route["pages/edit"] = "$Core_Folder/CorePages/edit/edit"; // Open Edit  Page
$route["pages/save"] = "$Core_Folder/CorePages/valid/save"; // Validate and Save
$route["pages/update"] = "$Core_Folder/CorePages/valid/update"; // Validate and Update
$route["pages/delete"] = "$Core_Folder/CorePages/valid/delete"; // Delete 
$route["pages/multiple"] = "$Core_Folder/CorePages/valid/bulk"; // Bulk Action 

//Settings
$route["general"] = "$Core_Folder/CoreSettings/open/general"; //General Settings
$route["general/update"] = "$Core_Folder/CoreSettings/valid/general"; //General Settings Update
$route["link"] = "$Core_Folder/CoreSettings/open/link"; //URL Settings
$route["link/update"] = "$Core_Folder/CoreSettings/valid/link"; //URL Settings Update
$route["mail"] = "$Core_Folder/CoreSettings/open/mail"; //Mail Settings
$route["mail/update"] = "$Core_Folder/CoreSettings/valid/mail"; //Mail Settings Update
$route["blog"] = "$Core_Folder/CoreSettings/open/blog"; //Blog Settings
$route["blog/update"] = "$Core_Folder/CoreSettings/valid/blog"; //Blog Settings Update
$route["seo"] = "$Core_Folder/CoreSettings/open/seo"; //Seo Settings
$route["seo/update"] = "$Core_Folder/CoreSettings/valid/seo"; //Seo Settings Update
$route["inheritance"] = "$Core_Folder/CoreSettings/open/inheritance"; //Inheritance Type Settings
$route["inheritance/update"] = "$Core_Folder/CoreSettings/valid/inheritance"; //Inheritance Type Settings Update
$route["module"] = "$Core_Folder/CoreSettings/open/module"; //ModuleSettings
$route["module/update"] = "$Core_Folder/CoreSettings/valid/module"; //Module Settings Update

//Blog Categories
$route["level"] = "$Core_Folder/CoreLevels/index"; //Manage
$route["level/edit"] = "$Core_Folder/CoreLevels/edit/edit"; //Edit 
$route["level/save"] = "$Core_Folder/CoreLevels/valid/save"; //Validate and Save
$route["level/update"] = "$Core_Folder/CoreLevels/valid/update"; //Validate and Update
$route["level/delete"] = "$Core_Folder/CoreLevels/valid/delete"; //Delete 
$route["level/multiple"] = "$Core_Folder/CoreLevels/valid/bulk"; //Bulk Action  

//Login
$route["admin"] = "$Core_Folder/CoreLogs/index"; //Login Page
$route["admin/login"] = "$Core_Folder/CoreLogs/valid/login"; //Login Verification
$route["admin/reset"] = "$Core_Folder/CoreLogs/valid/reset"; //Reset Password
$route["admin/logout"] = "$Core_Folder/CoreLogs/valid/logout"; //Logout

//Sub Profile
$route["profile"] = "$Core_Folder/CoreProfiles/edit/profile"; //My Profile
$route["profile/update"] = "$Core_Folder/CoreProfiles/valid/update"; //Validate and Update

//AutoFields
$route["autofields"] = "$Core_Folder/CoreAutoFields/index"; //List
$route["autofields/new"] = "$Core_Folder/CoreAutoFields/open/add"; //Create New
$route["autofields/edit"] = "$Core_Folder/CoreAutoFields/edit/edit"; // Edit 
$route["autofields/save"] = "$Core_Folder/CoreAutoFields/valid/save"; // Validate and Save
$route["autofields/update"] = "$Core_Folder/CoreAutoFields/valid/update"; // Validate and Update
$route["autofields/delete"] = "$Core_Folder/CoreAutoFields/valid/delete"; // Delete 
$route["autofields/multiple"] = "$Core_Folder/CoreAutoFields/valid/bulk"; // Bulk Action 

//Custom Fields
$route["customfields"] = "$Core_Folder/CoreCustomFields/index"; //Manage
$route["customfields/new"] = "$Core_Folder/CoreCustomFields/open/add"; //Create New 
$route["customfields/edit"] = "$Core_Folder/CoreCustomFields/edit/edit"; //Edit 
$route["customfields/save"] = "$Core_Folder/CoreCustomFields/valid/save"; //Validate and Save
$route["customfields/update"] = "$Core_Folder/CoreCustomFields/valid/update"; //Validate and Update
$route["customfields/delete"] = "$Core_Folder/CoreCustomFields/valid/delete"; //Delete 
$route["customfields/multiple"] = "$Core_Folder/CoreCustomFields/valid/bulk"; //Bulk Action  

//Inheritance
$route["inheritances"] = "$Core_Folder/CoreInheritances/index"; //Manage
$route["inheritances/new"] = "$Core_Folder/CoreInheritances/open/add"; //Create New 
$route["inheritances/edit"] = "$Core_Folder/CoreInheritances/edit/edit"; //Edit 
$route["inheritances/save"] = "$Core_Folder/CoreInheritances/valid/save"; //Validate and Save
$route["inheritances/update"] = "$Core_Folder/CoreInheritances/valid/update"; //Validate and Update
$route["inheritances/delete"] = "$Core_Folder/CoreInheritances/valid/delete"; //Delete 
$route["inheritances/multiple"] = "$Core_Folder/CoreInheritances/valid/bulk"; //Bulk Action 

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

/////////////////////////// EXTENSIONS //////////////////////
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

/////////////////////////// FIELDS //////////////////////////
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

/////////////////////////// CONTROLS ///////////////////////
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

/////////////////////////// MENU //////////////////////////
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

$route['translate_uri_dashes'] = FALSE;

/////////////////////////END IN-BUILT ROUTES ///////////////////
