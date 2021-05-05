<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<title>UNILAG-CMS | Inbox</title>

	<link rel="stylesheet" type="text/css" href="general/gen.css">

	<link rel="stylesheet" type="text/css" href="courseview.css">
	<script defer src="../fontawesome-free-5.15.2-web/js/all.js"></script>

</head>

<?php
// Start the session
session_start();
// Get useful session variables
$user = $_SESSION['dashboard'];
$auth = $_SESSION["auth"];

// Using cURL as the HTTP request library
$curl = curl_init();

// Set all request parameters
curl_setopt_array($curl, array(
	CURLOPT_URL => "http://localhost:8080/University-Students-Complaints-Management-System/api/api/course.php?course_code={$_GET['course']}",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
	// Add authorization to the header
	CURLOPT_HTTPHEADER => array(
		$auth
	),
));

// Send the request and save the response in $response
$response = curl_exec($curl);
// Close the connection
curl_close($curl);

// JSON decode the response
$course_data = json_decode($response, true);
$num_open =  $course_data['open'];
$num_closed = $course_data['closed'];

// Extract user's data from the dashboard data
$user_data = $user['user'];

// Extract user's courses data from the dashboard data
$course_data_gen = $user['courses'];

function course_menu()
{
	// Declare global variables
	global $course_data_gen;

	// Loop through all courses in the course_data
	foreach ($course_data_gen as $course) {
		// Assign useful variables needed for display
		$course_name = $course['course_title'];
		echo "<a href='courseview.php?course={$course['course_code']}'>$course_name</a>";
	}
}

function show_tags()
{
	global $course_data;

	foreach ($course_data['tags'] as $tag) {
		echo '<span class="sstag"><b>' . $tag . '</b></span>';
	}
}

function show_complaints()
{
	global $course_data;

	foreach ($course_data['complaints'] as $complaint) {
		$tags = $complaint['tags'];
		$tags_string = '';
		foreach ($tags as $tag) {
			$tags_string .= "<span class='stag'><b>$tag</b></span>";
		}
		// if ($complaint['status'] == 'open') {
		// 	continue;
		// }
		echo '
		<div class="boxgan">
							<div class="secone">
								<div class="shead">
									<div class="ocircle"></div>
									<span class="secomhead"><b>' . $complaint['title'] . '</b></span>
								</div>
								<div class="problem">
									<span class="secproblmno">1</span>
									<span>' . $complaint['subscribers']  . ' students have this problem</span>
								</div>
							</div>
							<div class="seccomp">
								<p>' . $complaint['description'] . ' </p>

							</div>
							<div class="secthree">
								<div class="sectag">
									' . $tags_string . '
								</div>
								<div class="sectime">
									<span class="seccompid">' . $complaint['id'] . '</span>
									<span class="">opened</span>
									<span class="seccomptime">' . $complaint['dateadded'] . '</span>
									<span>by</span>
									<span class="seccomperson">' . $complaint['author'] . '</span>

								</div>
							</div>
						</div>
		';
	}
}

?>

