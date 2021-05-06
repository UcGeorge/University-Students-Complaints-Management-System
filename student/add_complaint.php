<!DOCTYPE html>
<html lang="en">

<?php
// Start the session
session_start();
// Get useful session variables
$user = $_SESSION['dashboard'];
$auth = $_SESSION["auth"];
// Extract user's data from the dashboard data
$user_data = $user['user'];
$id = rand(10000, 99999);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = '#' . $id;
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $category = $_POST['category'];
    $author = $user_data['mat_no'];
    $tags = '';

    foreach ($_SESSION['course_data']['tags'] as $tag) {
        // echo $tag;
        if (isset($_POST[$tag])) {
            // echo 'isset';
            $tags .= $tag . ',';
        }
    }

    $the_tags = '[' . chop($tags, ',') . ']';
    echo $the_tags;

    // echo $id, $title, $desc, $category, $author, $the_tags;
    // Set all request parameters
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost:8080/University-Students-Complaints-Management-System/api/api/add_complaint.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('id' => $id, 'title' => $title, 'desc' => $desc, 'category' => $category, 'author' => $author, 'tags' => $the_tags),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic MTcwODA1NTEzOlRlc3RAMTIz',
        ),
    ));

    $response = curl_exec($curl);
    // Close the connection
    curl_close($curl);

    // JSON decode the response
    $data = json_decode($response, true);
    echo ($data['Error']);
}





function show_tags()
{
    foreach ($_SESSION['course_data']['tags'] as $tag) {
        echo '<input type="checkbox" name="' . $tag . '" value="' . $tag . '">
                            <label for="' . $tag . '"> ' . $tag . '</label><br>';
    }
}


?>

<head>

    <meta charset="utf-8">
    <title>UNILAG-CMS | Add Complaints</title>

    <link rel="stylesheet" type="text/css" href="general/gen.css">
    <link rel="stylesheet" type="text/css" href="coursecomplaint.css">

    <script defer src="../fontawesome-free-5.15.2-web/js/all.js"></script>

</head>

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
                        <a href="studentdash.html">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard

                        </a>
                        <hr>

                        <a href="complaintsview.html">
                            <i class="fas fa-inbox"></i>
                            My Complaints

                        </a>

                        <a href="">
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

        <div class="mbody">


            <!-- A little direction nav -->

            <div class="littlenav">
                <a href="">Home</a><span class="fas fa-chevron-right"> </span>
                <a href="complaintsview.html">My Complaints</a><span class="fas fa-chevron-right"> </span>

                <a href="newcomp.html">New Complaint</a>

            </div>



            <!---------- back div ---------->
            <div class="backdiv">
                <span class="fas fa-chevron-left"> </span><a href="">back</a>
            </div>



            <!--------- SEC 1  ---------->

            <div class="secomp1">
                <p><b>New Complaints</b> </p>
            </div>


            <form method="post">
                <!--------- SEC 2  ---------->

                <div class="secomp2">
                    <div>
                        <label><b>Title*</b> </label><br>
                        <input class="title" type="text" name="title">
                    </div>

                    <div>
                        <label><b>Category*</b> </label><br>
                        <select name="category">
                            <option value="<?php echo $_GET['category'] ?>"><?php echo $_GET['category'] ?></option>
                        </select>
                    </div>


                </div>



                <!--------- SEC 3  ---------->

                <div class="secomp3">

                    <!----- sec 3.1 ----->
                    <div class="secomp31">
                        <div>
                            <label><b>Description*</b></label><br>
                            <textarea name="desc">

				</textarea>

                            <input class="comntbtn" type="submit" name="add" value="<?php echo "Open #$id" ?>" style="cursor: pointer;
    background-color: #8E1300;
    color: white;
    border: none;
    padding: 4px 10px;
    border-radius: 6px;">
                        </div>



                    </div>

                    <!----- sec 3.2 ----->
                    <div class="secomp32">
                        <!-- Tags -->
                        <div class="catgrydiv" style="margin-right: 100px;margin-top: 80px;">
                            <h4>Tags</h4><br>
                            <?php show_tags() ?>
                        </div>

                    </div>

                </div>


            </form>










        </div>




        <!------- footer -------->
        <div class="foot">
            <span>© 2021. All Rights Reserved | Design by <span class="footspan">CSC405 - PROJECT GROUP7</span> </span>
        </div>

    </div>

    <script type="text/javascript" src="general/gen.js"></script>

</body>

</html>