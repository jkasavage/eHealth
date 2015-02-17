<?php
// CSF Auto Loader Instance
require_once('CS-Framework/AutoLoader.Class.php');
$auto = new CSF\Modules\AutoLoader();
$auto->register();

$db = new CSF\Modules\Data("nutrition");

$selectParam = array(
			"table"=>"foodInfo",
			"columns"=>array("number")
		);

$numbers = $db->selectData($selectParam)
   			  -> execute();

$length = count($numbers);

if(!$length || $length == 0) {
	die("Could not get item numbers.");
}

for($i=1; $i < $length; $i++) {
	$catParam = array(
				"table"=>"foodDescs"
			);

	$cat = $db->selectData($catParam)
			  ->where(array("ndb_no"=>$numbers[$i]["number"]))
			  ->execute();

	$insertParam = array(
				"table"=>"foodInfo",
				"columns"=>array("category"),
				"values"=>array($cat[0]["fdgrp_cd"])
			);

	$add = $db->updateData($insertParam)
			  ->where(array("number"=>$numbers[$i]["number"]))
	   		  ->execute();
}