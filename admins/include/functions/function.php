<?php

	/*
	** Title Function That Echo The Page Title In Case The Page
	** Has The Variable $PageTitle And Echo Defult Title For Other Page
	*/

function getTitle() {
	global $pageTitle;
	
	if(isset($pageTitle)){
		echo $pageTitle;
	}else {
		echo 'Default';
	}
}