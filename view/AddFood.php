<?php
/**
 * Add Food View
 *
 * @author Joe Kasavage
 */

$builder = new CSF\Modules\Forms();

?>

<div id="food" style="text-align: center;"> <!-- Start Container -->

	<div class="page-header" style="text-align: left;"> <!-- Start Header -->
		<h1><span class="glyphicon glyphicon-cutlery"></span> Add Food <small>Add food items to your diary.</small></h1>
	</div> <!-- End Header -->

	<div id="choices" style="width: 100%; margin: auto;"> <!-- Start Choices -->

		<div class="panel panel-default" style="float: left; width: 49%; height: 200px; overflow: hidden;"><!-- Start Left Block -->
			<div class="panel-heading" style="height: 40px; padding: 5px;"><h4 style="font-weight: bold;">Search</h4></div>
			<div class="panel-body">

				<ul class="nav nav-tabs" role="tablist"> <!-- Start Tab Menu -->
					<li role="presentation" class="active">
						<a href="#wordSearch" role="tab" aria-controls="wordSearch" data-toggle="tab">By Word</a>
					</li>
					<li role="presentation">
						<a href="#byCategory" role="tab" aria-controls="byCategory" data-toggle="tab">By Category</a>
					</li>
					<li role="presentation">
						<a href="#favorites" role="tab" aria-controls="favorites" data-toggle="tab">Favorites</a>
					</li>
				</ul> <!-- End Tab Menu -->

				<br />

				<div class="tab-content"> <!-- Start Tabs -->
					<div role="tabpanel" class="tab-pane active" id="wordSearch"> <!-- Start Word Search -->
						<strong>Enter your Search:</strong><br />
						<input id="wordSearchBox" style="width: 300px;" />

						&nbsp;&nbsp;
						<button class="btn btn-success" onclick="javascript: AddFood.wordSearch();">Go!</button>
					</div> <!-- End Word Search -->

					<div role="tabpanel" class="tab-pane" id="byCategory"> <!-- Start Category Search -->
						<?php 
							$catParam = array("id"=>"foodCats", "label"=>"Select a Category:");

							echo $builder::CSSelect($catParam);
						?>

						&nbsp;&nbsp;
						<button class="btn btn-success" onClick="javascript: AddFood.categorySearch();">Go!</button>
					</div> <!-- End Category Search -->

					<div role="tabpanel" class="tab-pane" id="favorites"> <!-- Start Favorite Items -->
						
					</div> <!-- End Favorite Items -->
				</div> <!-- End Tabs -->

			</div>
		</div><!-- End Left Block -->

		<div style="float: left; width: 1%; overflow: hidden;"></div> <!-- Spacer -->

		<div class="panel panel-default" style="float: right; width: 49%; height: 200px; overflow: hidden;"><!-- Start Right Block -->
			<div class="panel-heading" style="height: 40px; padding: 5px;"><h4 style="font-weight: bold;">Search Your Meals</h4></div>
			<div class="panel-body" id="meals">
				<?php
					$mealParam = array("id"=>"mealItems", "label"=>"Select a Meal:");

					echo $builder::CSSelect($mealParam);
				?>
				&nbsp;&nbsp;&nbsp;
				<button id="mealBtn" class="btn btn-success" onClick="" style="display: none;">Add Meal!</button><br /><br />
			</div>
		</div><!-- End Right Block -->

	</div> <!-- End Choices -->

	<div id="results" style="clear: both; margin-left: auto; margin-right: auto; width: 600px; text-align: left; display: none;"> <!-- Start Results -->
		
		<div class="panel panel-default">
			<div class="panel-heading" style="height: 40px; padding: 5px; padding-left: 10px;"><h4 class="contentTitle" style="font-weight: bold;">Results<span style="float: right;" id="pages"></span></h4></div>
			<div class="panel-body searchResults contentBody">

			</div>
		</div>

	</div> <!-- End Results -->

	<div class="modal fade" id="foodModal"> <!-- Start Modal Container -->
		<div class="modal-dialog"> <!-- Start Modal Dialog Start -->
			<div class="modal-content"> <!-- Start Modal Content -->
				
				<div class="modal-header"> <!-- Start Modal Header -->
					<h4 style="font-family: 'Helvetica', sans-serif;" class="modal-title foodName"></h4> <!-- Title -->
				</div> <!-- End Modal Header -->

				<div class="modal-body"> <!-- Start Modal Body -->
					<div id="facts" style="border: 1px solid #000; padding-left: 5px; padding-right: 5px; padding-bottom: 2px; width: 350px; margin-left: auto; margin-right: auto;"> <!-- Start Nutrition Facts -->
						<table style="font-family: 'Helvetica', sans-serif; font-size: 12px; width: 100%;">
							<tr>
								<td colspan="2"><h2>Nutrition Facts</h2></td>
							</tr>
							<tr>
								<td colspan="2" id="serving"><i>Serving Size 100 g</i></td>
							</tr>
							<tr>
								<td colspan="2" style="background-color: black; height: 5px;">&nbsp;</td> <!-- Big Spacer -->
							</tr>
							<tr>
								<td colspan="2" style="border-bottom: 1px solid #000;"><strong>Amount Per Serving</strong></td>
							</tr>
							<tr>
								<td colspan="2">
									<table style="font-family: 'Helvetica', sans-serif; font-size: 12px; width: 100%;">
										<tr>
											<td style="width: 50%;"><strong>Calories</strong> <span id="cal"></span></td>
											<td style="width: 50%; text-align: right;">Calores from Fat <span id="fromFat"></span></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="background-color: black; height: 2px">&nbsp;</td> <!-- Spacer -->
							</tr>
							<tr>
								<td colspan="2" style="text-align: right; border-bottom: 1px solid #000;"><strong>Values</strong></td>
							</tr>
							<tr>
								<td style="width: 75%; border-bottom: 1px solid #000;"><strong>Total Fat (g)</strong></td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="fat"></td>
							</tr>
							<tr>
								<td style="width: 75%; text-indent: 2em; border-bottom: 1px solid #000;">Saturated Fat (g)</td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="sat"></td>
							</tr>
							<tr>
								<td style="width: 75%; text-indent: 2em; border-bottom: 1px solid #000;">Monounsaturated Fat (g)</td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="mono"></td>
							</tr>
							<tr>
								<td style="width: 75%; text-indent: 2em; border-bottom: 1px solid #000;">Polyunsaturated Fat (g)</td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="poly"></td>
							</tr>
							<tr>
								<td style="width: 75%; border-bottom: 1px solid #000;"><strong>Cholesterol (mg)</strong></td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="chol"></td>
							</tr>
							<tr>
								<td style="width: 75%; border-bottom: 1px solid #000;"><strong>Sodium (mg)</strong></td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="sodium"></td>
							</tr>
							<tr>
								<td style="width: 75%; border-bottom: 1px solid #000;"><strong>Total Carbohydrate (g)</strong></td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="carb"></td>
							</tr>
							<tr>
								<td style="width: 75%; text-indent: 2em; border-bottom: 1px solid #000;">Dietary Fiber (g)</td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="fiber"></td>
							</tr>
							<tr>
								<td style="width: 75%; text-indent: 2em; border-bottom: 1px solid #000;">Sugars (g)</td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="sugar"></td>
							</tr>
							<tr>
								<td style="width: 75%; border-bottom: 1px solid #000;"><strong>Protein (g)</strong></td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="protein"></td>
							</tr>
							<tr>
								<td style="width: 75%; border-bottom: 1px solid #000;"><strong>Caffeine (mg)</strong></td>
								<td style="width: 25%; text-align: right; border-bottom: 1px solid #000;" id="caffeine"></td>
							</tr>
							<tr>
								<td colspan="2" style="background-color: black; height: 5px;">&nbsp;</td> <!-- Big Spacer -->
							</tr>
							<tr>
								<td colspan="2">
									<table style="font-family: 'Helvetica', sans-serif; font-size: 12px; width: 100%;">
										<tr>
											<td style="width: 175px; border-bottom: 1px solid #000;"><strong>Vitamin A</strong> <span id="vita" style="float: right;"></span></td>
											<td style="width: 175px; border-bottom: 1px solid #000; text-indent: 0.5em;"><strong>Vitamin B-6</strong> <span id="vitb6" style="float: right;"></span></td>
										</tr>
										<tr>
											<td style="width: 175px; border-bottom: 1px solid #000;"><strong>Vitamin B-12</strong> <span id="vitb12" style="float: right;"></span></td>
											<td style="width: 175px; border-bottom: 1px solid #000; text-indent: 0.5em;"><strong>Vitamin D</strong> <span id="vitd2" style="float: right;"></span></td>
										</tr>
										<tr>
											<td style="width: 175px; border-bottom: 1px solid #000;"><strong>Vitamin E</strong> <span id="vite" style="float: right;"></span></td>
											<td style="width: 175px; border-bottom: 1px solid #000; text-indent: 0.5em;"><strong>Vitamin K</strong> <span id="vitk" style="float: right;"></span></td>
										</tr>
										<tr>
											<td style="width: 175px; border-bottom: 1px solid #000;"><strong>Calcium</strong> <span id="calcium" style="float: right;"></span></td>
											<td style="width: 175px; border-bottom: 1px solid #000; text-indent: 0.5em;"><strong>Folate</strong> <span id="folate" style="float: right;"></span></td>
										</tr>
										<tr>
											<td style="width: 175px; border-bottom: 1px solid #000;"><strong>Iron</strong> <span id="iron" style="float: right;"></span></td>
											<td style="width: 175px; border-bottom: 1px solid #000; text-indent: 0.5em;"><strong>Magnesium</strong> <span id="magnesium" style="float: right;"></span></td>
										</tr>
										<tr>
											<td style="width: 175px; border-bottom: 1px solid #000;"><strong>Niacin</strong> <span id="niacin" style="float: right;"></span></td>
											<td style="width: 175px; border-bottom: 1px solid #000; text-indent: 0.5em;"><strong>Phosphorus</strong> <span id="phosphorus" style="float: right;"></span></td>
										</tr>
										<tr>
											<td style="width: 175px; border-bottom: 1px solid #000;"><strong>Potassium</strong> <span id="potassium" style="float: right;"></span></td>
											<td style="width: 175px; border-bottom: 1px solid #000; text-indent: 0.5em;"><strong>Riboflavin</strong> <span id="riboflavin" style="float: right;"></span></td>
										</tr>
										<tr>
											<td style="width: 175px;"><strong>Thiamin</strong> <span id="thiamin" style="float: right;"></span></td>
											<td style="width: 175px; text-indent: 0.5em;"><strong>Zinc</strong> <span id="zinc" style="float: right;"></span></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div> <!-- End Nutrition Facts -->

					<br />

					<strong>How many:</strong> <input id="itemCount" type="number" min="0" onchange="javascript: AddFood.formatStop(this.value);" style="width: 55px;" value="0" />&nbsp;&nbsp;&nbsp;
					<strong>Type:</strong> <select id="measure"><option>Gram</option><option>Cup</option><option>Ounce</option></select>&nbsp;&nbsp;&nbsp;
					<button class="btn btn-success" onclick="javascript: AddFood.convert();">Convert</button><br /><br />

					<sub><b><i>*Note: You must select a category before you can add any item!</i></b></sub><br /><br />

					<label class="control-label" for="addType">Category: </label>
					<select id="addType" onchange="javascript: AddFood.enableBtn();"><option></option><option>Breakfast</option><option>Lunch</option><option>Dinner</option><option>Snack</option></select>&nbsp;&nbsp;&nbsp;
					<label class="control-label" for="addDate">Date: </label>
					<input id="addDate" value="<?php echo date('m/d/Y'); ?>" style="width: 80px;" />&nbsp;&nbsp;&nbsp;
					<button class="btn btn-primary" id="addThisItem" onclick="javascript: AddFood.addFoodItem();" disabled>Add Item</button>
				</div> <!-- End Modal Body -->

				<div class="modal-footer"> <!-- Start Modal Footer -->
					<button class="btn btn-info" style="float: left;" onclick="javascript: AddFood.addToFavs();">Add To Favorites</button>
					<button class="btn btn-default" data-dismiss="modal">Close</button>
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
		AddFood.getFavorites();

		$("#addDate").datepicker({
			autoclose: true
		});
	});
</script>