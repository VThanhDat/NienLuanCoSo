<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
// include 'classes/user.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $user = new user();
    $result = $user->confirm($_POST['userId'], $_POST['captcha']);
    if ($result === true) {
        echo '<script type="text/javascript">alert("Xác minh tài khoản thành công!"); window.location.href = "login.php";</script>';
    }
}
?>

<div class="main">
    <div class="content">
        <div class="container-single">
            <div class="featuredProducts">
                <h1>Xác minh Email</h1>
            </div>
            <div class="container-single">
                <div class="noname">
                    <b class="error"><?= !empty($result) ? $result : '' ?></b>
                    <form action="confirm.php" method="post" class="form-login">
                        <label for="fullName">Mã xác minh</label>
                        <input type="text" id="userId" name="userId" hidden style="display: none;" value="<?= (isset($_GET['id'])) ? $_GET['id'] : $_POST['userId'] ?>">
                        <input type="text" id="captcha" name="captcha" placeholder="Mã xác minh...">
                        <input type="submit" value="Xác minh" name="submit">
                    </form>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<?php
include 'inc/footer.php';
?>