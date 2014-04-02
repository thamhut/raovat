<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = 'error/error_404';
$route['category'] = 'home/category';
$route['category/(:num)'] = 'home/category/$1';
$route['detail/:any_i(:num)'] = 'home/detail/$1';
$route['landing/(:any)/(:num)'] = 'landing/view/$1/$2';

$route['gioi-thieu'] = 'home/gioithieu';
$route['quyen-loi'] = 'home/quyenloi';
$route['san-pham'] = 'home/sanpham';
$route['tieu-chi'] = 'home/tieuchi';
$route['gia-nhap'] = 'home/gianhap';
$route['tin-tuc'] = 'home/tintuc';
$route['tin-tuc/:any_i(:num)'] = 'home/tintucdetail/$1';
$route['faqs'] = 'home/faqs';


/* $route['trang-chu'] = 'landing';
$route['homepage'] = 'landing';
$route['lien-he'] = 'contact';
$route['tim-kiem/trang_(:num)'] = 'search/index/$1';
$route['tim-kiem'] = 'search';
$route['chuyen-muc/:any_(:num)/trang_(:num)'] = 'category/index/$1/$2';
$route['category/:any_(:num)/page_(:num)'] = 'category/index/$1/$2';
$route['chuyen-muc/:any_(:num)'] = 'category/index/$1';
$route['category/:any_(:num)'] = 'category/index/$1';
$route[':any_(:num)'] = 'post/index/$1'; */


/* End of file routes.php */
/* Location: ./application/config/routes.php */