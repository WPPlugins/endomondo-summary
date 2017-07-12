<?php

#Improved by Tom
#Thanks to http://www.webcheatsheet.com/PHP/get_current_page_url.php

#Usage: externalURL('type')
#type can be: 
#'full' - http://example.com/dir/file.php?test=
#'file' - http://example.com/dir/file.php
#'dir' - http://example.com/dir/

function externalURL($type) {
$pageURL = 'http';

if ($_SERVER["SERVER_PORT"] != "80") {
$SrvPrt = ":" .$_SERVER["SERVER_PORT"];};

 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";

	 switch ($type)
		{
		case 'full':
			$pageURL .=  $_SERVER["SERVER_NAME"]. $SrvPrt .$_SERVER["REQUEST_URI"];
		  break;
		case 'file':
			$pageURL .= $_SERVER["SERVER_NAME"]. $SrvPrt .$_SERVER["PHP_SELF"];
		  break;
		case 'dir':
			$pageURL .=  $_SERVER["SERVER_NAME"]. $SrvPrt .dirname($_SERVER['PHP_SELF'])."/";
		  break;
		default:
		  echo 'externalURL function error';
		}
 return $pageURL;
 };
 
#Below is just for information only, if you are able to use
#echo dirname(__FILE__);
#outputs /home/james083/domains/techdump_dev/public_html/wp-content/plugins/endotom/OLD

#echo basename(__FILE__);
#outputs externalURL.php

#echo basename($_SERVER['PHP_SELF']);
#outputs externalURL.php
?>
