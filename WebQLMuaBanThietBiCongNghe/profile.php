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

<div class="main">
    <div class="content">
        <div class="section group">
            <div class="content_top">
                <div class="heading">
                    <h3>Thông tin tài khoản</h3>
                </div>
                <div class="clear"></div>
            </div>

            <table class="tblone">
                <?php 
                    $id = Session::get('userId');
                    $get_users = $user->show_users($id);
                    if($get_users){
                        while($result = $get_users->fetch_assoc()){
                ?>
                <tr>
                    <td>Họ và tên</td>
                    <td>:</td>
                    <td><?php echo $result['fullname']?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><?php echo $result['email']?></td>
                </tr>
                <tr>
                    <td>Ngày sinh</td>
                    <td>:</td>
                    <td><?php echo $result['dob']?></td>
                </tr>
                <tr>
                    <td>Địa chỉ</td>
                    <td>:</td>
                    <td><?php echo $result['address']?></td>
                </tr>
                <tr>
                    <td>Mật khẩu</td>
                    <td>:</td>
                    <td><input type="password" name="password" value="<?php echo $result['password'] ?>"></td>
                    </tr>
                <tr>
                    <td colspan="2"><a href="editprofile.php">Cập nhật thông tin cá nhân</a></td>
                    <td colspan="2"><a href="editpassword.php">Đổi mật khẩu</a></td>
                </tr>
                <?php 
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>


<?php
include 'inc/footer.php';
?>