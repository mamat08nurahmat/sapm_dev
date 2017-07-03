<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('NOW',date("Y-m-d H:i:s"));
define('NOW_DATE',date("Y-m-d"));
define('NOW_TIME',date("H:i:s"));


define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('IMAGES','http://192.168.3.14/new_sapm/public/images/');
define('LAYOUT','http://192.168.3.14/new_sapm/public/images/layout/');
define('ICONS','http://192.168.3.14/new_sapm/public/images/icons/');

# Development jQuery
define('JS','http://192.168.3.14/new_sapm/public/js/');
define('JQ','http://192.168.3.14/new_sapm/public/js/jquery-1.4.2.min.js');
define('JUI','http://192.168.3.14/new_sapm/public/js/jquery-ui-1.8.4.custom.min.js');
define('JSFLEX','http://192.168.3.14/new_sapm/public/js/flexigrid.pack.js');
define('JSNUM','http://192.168.3.14/new_sapm/public/js/jquery.numeric.pack.js');
define('JSMON','http://192.168.3.14/new_sapm/public/js/jquery.maskMoney.js'); 


# Development css
define('CSS','http://192.168.3.14/new_sapm/public/css/');
define('CSS_JUI','http://192.168.3.14/new_sapm/public/css/jui/1.8.4/redmond/jquery-ui-1.8.4.custom.css');

# Images
define('APP', 'http://192.168.3.14/new_sapm/public/images/toolbar/icon-48-article.png');

#--------------------------Three Layer SAPM-----------------#
define('HCMS_WSDL','http://192.168.45.36/server_wsdl/server_nusoap.php?wsdl');

#Favicon
define('BASE_URL','http://192.168.3.14/new_sapm/');
#define('favicon', base_url.'/asset/images/');
define('favicon', 'http://192.168.3.14/new_sapm/asset/images/');
#Development CSS
define('NEWCSS', 'http://192.168.3.14/new_sapm/asset/css/');
#Development JS
define('NEWJS', 'http://192.168.3.14/new_sapm/asset/js/');

#loader
define('loader', 'http://192.168.3.14/new_sapm/asset/images/');

#logo
define('logo', 'http://192.168.3.14/new_sapm/asset/images/');

#bg-tax-amnesty
define('bg_tax', 'http://192.168.3.14/new_sapm/asset/images/');

#uploads
define('uploads', 'http://192.168.3.14/new_sapm/asset/uploads/');

#upload_prospek
define('UPLOAD_PROSPEK2', $_SERVER['DOCUMENT_ROOT'].'new_sapm/asset/xls_prospek/');

#download_prsopek
define('DOWNLOAD_PRSOPEK', $_SERVER['DOCUMENT_ROOT'].'new_sapm/asset/file_download/');

#popart
define('helpdesk', 'http://192.168.3.14/new_sapm/asset/foto_helpdesk/');

define('qrcode', 'http://192.168.3.14/new_sapm/asset/foto_helpdesk/');

#header
define('header', 'http://192.168.3.14/new_sapm/asset/images/');

#header_tax
define('header_tax', 'http://192.168.3.14/new_sapm/asset/images/');

#slider
define('slider', 'http://192.168.3.14/new_sapm/asset/slider/');

#banner
define('banner', 'http://192.168.3.14/new_sapm/asset/foto_banner/');
#---------------------------------------------------------------#

#--------------------------New Admin Themes SAPM-----------------#
// CSS
define('BOOTSTRAP_NEWCSS', 'http://192.168.3.14/new_sapm/bootstrap/css/');

//url connecting internet
define('FONT_AWESOME_CSS', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css');
define('IONIC_CONS_CSS', 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css');

define('NEWSAPMSTYLE_CSS', 'http://192.168.3.14/new_sapm/dist/css/new_sapm.css');
define('DISK_SKINS_CSS', 'http://192.168.3.14/new_sapm/dist/css/skins/_all-skins.css');
define('PLUGINS_ICHECK_CSS', 'http://192.168.3.14/new_sapm/plugins/iCheck/flat/blue.css');
define('PLUGINS_MORRIS_CSS', 'http://192.168.3.14/new_sapm/plugins/morris/morris.css'); 
define('PLUGINS_JVECTORMAP_CSS', 'http://192.168.3.14/new_sapm/plugins/jvectormap/jquery-jvectormap-1.2.2.css');
define('PLUGINS_DATEPICKER_CSS', 'http://192.168.3.14/new_sapm/plugins/datepicker/datepicker3.css');
define('PLUGINS_DATERANGEPICKER_CSS', 'http://192.168.3.14/new_sapm/plugins/daterangepicker/daterangepicker.css');
define('PLUGINS_BOOTSTRAP_WYSIHTML5_CSS', 'http://192.168.3.14/new_sapm/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');

// JS
define('JQUERY_2_2_3_JS', 'http://192.168.3.14/new_sapm/plugins/jQuery/jquery-2.2.3.min.js');  

//url connecting internet
define('JQUERY_1_11_4_JS', 'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js');

define('BOOTSTRAP_NEWJS', 'http://192.168.3.14/new_sapm/bootstrap/js/');

//url connecting internet
define('RAPHAEL_MIN_JS', 'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');

define('PLUGINS_MORRISJS', 'http://192.168.3.14/new_sapm/plugins/morris/morris.min.js');
define('PLUGINS_SPARKLINEJS', 'http://192.168.3.14/new_sapm/plugins/sparkline/jquery.sparkline.min.js'); 
define('PLUGINS_JVECTORMAP_1_1_2_JS', 'http://192.168.3.14/new_sapm/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');
define('PLUGINS_JVECTORMAP_WORLDJS', 'http://192.168.3.14/new_sapm/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');
define('PLUGINS_KNOBJS', 'http://192.168.3.14/new_sapm/plugins/knob/jquery.knob.js');

//url connecting internet
define('MOMENTJS', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js');

define('DATERANGEPICKERJS', 'http://192.168.3.14/new_sapm/plugins/daterangepicker/daterangepicker.js');
define('DATEPICKERJS', 'http://192.168.3.14/new_sapm/plugins/datepicker/bootstrap-datepicker.js');
define('PLUGINS_BOOTSTRAP_WYSIHTML5JS', 'http://192.168.3.14/new_sapm/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
define('PLUGINS_SLIMSCROLLJS', 'http://192.168.3.14/new_sapm/plugins/slimScroll/jquery.slimscroll.min.js');
define('PLUGINS_FASTCLICKJS', 'http://192.168.3.14/new_sapm/plugins/fastclick/fastclick.js');
define('DIST_APP_MIN_JS', 'http://192.168.3.14/new_sapm/dist/js/app.min.js');
define('DIST_DASHBOARD_JS', 'http://192.168.3.14/new_sapm/dist/js/pages/dashboard.js');
define('DIST_DEMO_JS', 'http://192.168.3.14/new_sapm/dist/js/demo.js');


//images user
define('IMAGES_USER_PROFILE', 'http://192.168.3.14/new_sapm/dist/img/');
#--------------------------New Admin Themes SAPM-----------------#

/* End of file constants.php */
/* Location: ./system/application/config/constants.php */
