<?php defined('_JEXEC') or die('Restricted access'); 

/* 
* Ninja Modulizer
* By Daniel Chapman
* http://ninjaforge.com 
* Copyright (C) 2009 Ninja Forge http://ninjaforge.com - Code so sharp, it hurts.
* email: support@ninjaforge.com
* date: December 2009
* Release: 1.0
* Code License : http://www.gnu.org/copyleft/gpl.html GNU/GPL 
*/
###################################################################
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.
//
//You should have received a copy of the GNU General Public License
//along with this program; if not, write to the Free Software
//Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  0211
###################################################################


// Load the module helper.
require_once dirname(__FILE__).DS.'helper.php';

//Workaround for the scope bug
$tmp = new stdClass;
$tmp->module = $module;
$tmp->params = $params;


$textmod = $params->get('textmod');
$modcss = $params->get('modcss');
$modjs = $params->get('modjs');
$modphp = $params->get('modphp');
$modcontent = $params->get('modcontent');
$modids = $params->get('modids');
$layout = $params->get('layout');

$doc = JFactory::getDocument();
// Get this module's id to use as a unique identifier.
// This allows us to have multiple instances on the one page.
// We also use it to reset the module parameters later
$thisID = $module->id;

//process our custom CSS, JS and PHP
if($modcss) {
	$doc->addStyleDeclaration($modcss);
}

if($modjs) {
	$doc->addScriptDeclaration($modjs);
}



//prepare our modules for display
$modIDArray = explode(",",str_replace(' ', '', $modids));

//Count the number of array elements - the number of modules to display
$IDCount = count( $modIDArray );

switch ($layout){
	case 'outline':		
		$innerChrome = 'default';
		break;
	case 'custom':
		$innerChrome = 'default';
		$layout = $params->get( 'custChrome', 'none' ); 
		break; 	
	default:
		$innerChrome = $layout;
		break;
	

}

// Print HTML output.
require JModuleHelper::getLayoutPath('mod_ninjamodulizer', $innerChrome);

//Workaround for scope bug
$module = $tmp->module;
$params = $tmp->params;