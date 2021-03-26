<?php
session_start();

$email="";
$errors = array();

$db = mysqli_connect('localhost','root','','cms') or die('could not connect to database');

$email = mysqli_real_escape_string($db, $_POST['email']);

if(empty($username)) {
	array_push($errors, "")
}


//LOGIN
if(isset($_POST['login_user'])) {
	$username =mysqli_real_escape_string($db, _POST['email']);
	$password =mysqli_real_escape_string($db, _POST['password']);

	if(empty($email)) {
		array_push($errors, "Email is requied");
	}
	if(empty($password)) {
		array_push($errors, "Password is requied");
	}

	if(count($errors == 0)){
		$query = "SLECT * FROM user WHERE email='$email' AND password='$password'";
		$results = mysqli_query($db, $query);

		if(mysqli_num_results($results)) {
			$_SESSION['email'] = $email;
			$_SESSION['success'] = "Logged in successfully";
			header('location:StudentPage.php');
		} else {
			array_push($errors, "Wrong email/password. Please try again");
		}
	}
}




/>