<?php
/**
 * Club Systems Nutrition - Calories
 *
 * @copyright Club Systems 2015
 * @author Joe Kasavage
 */

// CSF Auto Loader Instance
require_once('../CS-Framework/AutoLoader.Class.php');
$auto = new CSF\Modules\AutoLoader();
$auto->register();

class Calories
{
	/**
	 * Get Calories
	 */
	public static function getIntake($member)
	{
		$db = new CSF\Modules\Data("nutrition");

		$calParam = array(
				"table"=>"users",
				"columns"=>array("intake")
			);

		$getCal = $db->selectData($calParam)
					 ->where(array("member"=>$member))
					 ->execute();


		$_SESSION["calories"] = (isset($getCal[0]["intake"])) ? $getCal[0]["intake"]:0;

		$conn = new Mongo();

		$mdb = $conn->selectDB("foodLog");

		$splitMem = explode("-", $member);
		$memCol = "member" . $splitMem[0] . $splitMem[1];

		$col = $mdb->selectCollection($memCol);

		$today = date('m/d/Y');

		$cal = 0;

		try {
			$food = $col->find(array("date"=>$today));
			$food = iterator_to_array($food);

			foreach($food as $item) {
				$cal = $cal + $item["calories"];
			}

			$_SESSION["calories"] = $_SESSION["calories"] - $cal;

			echo $_SESSION["calories"];
		} catch(MongoCursorException $ex) {
			echo '0';
		}
	}
}