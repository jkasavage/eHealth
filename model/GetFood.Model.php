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
	 * @param  string $id
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
}