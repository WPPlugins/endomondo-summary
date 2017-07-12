<?php
/*
	Plugin Name: Endomondo-Summary
	Plugin URI: http://techdump.co.uk
	Description: Endomondo Summary Plugin
	Version: 0.1
	Author: TLuxton
	Author URI: http://techdump.co.uk
	License: GPL2

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


#Define what to do when you activate and deactivate this plugin
register_activation_hook(__FILE__, 'activate_endomondosummary');
register_uninstall_hook(__FILE__, 'uninstall_endomondosummary');

#The code to run when activating the plugin
function activate_endomondosummary() {
  add_option('endomondo-summary_endoid', '');
  add_option('endomondo-summary_method', 'local');
  add_option('endomondo-summary_cssloc', 'local');
};

#The code to run when deactivating the plugin
function uninstall_endomondosummary() {
  delete_option('endomondo-summary_endoid');
  delete_option('endomondo-summary_method');
  delete_option('endomondo-summary_cssloc');
  };

#Options Page Code
include (__DIR__.'/options.php');

#Register a new shortcode and when used, point to endo_buildframe function
add_shortcode( 'endomondo-summary', 'endo_buildframe');

#I Don't really want to add the CSS to every page; Is there an alternitive?
add_action('wp_print_styles', 'endo_addstylesheet');	

#Function when shortcode is used.
function endo_buildframe($atts) {
		#get variables from shortcode
	   extract( shortcode_atts( array(
	      'endoid' => get_option('endomondo-summary_endoid'),
	      'method' => get_option('endomondo-summary_method'),
		  'cssloc' => get_option('endomondo-summary_cssloc'),
	      ), $atts ) );

	#Store the CSS Location for external php access (function only available on this php)
	#$_SESSION['endotom'] = plugins_url('endostyle.css',_FILE_);
	
	if($endoid == '') {return "Please specify a EndoID";};
	
	if($method == 'iframe')
    {
		$frameloc = plugins_url('frame.php?', __FILE__ );
		$staticcode = '<iframe src="'.$frameloc.'endoid='.$endoid.'&method=iframe&cssloc='.$cssloc.'" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:260px; height:450px"></iframe>';
		return $staticcode;
	}
	elseif($method == 'local')
	{
		#If printing to local page, then include frame.php to run function
		if(! class_exists('endo_genhtml'))  {require_once(dirname(__FILE__) . "/frame.php");};
		#is dirname better? seems to be same results: #include(__DIR__.'/frame.php')
		return endo_genhtml($endoid, 'local', $cssloc);
	};
  }
  
function endo_addstylesheet() {
	$myStyleUrl = plugins_url('endostyle.css', __FILE__); // Respects SSL, Style.css is relative to the current file
	$myStyleFile = WP_PLUGIN_DIR . '/endomondo-summary/endostyle.css';
	if ( file_exists($myStyleFile) ) {
		wp_register_style('endotomstyle', $myStyleUrl);
		wp_enqueue_style( 'endotomstyle');           
	}
	}

?>