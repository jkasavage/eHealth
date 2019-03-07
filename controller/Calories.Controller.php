<?php
/**
 * Calories Controller
 *
 * @author Joe Kasavage
 */

require('../model/Calories.Model.php');

$task = preg_replace("/\PL/u", "", $_POST["task"]);
$obj = new Calories();

switch($task) {
	case 'getIntake':
		$obj::getIntake($_POST["member"]);
		break;

	default:
		return false;
		break;
}