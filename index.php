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
	</head>

	<body>

		<div id="container" style="margin-left: auto; margin-right: auto; width: 1200px; padding-top: 25px;"> <!-- Start Container -->

			<div id="menu"> <!-- Start Menu -->
				<div class="list-group">
					<div class="list-group-item" style="font-size: 22px; text-align: center; height: 100px; padding-top: 28px;">
						Daily Calories Left:<br /> 1000
					</div>

					<a href="#" class="list-group-item" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-list-alt"></span> History
					</a>

					<a href="index.php?view=AddFood" class="list-group-item AddFood" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-cutlery"></span> Add Food
					</a>

					<a href="index.php?view=EditFood" class="list-group-item" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-erase"></span> Edit Food
					</a>

					<a href="#" class="list-group-item" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-blackboard"></span> Notes
					</a>

					<a href="#" class="list-group-item" style="font-size: 20px; text-align: center; padding: 15px;">
						<span class="glyphicon glyphicon-stats"></span> Stats
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

					<div style="text-align: center; padding: 25px;">
						<button class="btn btn-success">Quick Add</button>
					</div>

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
	</script>

</html>