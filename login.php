<?php include('server.php') ?>

<!DOCTYPE html>
<html>
<head>
	<title>Complaint Management System</title>
</head>
<body>
	<div class="container">

		<div class="header">
			<h2>Log In</h2>
		</div>
		
		<form action="login.php" method="post">
			<div>
				<label for="email"> Email: </label>
				<input type="email" name="email" required>
			</div>

			<div>
				<label for="password"> Password: </label>
				<input type="password" name="password" required>
			</div>

			<button type="submit" name="login_user"><b>Log in</b> </button>
		</form>
	</div>

</body>
</html>