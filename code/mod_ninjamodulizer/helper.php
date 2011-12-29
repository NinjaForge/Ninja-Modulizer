<?php
/*
 * Ninja Helper Functions Class
 * 
 * This is just some utility functions which we use frequently.
 */
 
 
// Ensure this file is being included by a parent file. 
defined ( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class modNinjaModulizerHelper {

/****
* Retrieve the details of a specific module from their id 
****/
	function renderModule( $id, $style='xhtml' ) {
			
			$user = JFactory::getUser();
	        $db   = JFactory::getDBO();
	        $app  = JFactory::getApplication(); 
	        
	        $aid    = $user->get('aid', 0);
	
	        $query = 'SELECT id, title, module, position, content, showtitle, control, params'
	            . ' FROM #__modules AS m'
	            . ' WHERE m.access <= '. (int)$aid
	            . ' AND m.client_id = '. (int)$app->getClientId()
	            . ' AND m.id = '. (int)$id;
	        
	        $db->setQuery( $query );
	        
	        if (null === ($newModule = $db->loadObject())) {
	            JError::raiseWarning( 'SOME_ERROR_CODE', JText::_( 'Error Loading Modules' ) . $db->getErrorMsg());
	            return false;
	        }
	        
	        //determine if this is a custom module
	        $file                    = $newModule->module;
	        $custom                 = substr( $file, 0, 4 ) == 'mod_' ?  0 : 1;
	        $newModule->user      = $custom;
	        // CHECK: custom module name is given by the title field, otherwise it's just 'om' ??
	        $newModule->name        = $custom ? $newModule->title : substr( $file, 4 );
	        $newModule->style        = null;
	        $newModule->position    = strtolower($newModule->position);	
			
		  	//set the module chrome   
			$attribs['style'] = $style;
					
			//needed for the render function below
			jimport( 'joomla.application.module.helper' );
			    		        	    
			return JModuleHelper::renderModule( $newModule, $attribs );	  	
	}//renderModule function   
	
	function parsePHP($php){
		
		//Some code in this function is_a derived from mod_html from Fiji Web Design
		//Credits below:
		/*
		* mod_html allows inclusion of HTML/JS/CSS and now PHP, in Joomla/Mambo Modules
		* (c) Copyright: Fiji Web Design, www.fijiwebdesign.com.
		* email: info@fijiwebdesign.com 
		* date: Feb 4, 2007
		* Release: 1.0.0.Beta Test2
		*/
		$php = "<?php ".$php." ?>";
		
		$temp_dir = dirname(__FILE__).'/parsePHPtmp';
		$tmpfname = tempnam($temp_dir, "tempfile.php");
		if ($handle = @fopen($tmpfname, "w")) {
			fwrite($handle, $php, strlen($php));
			fclose($handle);
			include_once($tmpfname);
			unlink($tmpfname);
		} else {
			JText::printf('FILE WRITE ERROR',$temp_dir);
		}
		
	}


} //class declaration