/**
 * Club Systems Nutrition - Add Food Events
 *
 * @copyright Club Systems 2015
 * @author Joe Kasavage
 */

var AddFood = {
	/**
	 * Store Food Items for Pagination
	 * @type {Array}
	 */
	store: [],

	/**
	 * Page Count
	 * @type {Number}
	 */
	page: 0,

	/**
	 * Get Food Categories
	 *
	 * @return {undefined}
	 */
	getFoodCats: function() {
		$.ajax({
			type: "POST",
			url: "controller/GetFood.Controller.php",
			data: {
				task: "getFoodCats"
			},
			success: function(data) {
				if (data) {
					data = JSON.parse(data);

					for (var i = 0; i < data.length; i++) {
						$("#foodCats").append('<option id="' + data[i].fdgrp_cd + '">' + data[i].fdgrp_desc + '</option>');
					}
				} else {
					alert("There appears to be an error. Please try again.\n\nError Code: GetFoodCats2");
				}
			},
			error: function(xhr) {
				console.log(xhr);
				alert("There appears to be an error. Please try again.\n\nError Code: GetFoodCats1");
			}
		});
	},

	/**
	 * Get User Meal Names
	 *
	 * @return {undefined}
	 */
	getMeals: function() {
		$.ajax({
			type: "POST",
			url: "controller/GetFood.Controller.php",
			data: {
				task: "getMeals",
				member: $("#memberNumber").val()
			},
			success: function(data) {
				data = JSON.parse(data);

				if (typeof data[0] != 'undefined') {
					for (var i = 0; i < data.length; i++) {
						$("#mealItems").append('<option id="' + data[i].id + '">' + data[i].description + '</option>');
					}

					$("#mealBtn").show();
				} else {
					$("#mealItems").html("<option>No Saved Meals</option>");
					$("#mealItems").prop("disabled", true);
				}
			},
			error: function(xhr) {
				console.log(xhr);
				alert("There appears to be an error. Please try again.\n\nError Code: GetMeals1");
			}
		});
	},

	/**
	 * Search By Category
	 * 
	 * @return {undefined}
	 */
	categorySearch: function() {
		var e = document.getElementById('foodCats');
		var category = e.options[e.selectedIndex].id;

		$.ajax({
			type: "POST",
			url: "controller/GetFood.Controller.php",
			data: {
				task: 'getCategoryItems',
				category: category
			},
			success: function(data) {
				data = JSON.parse(data);

				if (typeof data[0] != 'undefined') {
					$(".searchResults").html('');

					$("#pages").html('');

					AddFood.store = data;

					for (var i = 0; i < 10; i++) {
						$(".searchResults").append('<a href="#" onClick="javascript: AddFood.getFoodDetails(this.id);" id="' + AddFood.store[i].number + '">' + AddFood.store[i].name + '</a><br />');
					}

					AddFood.addPageButtons();

					$("#results").fadeIn();
				} else {
					$(".searchResults").html('');
					$("#pages").html('');
					$(".searchResults").append('<strong>We\'re sorry, but there are currently no items in this category.</strong>');
				}
			},
			error: function(xhr) {
				console.log(xhr);
				alert("There appears to be an error. Please try again.\n\nError Code: ItemSearch1");
			}
		});
	},

	/**
	 * Add Page Buttons to Category Search
	 *
	 * @return {undefined}
	 */
	addPageButtons: function() {
		$(".searchResults").append('<br /><button class="btn btn-default" id="previous" onClick="javascript: AddFood.categoryPrevious();" disabled style="float: left;">Previous</button>');
		$(".searchResults").append('<button class="btn btn-default" id="next" onClick="javascript: AddFood.categoryNext();" style="float: right;">Next</button><br />');
		$("#pages").html('<strong style="style="float: right;">' + (AddFood.page + 1) + ' of ' + Math.ceil(AddFood.store.length/10) + '</strong>');
	},

	/**
	 * Next Button for Category Search
	 * 
	 * @return {undefined}
	 */
	categoryNext: function() {
		AddFood.page++;

		$(".searchResults").html('');

		var start = AddFood.page * 10;
		var stop = start + 10;

		for(var i=start; i < stop; i++) {
			if(typeof AddFood.store[i] != 'undefined') {
				$(".searchResults").append('<a href="#" onClick="javascript: AddFood.getFoodDetails(this.id);" id="' + AddFood.store[i].number + '">' + AddFood.store[i].name + '</a><br />');
			} else {
				break;
			}
		}

		AddFood.addPageButtons();
		AddFood.buttonCheck();
	},

	/**
	 * Previous Button for Category Search
	 * 
	 * @return {undefined}
	 */
	categoryPrevious: function() {
		AddFood.page--;

		$('.searchResults').html('');

		var start = (AddFood.page === 0) ? 10:(AddFood.page === 1) ? 20:AddFood.page * 10 + 10;
		var stop = start - 10;

		for(var i=stop; i < start; i++) {
			if(typeof AddFood.store[i] != 'undefined') {
				$(".searchResults").append('<a href="#" onClick="javascript: AddFood.getFoodDetails(this.id);" id="' + AddFood.store[i].number + '">' + AddFood.store[i].name + '</a><br />');
			} else {
				break;
			}
		}

		AddFood.addPageButtons();
		AddFood.buttonCheck();
	},

	/**
	 * Disable buttons as needed
	 * 
	 * @return {undefined}
	 */
	buttonCheck: function()
	{
		if(AddFood.page === 0) {
			$("#previous").prop("disabled", true);
		} else {
			$('#previous').prop('disabled', false);
		}

		if(AddFood.page + 1 >= Math.ceil(AddFood.store.length/10)) {
			$('#next').prop('disabled', true);
		}
	},

	/**
	 * Get Item on Click
	 * 
	 * @param  {string} item
	 * 
	 * @return {undefined}
	 */
	getFoodDetails: function(item) {
		$.ajax({
			type: "POST",
			url: "controller/GetFood.Controller.php",
			data: {
				task: "getFoodItem",
				item: item
			},
			success: function(data) {
				console.log(data);
			},
			error: function(xhr) {
				console.log(xhr);
				alert("There appears to be an error. Please try again.\n\nError Code: GetFoodItem1");
			}
		});
	}
};