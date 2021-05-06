<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>UNILAG-CMS | Open</title>

    <link rel="stylesheet" type="text/css" href="general/gen.css">
    <link rel="stylesheet" type="text/css" href="openwrite.css">

    <script defer src="../fontawesome-free-5.15.2-web/js/all.js"></script>

</head>

<?php
// Start the session
session_start();
// Get useful session variables
$user = $_SESSION['dashboard'];
$auth = $_SESSION["auth"];

// Extract user's data from the dashboard data
$user_data = $user['user'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // echo 'doing post';
    $comment_text = $_POST['text'];

    // Using cURL as the HTTP request library
    $curl2 = curl_init();

    curl_setopt_array($curl2, array(
        CURLOPT_URL => "http://localhost:8080/University-Students-Complaints-Management-System/api/api/comment.php",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'id' => $_GET['id'],
            'text' => $comment_text,
            'student' => $user_data['mat_no']
        ),
        CURLOPT_HTTPHEADER => array(
            $auth
        ),
    ));

    $response = curl_exec($curl2);
    // Close the connection
    curl_close($curl2);
} else {
    // echo 'skipping post';
}

// Using cURL as the HTTP request library
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://localhost:8080/University-Students-Complaints-Management-System/api/api/complaint.php?id={$_GET['id']}",
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
$complaint = json_decode($response, true);
// echo isset($complaint) ? '; complaint is set' : '; complaint is not set';
$the_complaint = $complaint['complaint'];
$comments = $complaint['comments'];


function show_tags()
{
    global $the_complaint;

    foreach ($the_complaint['tags'] as $tag) {
        echo '<span class="bstags"><b>' . $tag . '</b></span>';
    }
}


function show_comments()
{
    global $comments, $user_data;

    foreach ($comments as $comment) {
        if (isset($comment["student"])) {
            $author = $comment["student"];
        } else {
            $author = $comment["lecturer"] . ' - LECTURER';
        }

        if ($comment['student'] == $user_data['mat_no']) {
            echo '
        <div class="comwrtn2">

                        <!-- comment box -->
                        <div class="combox2">

                            <!--  comment head -->
                            <div class="combhead2">

                                <span><b>You</b></span>
                                <span>commented</span>
                                <span>' . $comment['dateadded'] . '</span>

                            </div>

                            <!--  comment body -->
                            <div class="combbody2">
                                <p>
                                    ' . $comment['text'] . '
                                </p>
                            </div>

                        </div>

                        <!-- pic -->
                        <div class="compic2">
                            <img src="images/usericon.png">

                        </div>


                    </div>
        ';
        } else {
            echo '
            <div class="comwrtn">
					<i class="triangle-left"></i>

					<!-- pic -->
					<div class="compic">
						<img src="images/usericon.png">
						
					</div>

					<!-- comment box -->
					<div class="combox">

						<!--  comment head -->
						<div class="combhead">

							<span><b>' . $author . '</b></span>
							<span>commented</span>
							<span>' . $comment["dateadded"] . '</span>
							
						</div>

						<!--  comment body -->
						<div class="combbody">
										<p>
								' . $comment["text"] . '

							</p>
						</div>
						
					</div>
					
				</div>
        ';
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
            <a href="studentDash.php" class="logo">
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

            <!-- My Courses nav -->
            <a href="studentDash.php" class="coursesnav" onmouseover="mOver()" onmouseout="mOut()">
                <span>My Courses </span>

            </a>


            <!-- search button -->

            <div class="searchbtn">
                <div class="combtn">

                    <input class="comntbtn" type="submit" name="subscribe" value="subscribe">

                </div>

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

        <div class="mbody" style="padding-bottom: 0px; padding-left: 15px; padding-top: 15px; padding-right: 15px;">


            <!-- A little direction nav -->

            <div class="littlenav">
                <a href="studentDash.php">Home</a><span class="fas fa-chevron-right"> </span>
                <a href="studentDash.php">My Course</a><span class="fas fa-chevron-right"> </span>
                <a href=""><?php echo $the_complaint['category'] ?></a><span class="fas fa-chevron-right"> </span>
                <a href=""><?php echo $the_complaint['id'] ?></a>

            </div>



            <!---------- back div ---------->
            <div class="backdiv">
                <span class="fas fa-chevron-left"> </span><a href="studentDash.php">back</a>
            </div>





            <!------------ TOP  ------------>
            <div class="top">

                <!-- sec1 -->
                <div class="tsecone">
                    <h3><?php echo $complaint['complaint']['title'] ?></h3>
                    <span> - <?php echo $complaint['complaint']['id'] ?></span>

                </div>

                <!-- sec2 -->
                <div class="tsectwo">
                    <span class="<?php echo $complaint['complaint']['status'] == 'open' ? 'topen' : 'tclose' ?>"><b><?php echo $complaint['complaint']['status'] == 'open' ? 'Open' : 'Close' ?></b></span>
                    <span><b><?php echo $complaint['complaint']['author'] ?></b></span>
                    <span>opened this complaint</span>
                    <span><?php echo $complaint['complaint']['dateadded'] ?></span><i class="fas fa-circle"></i>
                    <span><?php echo count(($comments)) ?></span>
                    <span>comment(s)</span>

                </div>

                <!-- sec3 -->
                <div class="tsecthree">

                    <p>
                        <?php echo $complaint['complaint']['description'] ?>

                    </p>

                </div>

            </div>





            <!------------ BOTTOM  ------------>
            <div class="bottom">

                <hr>



                <!-------- sec1 ------->
                <div class="bsecone">

                    <?php show_comments() ?>


                    <!---- comment to write ----->
                    <div class="com2wrt">


                        <form method="post">
                            <textarea name="text">

						    </textarea>

                            <!-- comment button -->
                            <div class="combtn">

                                <input class="comntbtn" type="submit" name="comment" value="comment">

                            </div>
                        </form>



                    </div>

                </div>





                <!-------- sec2 -------->
                <div class="bsectags">

                    <!-- tags -->

                    <h4>Tags</h4>
                    <?php show_tags() ?>

                    <!---- subscribers ---->
                    <h4><span><?php echo $the_complaint['subscribers'] ?></span> Subscribers</h4>

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