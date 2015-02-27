<?php
/**
 * Club Systems Nutrition - Introduction Model
 *
 * @copyright Club Systems 2015
 * @author Joe Kasavage
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

// CSF Auto Loader Instance
require_once('../CS-Framework/AutoLoader.Class.php');
$auto = new CSF\Modules\AutoLoader();
$auto->register();

$db = new CSF\Modules\Data("nutrition");

$insertParam = array(
		"table"=>"users",
		"columns"=>array(
				"member",
				"name",
				"age",
				"gender",
				"height",
				"weight",
				"intake",
				"bmr"
			),
		"values"=>array(
				$_POST["member"],
				$_POST["name"],
				$_POST["age"],
				$_POST["gender"],
				$_POST["height"],
				$_POST["weight"],
				$_POST["calories"],
				$_POST["bmi"]
			)
	);

$check = $db->insertData($insertParam)
			->execute();

if($check) {
	echo "1";
} else {
	echo "0";
}