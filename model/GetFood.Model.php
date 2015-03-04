<?php
/**
 * Club Systems Nutrition - Add Food View
 *
 * @copyright Club Systems 2015
 * @author Joe Kasavage
 */

// CSF Auto Loader Instance
require_once('../CS-Framework/AutoLoader.Class.php');
$auto = new CSF\Modules\AutoLoader();
$auto->register();

class GetFood
{
	/**
	 * Get Food Categories
	 * 
	 * @return Array $cats
	 */
	public static function getFoodCats()
	{
		$db = new CSF\Modules\Data("nutrition");

		$selectParam = array(
						"table"=>"foodCats",
						"columns"=>array(
								"fdgrp_cd",
								"fdgrp_desc"
							)	
					);

		$cats = $db->selectData($selectParam)
	   			->execute();

		echo json_encode($cats, true);
	}

	/**
	 * Get User Meals
	 * 
	 * @param  String $member
	 * 
	 * @return Array $meals
	 */
	public static function getMeals($member)
	{
		$db = new CSF\Modules\Data("nutrition");

		$selectParam = array(
					"table"=>"userMeals",	
				);

		$meals = $db->selectData($selectParam)
					->where(array("member"=>$member))
					->execute();

		echo json_encode($meals, true);
	}

	/**
	 * Get Items from selected Category
	 * 
	 * @param  String $category
	 * 
	 * @return Array $items
	 */
	public static function getCategoryItems($category)
	{
		$db = new CSF\Modules\Data("nutrition");

		$selectParam = array(
					"table"=>"foodInfo",
					"columns"=>array(
							"number",
							"name"
						)
				);

		$items = $db->selectData($selectParam)
					->where(array("category"=>$category))
					->execute();

		echo json_encode($items, true);
	}

	/**
	 * Get Food Item
	 * 
	 * @param  String $id
	 * 
	 * @return Array $item
	 */
	public static function getFoodItem($id) 
	{
		$db = new CSF\Modules\Data("nutrition");

		$selectParam = array(
					"table"=>"foodInfo",
				);

		$item = $db->selectData($selectParam)
				   ->where(array("number"=>$id))
				   ->execute();

		echo json_encode($item, true);
	}

	/**
	 * Search by Words
	 * 
	 * @param  String $phrase
	 * 
	 * @return Array $item
	 */
	public static function wordSearch($phrase)
	{
		$query = "SELECT name, number FROM foodInfo WHERE name REGEXP '";
		$length = count($phrase);

		if($length > 1) {
			for($i=0; $i <= $length - 1; $i++) {
				if($i == $length - 1) {
					$query .= "." . $phrase[$i] . "'";
				} else {
					$query .= "." . $phrase[$i] . "|";
				}
			}
		} else {
			$query .= "." . $phrase[0] . "'";
		}

		$db = new CSF\Modules\Data("nutrition");

		$item = $db->rawRequest($query);

		if(count($item) > 0) {
			echo json_encode($item, true);
		} else {
			echo "0";
		}
	}

	/**
	 * Add Item to Favorites
	 * 
	 * @param String $item Item Number
	 * @param String $member Member Number
	 *
	 * @return String
	 */
	public static function addFavorite($item, $member)
	{
		$db = new CSF\Modules\Data("nutrition");

		$selectParam = array(
				"table"=>"users",
				"columns"=>array("favorites")
			);

		$selectCheck = $db->selectData($selectParam)
						  ->where(array("member"=>$member))
						  ->execute();

		$itemCheck = explode(",", $selectCheck[0]["favorites"]);

		if(in_array($item, $itemCheck)) {
			echo '2';
		} else {
			if(strlen($selectCheck[0]["favorites"]) == 0) {
				$query = "UPDATE users SET favorites='" . $item . "' WHERE member='" . $member . "'";

				$check = $db->rawRequest($query);
			} else {
				$query = "UPDATE users SET favorites=CONCAT_WS(',', favorites, '" . $item . "') WHERE member='" . $member . "'";

				$check = $db->rawRequest($query);
			}

			if($check) {
				echo '1';
			} else {
				echo '0';
			}
		}
	}

	public static function addFoodItem($data)
	{
		$conn = new Mongo();

		$db = $conn->selectDB("foodLog");

		$col = $db->selectCollection($data["member"]);
	}
}