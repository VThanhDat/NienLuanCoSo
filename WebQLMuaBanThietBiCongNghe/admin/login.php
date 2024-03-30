<?php
	include '../classes/adminlogin.php';
?>
<?php
	$class = new adminlogin();
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$adminEmail = $_POST['adminEmail'];
		$password = md5($_POST['password']);

		$login_check = $class->login_admin($adminEmail,$password);
	}
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
		<form action="login.php" method="post">
			<h1>Admin Login</h1>
			<span style="color: red; font-size:20px;"><?php
				if(isset($login_check)){
					echo $login_check;
				}
			?>
			</span>
			<div>
				<input type="text" placeholder="Username" required="" name="adminEmail"/>
			</div>
			<div>
				<input type="password" placeholder="Password" required="" name="password"/>
			</div>
			<div>
				<input type="submit" value="Log in" />
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="#">Store DB Now</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>