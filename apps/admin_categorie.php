<?php
	$i = 0;
	$count = count( $categories );
	while ( $i < $count ) {
		$categorie = $categories[$i];
		
	    require('views/admin_categorie.phtml');

	    $i++;
	}
?>