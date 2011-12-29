<?php defined('_JEXEC') || die('Direct access to this location is not allowed.'); ?>
<div id="nmz<?php echo $thisID;?>" class="nmzbody nmztable">
<table class="nmzcontent nmzinner-1">
<tr>

<?php
	//Echo out any content that has been entered.
	if ($modcontent || $modphp) { 
?>

	<td>
	 <?php 	
		//Parse the PH inside the formatting incase there is output
		if($modphp) {
			modNinjaModulizerHelper::parsePHP($modphp);
		}

		echo $modcontent;
	?>    	    
	</td>
</tr>
</table>
<?php	
	} //if ($modcontent || $modphp)
	
	// Loop through the list of items
    // We say less than the count (and not less than equal to) and start at 0 because that is how php handles arrays, the first element has an index of 0
    for ( $i=0; $i < $IDCount; $i++ ) {
      echo modNinjaModulizerHelper::renderModule( $modIDArray[$i], $layout); 
    } //for ($i=0; $i<$IDCount; $i++)
?>
</div>