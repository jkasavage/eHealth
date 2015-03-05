<?php
/**
 * Club Systems Nutrition - Calories Controller
 *
 * @copyright Club Systems 2015
 * @author Joe Kasavage
 */

require('../model/Calories.Model.php');

$task = $_POST["task"];
$obj = new Calories();

switch($task) {
	case 'getIntake':
		$obj::getIntake($_POST["member"]);
		break;

	default:
		return false;
		break;
}