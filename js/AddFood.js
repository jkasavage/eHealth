/**
 * Club Systems Nutrition - Add Food Events
 *
 * @copyright Club Systems 2015
 * @author Joe Kasavage
 */

var AddFood = {
	/**
	 * Store Food Items for Pagination
	 * 
	 * @type {Array}
	 */
	store: [],

	/**
	 * Page Count
	 * 
	 * @type {Number}
	 */
	page: 0,

	/**
	 * Selected Item
	 * 
	 * @type {Array}
	 */
	item: [],

	/**
	 * Store Conversion Data
	 * 
	 * @type {Array}
	 */
	convertItem: [],

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
				data = JSON.parse(data);

				AddFood.item = data[0];

				if(data) {
					var calFromFat = data[0].fat * 9;
					var calFromCarb = data[0].carb * 4;
					var calFromPro = data[0].protein * 4;

					$("#itemCount").val('0');
					$("#serving").html("<i>Serving Size 100 g</i>");

					$(".foodName").html(data[0].name.toUpperCase());
					$("#cal").html(Math.ceil(calFromFat + calFromCarb + calFromPro));
					$("#fromFat").html(Math.floor(parseInt(data[0].fat) * 9));
					$("#fat").html(Math.ceil(data[0].fat));
					$("#sat").html(Math.ceil(data[0].sat));
					$("#mono").html(Math.ceil(data[0].mono));
					$("#poly").html(Math.ceil(data[0].poly));
					$("#chol").html(Math.ceil(data[0].chol));
					$("#sodium").html(Math.ceil(data[0].sodium));
					$("#carb").html(Math.ceil(data[0].carb));
					$("#fiber").html(Math.ceil(data[0].fiber));
					$("#sugar").html(Math.ceil(data[0].sugar));
					$("#protein").html(Math.ceil(data[0].protein));
					$("#vita").html(Math.ceil((data[0].vita2 / 5000) * 100) + " %");
					$("#vitb6").html(Math.ceil(((data[0].vitb6) / 2) * 100) + " %");
					$("#vitb12").html(Math.ceil((data[0].vitb12 / 6) * 100) + " %");
					$("#vitd2").html(Math.ceil((data[0].vitd2 / 400) * 100) + " %");
					$("#vite").html(Math.ceil((data[0].vite * 1.4 / 30) * 100) + " %");
					$("#vitk").html(Math.ceil((data[0].vitk / 80) * 100) + " %");
					$("#calcium").html(Math.ceil((data[0].calcium / 1000) * 100) + " %");
					$("#folate").html(Math.ceil((data[0].folate / 400) * 100) + " %");
					$("#iron").html(Math.ceil((data[0].iron / 18) * 100) + " %");
					$("#magnesium").html(Math.ceil((data[0].magnesium / 400) * 100) + " %");
					$("#niacin").html(Math.ceil((data[0].niacin / 20) * 100) + " %");
					$("#phosphorus").html(Math.ceil((data[0].phosphorus / 1000) * 100) + " %");
					$("#potassium").html(Math.ceil((data[0].potassium / 3500) * 100) + " %");
					$("#riboflavin").html(Math.ceil((data[0].riboflavin / 1.7) * 100) + " %");
					$("#thiamin").html(Math.ceil((data[0].thiamin / 1.5) * 100) + " %");
					$("#zinc").html(Math.ceil((data[0].zinc / 15) * 100) + " %");
					$("#caffeine").html(Math.ceil(data[0].caffeine));

					$("#foodModal").modal("show");

					AddFood.breakDown();
				} else {
					alert("There was a problem getting the information for that item. Please try again.\n\nError Code: GetFoodItem2");
				}
			},
			error: function(xhr) {
				console.log(xhr);
				alert("There appears to be an error. Please try again.\n\nError Code: GetFoodItem1");
			}
		});
	},

	/**
	 * Get Item Object to smallest factor (1g)
	 * 
	 * @return {undefined}
	 */
	breakDown: function() {
		AddFood.item.energy = parseInt(AddFood.item.energy) / 100;
		AddFood.item.protein = parseInt(AddFood.item.protein) / 100;
		AddFood.item.fat = parseInt(AddFood.item.fat) / 100;
		AddFood.item.carb = parseInt(AddFood.item.carb) / 100;
		AddFood.item.fiber = parseInt(AddFood.item.fiber) / 100;
		AddFood.item.sugar = parseInt(AddFood.item.sugar) / 100;
		AddFood.item.calcium = parseInt(AddFood.item.calcium) / 100;
		AddFood.item.iron = parseInt(AddFood.item.iron) / 100;
		AddFood.item.magnesium = parseInt(AddFood.item.magnesium) / 100;
		AddFood.item.phosphorus = parseInt(AddFood.item.phosphorus) / 100;
		AddFood.item.potassium = parseInt(AddFood.item.potassium) / 100;
		AddFood.item.sodium = parseInt(AddFood.item.sodium) / 100;
		AddFood.item.zinc = parseInt(AddFood.item.zinc) / 100;
		AddFood.item.vitc = parseInt(AddFood.item.vitc) / 100;
		AddFood.item.thiamin = parseInt(AddFood.item.thiamin) / 100;
		AddFood.item.riboflavin = parseInt(AddFood.item.riboflavin) / 100;
		AddFood.item.niacin = parseInt(AddFood.item.niacin) / 100;
		AddFood.item.vitb6 = parseInt(AddFood.item.vitb6) / 100;
		AddFood.item.folate = parseInt(AddFood.item.folate) / 100;
		AddFood.item.vitb12 = parseInt(AddFood.item.vitb12) / 100;
		AddFood.item.vita = parseInt(AddFood.item.vita) / 100;
		AddFood.item.vita2 = parseInt(AddFood.item.vita2) / 100;
		AddFood.item.vite = parseInt(AddFood.item.vite) / 100;
		AddFood.item.vitd = parseInt(AddFood.item.vitd) / 100;
		AddFood.item.vitd2 = parseInt(AddFood.item.vitd2) / 100;
		AddFood.item.vitk = parseInt(AddFood.item.vitk) / 100;
		AddFood.item.sat = parseInt(AddFood.item.sat) / 100;
		AddFood.item.mono = parseInt(AddFood.item.mono) / 100;
		AddFood.item.poly = parseInt(AddFood.item.poly) / 100;
		AddFood.item.chol = parseInt(AddFood.item.chol) / 100;
		AddFood.item.caffeine = parseInt(AddFood.item.caffeine) / 100;
	},

	/**
	 * Make sure only Numbers
	 * 
	 * @param  {string} input
	 * 
	 * @return {undefined}
	 */
	formatStop: function(input) {
		if(isNaN(parseInt(input))) {
			$("#itemCount").val('0');
		} else if(input < 0) {
			$("#itemCount").val('0');
		} else {
			return true;
		}
	},

	/**
	 * Conversion Method
	 * 
	 * @return {undefined}
	 */
	convert: function() {
		var measure = $("#measure option:selected").val();
		var mCount = parseInt($("#itemCount").val());

		if(mCount <= 0) {
			alert("You must enter a number to convert this item!\n\nError Code: ConvertItem1");
			return false;
		} else {
			switch(measure) {
				case 'Gram':
					for(var i in AddFood.item) {
						if(isNaN(parseInt(AddFood.item[i]))) {
							continue;
						} else {
							AddFood.convertItem[i] = Math.ceil(parseFloat(AddFood.item[i]) * mCount);
						}
					}
					break;

				case 'Cup':
					for(var i in AddFood.item) {
						if(isNaN(parseInt(AddFood.item[i]))) {
							continue;
						} else {
							AddFood.convertItem[i] = Math.ceil((parseFloat(AddFood.item[i]) * 227) * mCount);
						}
					}
					break;

				case 'Ounce':
					for(var i in AddFood.item) {
						if(isNaN(parseInt(AddFood.item[i]))) {
							continue;
						} else {
							AddFood.convertItem[i] = Math.ceil((parseFloat(AddFood.item[i]) * 28.34) * mCount);
						}
					}
					break;
			}
		}

		var m = (measure == "Gram") ? "g":(measure == "Cup") ? "c":"oz";

		$("#serving").html('<i>Serving Size ' + mCount + " " + m);

		var calFromFat = AddFood.convertItem.fat * 9;
		var calFromCarb = AddFood.convertItem.carb * 4;
		var calFromPro = AddFood.convertItem.protein * 4;

		$("#cal").html(Math.ceil(calFromFat + calFromCarb + calFromPro));
		$("#fromFat").html(Math.floor(parseInt(AddFood.convertItem.fat) * 9));

		$("#fat").html(Math.ceil(AddFood.convertItem.fat));
		$("#sat").html(Math.ceil(AddFood.convertItem.sat));
		$("#mono").html(Math.ceil(AddFood.convertItem.mono));
		$("#poly").html(Math.ceil(AddFood.convertItem.poly));
		$("#chol").html(Math.ceil(AddFood.convertItem.chol));
		$("#sodium").html(Math.ceil(AddFood.convertItem.sodium));
		$("#carb").html(Math.ceil(AddFood.convertItem.carb));
		$("#fiber").html(Math.ceil(AddFood.convertItem.fiber));
		$("#sugar").html(Math.ceil(AddFood.convertItem.sugar));
		$("#protein").html(Math.ceil(AddFood.convertItem.protein));
		$("#vita").html(Math.ceil((AddFood.convertItem.vita2 / 5000) * 100) + " %");
		$("#vitb6").html(Math.ceil(((AddFood.convertItem.vitb6) / 2) * 100) + " %");
		$("#vitb12").html(Math.ceil((AddFood.convertItem.vitb12 / 6) * 100) + " %");
		$("#vitd2").html(Math.ceil((AddFood.convertItem.vitd2 / 400) * 100) + " %");
		$("#vite").html(Math.ceil((AddFood.convertItem.vite * 1.4 / 30) * 100) + " %");
		$("#vitk").html(Math.ceil((AddFood.convertItem.vitk / 80) * 100) + " %");
		$("#calcium").html(Math.ceil((AddFood.convertItem.calcium / 1000) * 100) + " %");
		$("#folate").html(Math.ceil((AddFood.convertItem.folate / 400) * 100) + " %");
		$("#iron").html(Math.ceil((AddFood.convertItem.iron / 18) * 100) + " %");
		$("#magnesium").html(Math.ceil((AddFood.convertItem.magnesium / 400) * 100) + " %");
		$("#niacin").html(Math.ceil((AddFood.convertItem.niacin / 20) * 100) + " %");
		$("#phosphorus").html(Math.ceil((AddFood.convertItem.phosphorus / 1000) * 100) + " %");
		$("#potassium").html(Math.ceil((AddFood.convertItem.potassium / 3500) * 100) + " %");
		$("#riboflavin").html(Math.ceil((AddFood.convertItem.riboflavin / 1.7) * 100) + " %");
		$("#thiamin").html(Math.ceil((AddFood.convertItem.thiamin / 1.5) * 100) + " %");
		$("#zinc").html(Math.ceil((AddFood.convertItem.zinc / 15) * 100) + " %");
		$("#caffeine").html(Math.ceil(AddFood.convertItem.caffeine));
	}
};