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

function show_tags()
{
    global $course_data;

    foreach ($course_data['tags'] as $tag) {
        echo '<span class="sstag"><b>' . $tag . '</b></span>';
    }
}

function ccircle($status)
{
    return $status == "open" ? "ocircle" : "bcircle";
}

$sorted_complaint = array();

if (isset($_GET['status'])) {
    $sorted_complaint = array();
    $status = $_GET['status'];
    global $course_data;
    foreach ($course_data['complaints'] as $complaint) {
        if ($complaint['status'] == $status) {
            array_push($sorted_complaint, $complaint);
        }
    }
    if ($status == 'all') {
        $sorted_complaint = $course_data['complaints'];
    }
} else {
    $sorted_complaint = $course_data['complaints'];
}

function show_complaints()
{
    global $sorted_complaint;

    foreach ($sorted_complaint as $complaint) {
        $tags = $complaint['tags'];
        $tags_string = '';
        foreach ($tags as $tag) {
            $tags_string .= "<span class='stag'><b>$tag</b></span>";
        }

        echo '
		<a href="complaintview.php?id=' . base64_encode($complaint['id']) . '" style="text-decoration: none;">
		<div class="boxgan">
			<div class="secone">
				<div class="shead">
					<div class="' . ccircle($complaint["status"]) . '"></div>
					<span class="secomhead"><b>' . $complaint['title'] . '</b></span>
				</div>
				<div class="problem">
					<span class="secproblmno">' . $complaint['subscribers']  . ' </span>
					<span>students have this problem</span>
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
					<span class="seccompid" style="color: darkblue;">' . $complaint['id'] . '</span>
					<span class="">opened</span>
					<span class="seccomptime">' . $complaint['dateadded'] . '</span>
					<span style="color: darkblue;">by</span>
					<span class="seccomperson" style="color: darkblue;">' . $complaint['author'] . '</span>

				</div>
			</div>
		</div>
		</a>
		';
    }
}

function status_circle($is_stat)
{
    if (isset($_GET['status'])) {
        if ($is_stat == $_GET['status']) {
            echo '<div class=" currentbcirc"></div>';
        } else {
            echo '<span class="blankcircles "></span>';
        }
    } else {
        if ($is_stat == 'all') {
            echo '<div class=" currentbcirc"></div>';
        } else {
            echo '<span class="blankcircles "></span>';
        }
    }
}

?>

<body>

    <div id="body">

        <!------- top Social links ------->

        <div class="head">

            <!-- left link -->
            <div class="leftlink">
                <a href="https://unilag.edu.ng"><i class="far fa-bookmark"></i>https://unilag.edu.ng</a>
                <a href="mailto:communicationsunit@unilag.edu.ng"><i class="far fa-envelope"></i>communicationsunit@unilag.edu.ng</a>
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
            <a href="../index.php" class="logo">
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
                        <a href="dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard

                        </a>
                        <hr>

                        <a href="dashboard.php">
                            <i class="fas fa-book"></i>
                            My Courses

                        </a>
                        <hr>
                        <a href="../index.php">
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
            <a href="../index.php" class="cmsnav">
                <span>UNILAG-CMS</span>

            </a>

            <!-- My Courses nav -->
            <a href="dashboard.php" class="coursesnav" onmouseover="mOver()" onmouseout="mOut()">
                <span>My Courses </span>

            </a>



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

        <div class="mbody" style="padding-bottom: 280px; padding-left: 15px; padding-top: 15px;">






            <!-- My Inbox Page -->
            <!-- Remove this later its not supposed to be here -->

            <!-- A little direction nav -->

            <div class="littlenav">
                <a href="./dashboard.php">Home</a><span class="fas fa-chevron-right"> </span>
                <a href="./dashboard.php">My Course</a><span class="fas fa-chevron-right"> </span>
                <a href=""><?php echo $_GET['name'] ?></a>

            </div>

            <!-------------------- left side -------------------->


            <div class="leftside">

                <!---------- back div ---------->
                <div class="backdiv">
                    <span class="fas fa-chevron-left"> </span><a href="./dashboard.php">back</a>
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

                    <!-- status -->
                    <div class="catgrydiv">
                        <h4>Status</h4><br>
                        <?php status_circle('all') ?>
                        <a style="text-decoration: none; color: #a81600;" href="<?php echo "./courseview.php?course={$_GET['course']}&name={$_GET['name']}&status=all" ?>">
                            <p>All complaints</p>
                        </a><br>

                        <?php status_circle('open') ?>
                        <a style="text-decoration: none; color: #a81600;" href="<?php echo "./courseview.php?course={$_GET['course']}&name={$_GET['name']}&status=open" ?>">
                            <p>Active complaints</p>
                        </a><br>

                        <?php status_circle('close') ?>
                        <a style="text-decoration: none; color: #a81600;" href="<?php echo "./courseview.php?course={$_GET['course']}&name={$_GET['name']}&status=close" ?>">
                            <p>Closed complaints</p>
                        </a><br>

                    </div>

                    <!-- category -->
                    <div class="catgrydiv" style="visibility: hidden;">
                        <h4>Category</h4><br>
                        <?php //category_circle('all') 
                        ?>
                        <a style="text-decoration: none; color: #a81600;" href="<?php //echo "./courseview.php?course={$_GET['course']}&name={$_GET['name']}&category=all" 
                                                                                ?>">
                            <p>All complaints</p>
                        </a><br>

                        <?php //category_circle('personal') 
                        ?>
                        <a style="text-decoration: none; color: #a81600;" href="<?php //echo "./courseview.php?course={$_GET['course']}&name={$_GET['name']}&category=personal" 
                                                                                ?>">
                            <p>Personal complaints</p>
                        </a><br>

                    </div>

                    <!-- sort by -->
                    <div class="catgrydiv" style="visibility: hidden;">
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
                            <span><b><?php echo count($sorted_complaint) ?> </span>
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