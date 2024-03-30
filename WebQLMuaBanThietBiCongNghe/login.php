<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
        $login_check = Session::get('user');  
        if($login_check){
          header('Location:order.php');
        }
?>

<?php
// include 'classes/user.php';
// $user = new user();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $login_check = $user->login($email, $password);
}
?>

<div class="main">
	<div class="content">
		<div class="container-single">
			<div class="featuredProducts">
				<h1>Đăng nhập</h1>
			</div>
			<div class="noname">
				<form action="login.php" method="post" class="form-login">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" placeholder="Email..." required>
				
					<label for="password">Mật khẩu</label>
					
					<input type="password" id="password" name="password" placeholder="Mật khẩu..." required>
					<p style="color: red;"><?= !empty($login_check) ? $login_check : '' ?></p>

					<input type="submit" value="Đăng nhập">
				</form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>

<?php
include 'inc/footer.php';
?>