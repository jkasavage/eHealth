<?php
/**
 * Club Systems Nutrition - Meals View
 *
 * @copyright Club Systems 2015
 * @author Joe Kasavage
 */
?>

<div id="meals"> <!-- Start Container -->

	<div class="page-header" style="text-align: left;"> <!-- Start Header -->
		<h1><span class="glyphicon glyphicon-apple"></span> Meals <small>Create and Customize your own Meals.</small></h1>
	</div> <!-- End Header -->

	<div class="dropdown"> <!-- Start Dropdown Menu -->

		<button class="btn btn-default dropdown toggle" type="button" id="mealMenu" style="font-size: 16px; font-weight: bold;" data-toggle="dropdown" aria-expanded="true">
			Menu <span class="caret"></span>
		</button>

		<ul class="dropdown-menu" role="menu" aria-labelledby="mealMenu">
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Create Meal</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Edit Meal</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Delete Meal</a></li>
		</ul>
		
	</div> <!-- End Dropdown Menu -->

	<div id="mealContent"> <!-- Start Meal Content -->

	</div> <!-- End Meal Content -->

</div> <!-- End Container -->

<script src="js/Meals.js"></script>