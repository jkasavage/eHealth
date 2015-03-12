<?php
/**
 * Club Systems Nutrition
 *
 * @copyright Club Systems 2015
 * @author Joe Kasavage
 */
session_start();

if(!isset($_SESSION["server"])) {
	header("Location: https://www.healthclubsystems.com/member_new/member_login.php");
}

// CSF Auto Loader Instance
require_once('CS-Framework/AutoLoader.Class.php');
$auto = new CSF\Modules\AutoLoader();
$auto->register();

/**
 * Custom Error Handling
 */
set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext){
	if(0 === error_reporting()) {
		return false;
	}

	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
?>

<html>
	<head>
		<title>Club Systems - eHealth</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />
		<script src="includes/BootSideMenu.js"></script>
		<link rel="stylesheet" type="text/css" href="includes/BootSideMenu.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
		<script src="includes/DatePicker.js"></script>
		<link rel="stylesheet" type="text/css" href="includes/DatePicker.css" />
	</head>

	<body>

		<div id="container" style="margin-left: auto; margin-right: auto; width: 1200px; padding-top: 25px;"> <!-- Start Container -->

			<div id="menu"> <!-- Start Menu -->
				<div class="list-group">
					<div class="list-group-item daily" style="font-size: 22px; text-align: center; height: 100px; padding-top: 28px;">
						Daily Calories Left:<br /> <span id="dailyIntake"></span>
					</div>

					<a href="#" class="list-group-item" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-list-alt"></span> History
					</a>

					<a href="index.php?view=AddFood" class="list-group-item AddFood" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-cutlery"></span> Add Food
					</a>

					<a href="#" class="list-group-item" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-copy"></span> Create Food
					</a>

					<a href="index.php?view=Meals" class="list-group-item Meals" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-apple"></span> Meals
					</a>

					<a href="#" class="list-group-item" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-send"></span> Messenger
					</a>

					<a href="#" class="list-group-item" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-wrench"></span> Tools
					</a>

					<a href="#" class="list-group-item" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-scissors"></span> Settings
					</a>

					<a href="index.php?view=AddFood" class="list-group-item Tickets" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-envelope"></span> Tickets
					</a>

					<a href="https://www.healthclubsystems.com/member_new/accountportal.php" class="list-group-item" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-retweet"></span> Portal
					</a>

					<div style="text-align: center; font-size:12px; padding-top: 18%;">
						<strong>Powered by:</strong><br />
						<a href="https://www.healthclubsystems.com"><img src="img/cs.png" /></a>
					</div>
				</div>
			</div> <!-- End Menu -->

			<?php
				if($_SERVER["QUERY_STRING"])  {
					echo '<div id="home" style="position: absolute; top: 25px; left: 25px;"> <!-- Start Home Button -->
							  <a href="index.php" class="btn btn-primary">Home</a>
						  </div> <!-- End Home Button -->';
				}
			?>

			<div id="content" style="margin-right: auto; margin-left: auto;"> <!-- Start Content -->
				<?php
					try{
						if(isset($_GET["view"])) {
							include("view/" . $_GET["view"] . ".php");
						} else {
							include("view/Dashboard.php");
						}
					} catch(ErrorException $ex) {
						echo "<h3 style='font-weight: bold;'>We're sorry, this page either cannot be found or does not exist. <a onclick='javascript: history.go(-1);'>Click here to go back</a></h3>";
					}
				?>
			</div> <!-- End Content -->

		</div> <!-- End Container -->

		<div class="modal fade" id="intro"> <!-- Start Intro Modal -->
			<div class="modal-dialog">				<div class="modal-content">

					<div class="modal-header" id="introHeader"> <!-- Start Modal Header -->
						<h4 class="modal-title">Introduction</h4>
					</div> <!-- End Modal Header -->

					<div class="modal-body" id="introBody"> <!-- Start Modal Body -->
						<strong>Welcome to Club Systems eHealth!</strong><br /><br />

						As with ever aspect of our software we are bringing you the best of the nutrition world.<br /><br />
						In order to proceed we are going to need some information to form your profile to ensure
						that you are being shown the most up to date information in the fitness world.<br /><br /> When you
						are ready to continue please click on the "Next" button below.
					</div> <!-- End Modal Body -->

					<div class="modal-footer" id="introFooter"> <!-- Start Modal Footer -->
						<button class="btn btn-info" onclick="javascript: introEvents.getData();">Next</button>
					</div> <!-- End Modal Footer -->
				</div>
			</div>
		</div> <!-- End Intro Modal -->

		<?php 
			echo '<input id="memberNumber" type="hidden" value="' . $_SESSION["memno"] . '" />';
		?>

	</body>

	<script>
		// Initialize Side Menu
		$("#menu").BootSideMenu({
			side: "right",
			autoClose: true
		});

		$(function() {
			// Get current Daily Calories
			$.ajax({
				type: "POST",
				url: "controller/Calories.Controller.php",
				data: {
					task: 'getIntake',
					member: $("#memberNumber").val()
				},
				success: function(data) {
					$("#dailyIntake").html(data);
				},
				error: function(xhr) {
					console.log(xhr);
					alert("There appears to be an error retrieving your information. Please try again.\n\nError Code: DailyIntake1");
				}
			});
		});
	</script>

	<?php
		$selectParam = array(
				"table"=>"users"
			);

		$db = new CSF\Modules\Data("nutrition");

		$check = $db->selectData($selectParam)
					->where(array("member"=>$_SESSION["memno"]))
					->execute();

		if(!isset($check[0]["member"])) {
			echo '<script src="js/Intro.js"></script>';
		}
	?>
</html>