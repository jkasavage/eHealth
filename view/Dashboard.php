<?php
/**
 * Dashboard View
 *
 * @author Joe Kasavage
 */

?>

<div id="dash"> <!-- Start Container -->
	<div id="clubLogo" style="margin-left: auto; margin-right: auto; width: 100%;"> <!-- Logo Start -->
		<?php
			if(isset($_SERVER["identifier"])) {
				$logo = "../images/clublogo" . $_SERVER["systemIdentifier"] . ".png";

				if(file_exists($logo)) {
					echo '<img src="' . $logo . '" />';
				}
			}
		?>
	</div> <!-- Logo End -->

	<div class="page-header" style="text-align: left;"> <!-- Start Header -->
		<h1><span class="glyphicon glyphicon-scale"></span> Nutrition <small>Eat Healthy, Live Longer!</small></h1>
	</div> <!-- End Header -->

	Welcome <?php echo $_SESSION["memberNumber"]; ?>!

</div> <!-- End Container -->