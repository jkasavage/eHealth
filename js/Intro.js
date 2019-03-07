/**
 * Introduction Events
 *
 * @author Joe Kasavage
 */

// Start Events
$(function() {
	$("#intro").modal({
		backdrop: 'static',
		keyboard: false
	});

	$("#intro").modal("show");
});

var introEvents = {
	/**
	 * Member Number
	 * 
	 * @type {String}
	 */
	member: "",

	/**
	 * Age
	 * 
	 * @type {Number}
	 */
	age: 0,

	/**
	 * Weight
	 * 
	 * @type {Number}
	 */
	weight: 0,

	/**
	 * Height
	 * 
	 * @type {Number}
	 */
	height: 0,

	/**
	 * Nick Name
	 * 
	 * @type {String}
	 */
	name: "",

	/**
	 * Gender
	 * 
	 * @type {String}
	 */
	gender: "",

	/**
	 * BMI
	 * 
	 * @type {Number}
	 */
	bmi: 0,

	/**
	 * Calorie Intake
	 * 
	 * @type {Number}
	 */
	calories: 0,

	/**
	 * Gather needed Information
	 */
	getData: function() {
		$("#introHeader").html('<h4 class="modal-title">Required Information</h4>');
		$("#introFooter").html('<button class="btn btn-info" onclick="javascript: introEvents.dataValid();">Next</button>');

		$("#introBody").html('');
		$("#introBody").append('<div id="getName"><strong>Name <sup>*What your friends call you*</sup></strong><br /><input id="introName" /></div><br />');
		$("#introBody").append('<div id="getAge"><strong>Age</strong><br /><input id="introAge" style="width: 40px;" /></div><br />');
		$("#introBody").append('<div id="getGender"><strong>Gender</strong><br /><select id="introGender"><option></option><option>Male</option><option>Female</option></select><div><br />');
		$("#introBody").append('<div id="getWeight"><strong>Weight</strong><br /><input id="introWeight" style="width: 50px;" /></div><br />');
		$("#introBody").append('<div id="getHeight"><strong>Height <sup>*Inches*</sup></strong><br /><input id="introHeight" style="width: 50px;" /></div><br />');
	},

	/**
	 * Validate Information
	 */
	dataValid: function() {
		var uName = $("#introName").val();
		var uAge = $("#introAge").val();
		var uGender = $("#introGender option:selected").val();
		var uWeight = $("#introWeight").val();
		var uHeight = $("#introHeight").val();

		var errorCount = 0;

		$("#introBody .alert").hide();

		if(!/^[a-z]+$/i.test(uName)) {
			$("#getName").append('<div class="alert alert-danger">You may only use letters as your given <b>Name</b>.</div>');
			errorCount++;
		} else if(!/^[0-9]+$/.test(uAge)) {
			$("#getAge").append('<div class="alert alert-danger">You may only use numbers in the <b>Age</b> field.</div>');
			errorCount++;
		} else if(uGender.length == 0) {
			$("#getGender").append('<div class="alert alert-danger">You must select either Male or Femele as your <b>Gender</b>.</div>');
			errorCount++;
		} else if(uWeight.length == 0 || !/^[0-9]+$/.test(uWeight)){
			$("#getWeight").append('<div class="alert alert-danger">You must enter a valid <b>Weight</b> to continue.</div>');
			errorCount++;
		} else if(uHeight.length == 0 || !/^[0-9]+$/.test(uHeight)) {
			$("#getHeight").append('<div class="alert alert-danger">You must enter a valid <b>Height</b> to continue.</div>');
			errorCount++;
		}

		if(errorCount > 0) {
            errorCount = 0;
			return false;
		} else {
            errorCount = 0;

			introEvents.name = uName;
			introEvents.age = uAge;
			introEvents.gender = uGender;
			introEvents.weight = uWeight;
			introEvents.height = uHeight;
			introEvents.member = $("#memberNumber").val();

			introEvents.showData();
		}
	},

	/**
	 * Calculate BMI
	 * 
	 * @return {Number}
	 */
	getBMI: function() {
		introEvents.bmi = Math.ceil((introEvents.weight / (Math.pow(introEvents.height,2))) * 703);
		return introEvents.bmi;
	},

	/**
	 * Calculate Calories
	 * 
	 * @return {Number}
	 */
	getCalories: function() {
		introEvents.calories = Math.ceil(((introEvents.weight * 2.2) * 3.1) * 2);
		return introEvents.calories;
	},

	/**
	 * Display Data
	 */
	showData: function() {
		$("#introHeader").html('<h4 class="modal-title">Calculated Data</h4>');
		$("#introFooter").html('<button class="btn btn-info" onclick="javascript: introEvents.present();">Next</button>');

		$("#introBody").html('');
		$("#introBody").append('<strong>Your Current BMR:</strong> ' + introEvents.getBMI() + "<br /><br />");
		$("#introBody").append('<strong>Recommend Daily Calorie Intake:</strong> ' + introEvents.getCalories() + "<br /><br />");
		$("#introBody").append('The numbers above are not set in stone. Find out what works for you and change your diet accordingly.<br /><br />');
		$("#introBody").append('If you are trying to lose weight we would recommend going slowly and starting at 1 pound a week.<br /><br />');
		$("#introBody").append('If this was the case your daily calorie limit would look like: ' + Math.ceil((introEvents.calories * 7) - 3500) / 7);
	},

    /**
     * Start Presentation
     */
	present: function() {
        $("#introHeader").html('<h4 class="modal-title">Walkthrough</h4>');
        $("#introFooter").html('<button class="btn btn-info" onclick="javascript: introEvents.presentMenu();">Next</button>');

        $("#introBody").html('');
        $("#introBody").html('The main portion of user nagivation is the menu, to the right. Click the next button to proceed.');
	},

    /**
     * Open and Explain the Menu
     */
    presentMenu: function() {
        $("#introFooter").html('<button class="btn btn-info" onclick="javascript: introEvents.presentTicket();">Next</button>');
        introEvents.openMenu();

        $("#introBody").html('With the side menu you can pick from the available opitions. One of the most important options is the Ticket link. <br /><br />');
        $("#introBody").append('Click the next button to continue.');
    },

    /**
     * Show and explain Ticket link
     */
    presentTicket: function() {
        $("#introFooter").html('<button class="btn btn-info" onclick="javascript: introEvents.presentClose();">Next</button>');

        introEvents.highlightTicket();
        $("#introBody").html('Here at Some Company we strive to excel in customer service. If you wish to send us an idea or point out a bug just click on the Ticket link to the right.<br /><br />');
        $("#introBody").append('Click the next button to continue.');
    },

    /**
     * End Presentation
     */
    presentClose: function() {
        $("#introFooter").html('');
        introEvents.removeHighlight();
        introEvents.openMenu();

        $("#introBody").html('This ends the quick presentation. We hope you enjoy your experience and look forward to your comments!<br /><br />');
        $("#introBody").append('Please give us a moment to update your information...');

        introEvents.sendData();
    },

    /**
     * Close Modal
     */
    closeModal: function() {
        $("#intro").modal('hide');
    },

    /**
     * Highlight Ticket
     */
    highlightTicket: function() {
        $(".Tickets").addClass('active');
    },

    /**
     * Remove Highlight
     */
    removeHighlight: function() {
        $(".Tickets").removeClass('active');
    },

    /**
     * Open Side Menu
     */
    openMenu: function() {
        $(".toggler").click();
    },

    /**
     * Save Information
     */
    sendData: function() {
        $.ajax({
            type: "POST",
            url: "./model/Intro.Model.php",
            data: {
                member: introEvents.member,
                age: introEvents.age,
                weight: introEvents.weight,
                height: introEvents.height,
                name: introEvents.name,
                gender: introEvents.gender,
                bmi: introEvents.bmi,
                calories: introEvents.calories
            },
            success: function(data) {
                if(data == "1") {
                    $("#introBody").html('Your information has been updated! Please click the Next button to proceed.');
                    $("#introFooter").html('<button class="btn btn-info" onclick="javascript: introEvents.closeModal();">Next</button>');
                } else {
                    $("#introBody").html('There appears to be a problem updating your information. If this continues please contact technical support.<br /><br />');
                    $("#introBody").append('<a href="#" onclick="javascript: introEvents.sendData();">Click here to try again.</a>');
                }
            },
            error: function(xhr) {
                console.log(xhr);
                $("#introBody").html('There appears to be a problem updating your information. If this continues please contact technical support.<br /><br />');
                $("#introBody").append('<a href="#" onclick="javascript: introEvents.sendData();">Click here to try again.</a>');
            }
        });
    }
};