<body>

	<div id="body">

		<!------- top Social links ------->

		<div class="head">

			<!-- left link -->
			<div class="leftlink">
				<a href=""><i class="far fa-bookmark"></i>https://unilag.edu.ng</a>
				<a href=""><i class="far fa-envelope"></i>communicationsunit@unilag.edu.ng</a>
			</div>

			<!-- right socials -->
			<div class="socials">
				<a href=""><i class="fab fa-facebook"></i></a>
				<a href=""><i class="fab fa-twitter"></i></a>
				<a href=""><i class="fab fa-instagram"></i></a>
			</div>


		</div>


		<!------- profiles names and logos ------->
		<div class="profile">

			<!-- unilag logo and home button -->
			<a href="" class="logo">
				<img src="images/unilaglogo.png">
			</a>

			<!-- user icon and name -->
			<div class="iconname">

				<div class="username">
					<img src="images/notifications.svg">
					<p><b><?php echo $user_data['name']; ?></b></p>
					<i onclick="showhide();" class="triangle-downs"></i>

					<!-- user dropdown -->

					<div class="userdrop">
						<a href="studentDash.php">
							<i class="fas fa-tachometer-alt"></i>
							Dashboard

						</a>
						<hr>

						<a href="">
							<i class="fas fa-inbox"></i>
							My Inbox

						</a>

						<a href="studentDash.php">
							<i class="fas fa-book"></i>
							My Courses

						</a>
						<hr>
						<a href="">
							<i class="fas fa-sign-out-alt"></i>
							Logout

						</a>
					</div>




				</div>

				<div class="usericon">
					<img src="images/usericon.png">
				</div>

			</div>

		</div>




		<!------- top navigation ------->

		<div class="topnav">

			<!-- CMS nav -->
			<a href="" class="cmsnav">
				<span>UNILAG-CMS</span>

			</a>

			<!-- My inbox nav -->
			<a href="" class="inboxnav">
				<span>My Inbox</span>

			</a>

			<!-- My Courses nav -->
			<a href="./studentDash.php" class="coursesnav" onmouseover="mOver()" onmouseout="mOut()">
				<span>My Courses </span>

			</a>

			<!-- drop down div -->

			<div class="dropdown" onmouseover="mOver()" onmouseout="mOut()">

				<i class="triangle-up"></i>



				<?php
				course_menu();
				?>
			</div>


			<!-- search button -->
			<div class="searchbtn">

				<!-- hover search input -->
				<form>
					<div class="hoverinput" onmouseover="hOver()" onmouseout="hOut()">
						<input class="shinput" type="text" name="" placeholder="search complaints">


					</div>


					<input class="searchsub" type="submit" name="" value="" onmouseover="hOver()" onmouseout="hOut()">

				</form>


			</div>

		</div>




		<!-------- body ------->

		<div class="mbody" style="padding-bottom: 300px;">






			<!-- My Inbox Page -->
			<!-- Remove this later its not supposed to be here -->

			<!-- A little direction nav -->

			<div class="littlenav">
				<a href="./studentDash.php">Home</a><span class="fas fa-chevron-right"> </span>
				<a href="./studentDash.php">My Course</a><span class="fas fa-chevron-right"> </span>
				<a href=""><?php echo $_GET['name'] ?></a>

			</div>

			<!-------------------- left side -------------------->


			<div class="leftside">

				<!---------- back div ---------->
				<div class="backdiv">
					<span class="fas fa-chevron-left"> </span><a href="./studentDash.php">back</a>
				</div>





				<!------------ My Inbox div ------------>
				<div class="myinboxdiv">
					<p><b><?php echo $_GET['name'] ?></b> - Inbox</p>

					<div class="coursewords">
						<!-- circle -->
						<div class="ocircle"></div>
						<!-- numbers -->
						<span class="onumber"><?php echo $num_open ?></span>
						<!-- word -->
						<span>Active complaints</span>

					</div>

					<div class="coursewords">
						<!-- circle -->
						<div class="bcircle"></div>
						<!-- numbers -->
						<span class="bnumber"><?php echo $num_closed ?></span>
						<!-- word -->
						<span>Closed complaints</span>

					</div>

				</div>




				<!---------- side div ----------->
				<div class="sidediv">

					<!-- Tags -->
					<div class="catgrydiv">
						<h4>Tags</h4><br>
						<?php show_tags() ?>
					</div>

					<!-- category -->
					<div class="catgrydiv">
						<h4>Category</h4><br>
						<div class=" currentbcirc">
							<div class="blankcircle"></div>
						</div>
						<p>All categories</p><br>

						<span class="blankcircles "></span>
						<p>Personal complaints</p><br>

					</div>

					<!-- status -->
					<div class="catgrydiv">
						<h4>Status</h4><br>
						<div class=" currentbcirc"></div>
						<p>All categories</p><br>

						<div class="blankcircles "></div>
						<p>Active</p><br>

						<div class="blankcircles "></div>
						<p>Closed</p><br>

					</div>

					<!-- sort by -->
					<div class="catgrydiv">
						<h4>Sort by</h4><br>
						<div class=" currentbcirc">
							<div class="blankcircle"></div>
						</div>
						<p>Date posted(newest first)</p><br>

						<div class="blankcircles "></div>
						<p>Date posted(oldest first)</p><br>

						<div class="blankcircles "></div>
						<p>Number of Subscribers</p><br>

					</div>

				</div>






			</div>


			<!-------------------- right side -------------------->

			<div class="rightside">


				<!----------- complaint div ----------->
				<div class="complntdiv">

					<!-- complaint box -->
					<div class="complaintbox">

						<!-- box head -->
						<div class="boxhead">
							<i class="fas fa-exclamation-circle"></i>
							<span><b><?php echo count($course_data['complaints']) ?> </span>
							<span>Complaints</b></span>

						</div>


						<?php show_complaints()
						?>

					</div>


				</div>


			</div>











		</div>




		<!------- footer -------->
		<div class="foot">
			<span>© 2021. All Rights Reserved | Design by <span class="footspan">CSC405 - PROJECT GROUP7</span> </span>
		</div>

	</div>

	<script type="text/javascript" src="gen.js"></script>

</body>

</html>