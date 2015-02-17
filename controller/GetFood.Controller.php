<?php
/**
 * Club Systems Nutrition - GetFood Controller
 *
 * @copyright Club Systems 2015
 * @author Joe Kasavage
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

require("../model/GetFood.Model.php");

$task = $_POST["task"];
$obj = new GetFood();

switch($task) {
	case 'getFoodCats':
		$obj::getFoodCats();
		break;

	case 'getMeals':
		$obj::getMeals($_POST["member"]);
		break;

	case 'getCategoryItems':
		$obj::getCategoryItems($_POST["category"]);
		break;

	case 'getFoodItem':
		$obj::getFoodItem($_POST["item"]);
		break;

	default:
		return false;
		break;
}