<?php
/**
 * @package download-contact-to-csv
 */
/*
 Plugin Name: download-contact-to-csv
  Plugin URI: http://www.download-contact-to-csv.com/
  Description: Download csv file from contact page.
  Version: 1.0.0
  Author: Rajendra Kumar Manandhar
  Author URI: http://www.download-contact-to-csv.com
  License: GPLv2 or later
  Text Domain: download-contact-to-csv
 */


define('ABSPATH') or die('You cant access this file');

class DownloadContactToCSV
{
	__construct($arg1){
		echo $arg1;
	}
}

$downloadContactToCSV = new DownloadContactToCSV();


if(class_exists('DownloadContactToCSV')){
	$downloadContactToCSV = new DownloadContactToCSV();
}


?>