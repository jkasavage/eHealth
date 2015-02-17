<?php
/**
 * Club Systems Nutrition - Add Food View
 *
 * @copyright Club Systems 2015
 * @author Joe Kasavage
 */

// CSF Auto Loader Instance
require_once('CS-Framework/AutoLoader.Class.php');
$auto = new CSF\Modules\AutoLoader();
$auto->register();

$builder = new CSF\Modules\Forms();

?>

<div id="food" style="text-align: center;"> <!-- Start Container -->

	<div class="page-header" style="text-align: left;"> <!-- Start Header -->
		<h1><span class="glyphicon glyphicon-cutlery"></span> Add Food <small>Add food items to your diary.</small></h1>
	</div> <!-- End Header -->

	<div id="choices" style="width: 100%; margin: auto;"> <!-- Start Choices -->

		<div class="panel panel-default" style="float: left; width: 49%; height: 150px; overflow: hidden;"><!-- Start Left Block -->
			<div class="panel-heading" style="height: 40px; padding: 5px;"><h4 style="font-weight: bold;">Search</h4></div>
			<div class="panel-body">
				<?php 
					$catParam = array("id"=>"foodCats", "label"=>"Select a Category:");

					echo $builder::CSSelect($catParam);
				?>
				&nbsp;&nbsp;
				<button class="btn btn-success" onClick="javascript: AddFood.categorySearch();">Go!</button>

			</div>
		</div><!-- End Left Block -->

		<div style="float: left; width: 1%; overflow: hidden;"></div> <!-- Spacer -->

		<div class="panel panel-default" style="float: right; width: 49%; height: 150px; overflow: hidden;"><!-- Start Right Block -->
			<div class="panel-heading" style="height: 40px; padding: 5px;"><h4 style="font-weight: bold;">Search Your Meals</h4></div>
			<div class="panel-body" id="meals">
				<?php
					$mealParam = array("id"=>"mealItems", "label"=>"Select a Meal:");

					echo $builder::CSSelect($mealParam);
				?>
				&nbsp;&nbsp;
				<button id="mealBtn" class="btn btn-success" onClick="" style="display: none;">Add Meal!</button>
			</div>
		</div><!-- End Right Block -->

	</div> <!-- End Choices -->

	<div id="results" style="clear: both; margin-left: auto; margin-right: auto; width: 600px; text-align: left; display: none;"> <!-- Start Results -->
		
		<div class="panel panel-default">
			<div class="panel-heading" style="height: 40px; padding: 5px; padding-left: 10px;"><h4 style="font-weight: bold;">Results<span style="float: right;" id="pages"></span></h4></div>
			<div class="panel-body searchResults">

			</div>
		</div>

	</div> <!-- End Results -->

	<div class="modal fade"> <!-- Start Modal Container -->
		<div class="modal-dialog"> <!-- Start Modal Dialog Start -->
			<div class="modal-content"> <!-- Start Modal Content -->
				
				<div class="modal-header"> <!-- Start Modal Header -->
					<h4 class="modal-title foodName"></h4> <!-- Title -->
				</div> <!-- End Modal Header -->

				<div class="modal-body foodInfo"> <!-- Start Modal Body -->
					<table class="table-striped table-bordered">
						<tr>
							<td><strong>Water (g):</strong></td>
							<td id="water" style="text-align: center;"></td>
							<td><strong>Energy (kcal):</strong></td>
							<td id="energy"></td>
						</tr>
						<tr>
							<td><strong>Protein (g):</strong></td>
							<td id="protein" style="text-align: center;"></td>
							<td><strong>Total Fat (g):</strong></td>
							<td id="fat" style="text-align: center;"></td>
						</tr>
						<tr>
							<td><strong>Carbohydrates (g):</strong></td>
							<td id="carb" style="text-align: center;"></td>
							<td><strong>Fiber (g):</strong></td>
							<td id="fiber" style="text-align: center;"></td
						</tr>
						<tr>
							<td><strong>Sugars (g):</strong></td>
							<td id="sugar" style="text-align: center;"></td>
							<td><strong>Calcium (mg):</strong></td>
							<td id="calcium" style="text-align: center;"></td>
						</tr>
						<tr>
							<td><strong>Iron (mg):</strong></td>
							<td id="iron" style="text-align: center;"></td>
							<td><strong>Magnesium (mg):</strong></td>
							<td id="magnesium" style="text-align: center;"></td>
						</tr>
						<tr>
							<td><strong>Phosphorus (mg):</strong></td>
							<td id="phosphorus" style="text-align: center;"></td>
							<td><strong>Potassium (mg):</strong></td>
							<td id="potassium" style="text-align: center;"></td>
						</tr>
						<tr>
							<td><strong>Sodium (mg):</strong></td>
							<td id="sodium" style="text-align: center;"></td>
							<td><strong>Zinc (mg):</strong></td>
							<td id="zinc" style="text-align: center;"></td>
						</tr>
						<tr>
							<td><strong>Vitamin C (mg):</strong></td>
							<td id="vitc" style="text-align: center;"></td>
							<td><strong>Thiamin (mg):</strong></td>
							<td id="thiamin" style="text-align: center;"></td>
						</tr>
						<tr>
							<td><strong>
						</tr>
					</table>
				</div> <!-- End Modal Body -->

				<div class="modal-footer"> <!-- Start Modal Footer -->
					<button class="btn btn-default" data-dismiss="modal">Close</button>
					<button class="btn btn-primary">Add Item</button>
				</div> <!-- End Modal Footer -->

			</div> <!-- End Modal Content -->
		</div> <!-- Modal Dialog End -->
	</div> <!-- End Modal Container -->

</div><!-- End Container -->

<script src="js/AddFood.js"></script>

<script>
	$(function() {
		AddFood.getFoodCats();
		AddFood.getMeals();
	});
</script>