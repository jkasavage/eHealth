<?php
/**
 * GetFood Controller
 *
 * @author Joe Kasavage
 */
session_start();

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

	case 'wordSearch':
		$obj::wordSearch($_POST["crit"]);
		break;

	case 'addFavorite':
		$obj::addFavorite($_POST["item"], $_POST["member"]);
		break;

	case 'addFoodItem':
		$obj::addFoodItem($_POST["obj"]);
		break;

	case 'getFavorites':
		$obj::getFavorites($_POST["member"]);
		break;

	default:
		return false;
		break;
}