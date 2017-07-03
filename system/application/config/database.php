<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = "default";
$active_record = TRUE;


#$db['default']['hostname'] = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.68.37)(PORT =
#1579)))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = tst)))";

#-------------------------------
#	Oracle di MIS
#-------------------------------
#$db['default']['hostname'] = "//192.168.62.3:1597/REPOPRO";


#-------------------------------
#	Oracle di AFRICA2
#-------------------------------
#$db['default']['hostname'] = "//192.168.68.175:1589/sapm";
#$db['default']['hostname'] = "//192.168.27.42:1579/sapm";
#$db['default']['username'] = "smo";
#$db['default']['password'] = "smo123";


#-------------------------------
#	Oracle di SAMPDB
#-------------------------------
#$db['default']['hostname'] = "//192.168.68.175:1589/sapmdb";
$db['default']['hostname'] = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.18.2.177)(PORT=1521))(CONNECT_DATA=(SERVICE_NAME=ofa)))";
$db['default']['username'] = "SAPM_DEV";
$db['default']['password'] = "bni1234";



#-------------------------------
#	Oracle di BBSM_OPS
#-------------------------------
#$db['default']['hostname'] = "//192.168.4.62:1535/bbsmprod";
#$db['default']['hostname'] = "//192.168.7.34:1535/bbsmprod";
#$db['default']['hostname'] = "//192.168.27.42:1579/sapm";
#$db['default']['username'] = "BBSM_OPS";
#$db['default']['password'] = "bni#123";

#-------------------------------
#	Oracle di FLORES
#-------------------------------
#$db['default']['hostname'] = "//192.168.68.37:1579/tst";
#$db['default']['username'] = "smo_training";
#$db['default']['password'] = "smo123";

#-------------------------------
#	Oracle di DEV REPO
#-------------------------------
#$db['default']['hostname'] = "//192.168.62.3:1597/REPOPRO";
#$db['default']['username'] = "SMO";
#$db['default']['password'] = "SMO123";

#$db['default']['hostname'] = "//192.168.62.3/REPOPRO";
#$db['default']['username'] = "onluser";
#$db['default']['password'] = "onluser123";

#$db['default']['username'] = "CBS";
#$db['default']['password'] = "CBS";

$db['default']['database'] = "";
$db['default']['dbdriver'] = "oci8";
$db['default']['dbprefix'] = "";
#$db['default']['database'] = "SMO_TRAINING";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";

/*
$db['default']['hostname'] = "localhost";
$db['default']['username'] = "root";
$db['default']['password'] = "";
$db['default']['database'] = "flexigrid";
$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";
*/

/* End of file database.php */
/* Location: ./system/application/config/database.php */
