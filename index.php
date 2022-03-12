<?php 

//This is where anyone can view bookings made by teachers calender
//There is a lot of methods here which are connected to the javascript page

//There are two PHP forms which allows users to select a school and then a location in that school
//When the submit button is pressed, it connects with the database and outputs all the data in rows
//This is done using a while loop to output all rows of data from the database
//These rows are selected first according to the school and location chosen
//These rows are being insertd into Javascript variables and methods which are sent to the Javascript file 

include 'config.php';

error_reporting(0);

session_start();
?>



<!DOCTYPE html>
<html>
<head>
    <title>EduBookings</title>
 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="evo-calendar.css">
          <script src="script.js"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
</head>
<style>
    main {
        padding: 20px;
        max-width: 1366px;
        width: 100%;
        margin: 150px auto;
    }
    h1 {
        color: #755eb5;
    }
    h1 span {
        color: #616161;
    }
    hr {
        margin-bottom: 20px;
    }
    @media only screen and (max-width: 425px) {
        main {
            padding: 10px;
        }
    }
</style>
<body>
<header id="homeheader">
		
		<nav>	
		 <ul class="nav-bar"><div class="bg"></div>

		 <?php if (($_SESSION['username']) or ($_SESSION['adminusername']) ) { ?> 
		
		<li><a class="nav-link active" href="index.php">Home</a></li>
        <li><a class="nav-link" href="admin-page-profile.php">Profile</a></li>

		<li><a class="nav-link" href="contactus.php">Contact</a></li>
		<li><a class="nav-link" href="logout.php">Log Out</a></li>
		<li><a class="nav-link" href="view-calendar.php">View Bookings</a></li>


		<?php } else { ?> 

		<li><a class="nav-link active" href="index.php">Home</a></li>
		<li><a class="nav-link" href="adminlogin.php">Admin</a></li>
		<li><a class="nav-link" href="contactus.php">Contact</a></li>
		<li><a class="nav-link" href="login.php">Login</a></li>
		<li><a class="nav-link" href="register.php">Register</a></li>
		<li><a class="nav-link" href="view-calendar.php">View Bookings</a></li>


		<?php } ?>

        </header>


<!-- <div id="jquery-script-menu">
 
<div class="jquery-script-clear"></div>
</div> -->
</div>
    <main>
        <div class="calender_header">

        <div class="form_1">
        <form action="" method="POST">
            

			<p class="calender_option_header" style="font-size: 2rem; font-weight: 800;">Choose School</p>
			<select name="school" class="select_d">

<?php

$number = mysqli_query($conn, "SELECT school FROM adminusers ");

while ($row = mysqli_fetch_array($number, MYSQLI_NUM)) {

    $school_name = $row['0'];

?>
            <option value="<?php echo $school_name ?> ">   <?php echo $school_name ?>   </option>

<?php } ?>
            </select>
			
			<div class="input-group">
				<button name="submit" class="code_button">Find School</button>
			</div>
		</form>
        </div>

<?php 

if (isset($_POST['submit'])) {
	$school = ($_POST['school']);

    ?>
    <div class="form_1 form1">
    <form action="view-calender-bridge.php" method="POST">

    <p class="calender_option_header" style="font-size: 2rem; font-weight: 800;">Choose Location</p>

		    <select name="location_2" class="select_d">

<?php 

$table_1 = "SELECT locations_table FROM adminusers WHERE school='$school'";
$table_result = mysqli_query($conn, $table_1);
$table_check = mysqli_num_rows($table_result);

if($table_check > 0 ){

    while ($row = mysqli_fetch_assoc($table_result)){
        // $current_code = $row['1'];
        $get_table_name = $row['locations_table'];
        $_SESSION['table_name_global'] = $get_table_name;



    }
}
$number = mysqli_query($conn, "SELECT location FROM $get_table_name ");

while ($row = mysqli_fetch_array($number, MYSQLI_NUM)) {

    $location_name = $row['0'];
?>

            <option value="">   <?php echo $location_name ?>   </option>

<?php } ?>
            </select>


            <div class="input-group">
				<button name="submit2" class="code_button">   Search Locations  </button>
			</div>


    </form>
    </div>


            
        </div>
 
        <hr/>
        <div id="evoCalendar"></div>
    </main>
 
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-vk5WoKIaW/vJyUAd9n/wmopsmNhiy+L2Z+SBxGYnUkunIxVxAv/UtMOhba/xskxh" crossorigin="anonymous"></script>
    <script src="evo-calendar.js"></script>
    <script>
        $('#evoCalendar').evoCalendar({
            todayHighlight: true,
            sidebarToggler: false,
            eventListToggler: true,
            canAddEvent: false,
            calendarEvents: [

    

                <?php
$chosen_location = $_SESSION['view_location'];


 

$number_new_one = mysqli_query($conn, "SELECT name, location, date, time_start, time_end FROM $get_table_name");

while ($row = mysqli_fetch_array($number_new_one, MYSQLI_NUM)) {

    $name = $row['0'];
    $db_location = $row['1'];
    $date = $row['2'];
    $time_start = $row['3'];
    $time_end = $row['4'];
    

$input = $db_location. " - ". $name. " - ". $time_start. " to ". $time_end;

?>

{ name: "<?php echo $input ?>", date: "<?php echo $date ?>", type: "holiday", everyYear: false },

<?php

}

?>

                

            ],
            onSelectDate: function() {
                // console.log('onSelectDate!')
            },
            onAddEvent: function() {
                console.log('onAddEvent!')
            }
        });
        // $("#evoCalendar").evoCalendar('addCalendarEvent', [...]);
    </script>
    <script type="text/javascript">
 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);
 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

  <?php

}

?>

 
</script>
<script>
try {
  fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", { method: 'HEAD', mode: 'no-cors' })).then(function(response) {
    return true;
  }).catch(function(e) {
    var carbonScript = document.createElement("script");
    carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
    carbonScript.id = "_carbonads_js";
    document.getElementById("carbon-block").appendChild(carbonScript);
  });
} catch (error) {
  console.log(error);
}
</script>
</body>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</html>

