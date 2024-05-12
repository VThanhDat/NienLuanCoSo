<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
$login_check = Session::get('user');
if ($login_check == false) {
    header('Location:login.php');
}
?>

<?php
$id = Session::get('userId');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doimatkhau'])) {
    $updatePassword = $user->update_password($_POST, $id);
}
?>

<div class="main">
    <div class="content">
        <div class="section group">
            <div class="content_top">
                <div class="heading">
                    <h3>Đổi mật khẩu</h3>
                </div>
                <div class="clear"></div>
            </div>
            <form action="" method="post">
                <table class="tblone">
                    <tr>
                        <td colspan="2">
                            <?php
                            if (isset($updatePassword)) {
                                echo '<td colspan ="3">' . $updatePassword . '</td>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Mật khẩu cũ</td>
                        <td>:</td>
                        <td>
                            <input type="password" name="password_cu">
                        </td>
                    </tr>
                    <tr>
                        <td>Mật khẩu mới</td>
                        <td>:</td>
                        <td><input type="password" name="password_moi"></td>
                    </tr>
                    <tr>
                        <td>Nhập lại mật khẩu mới</td>
                        <td>:</td>
                        <td><input type="password" name="password_nhaplai"></td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" name="doimatkhau" value="Lưu"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php
include 'inc/footer.php';
?>