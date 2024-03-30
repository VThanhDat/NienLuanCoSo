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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $updateUser = $user->update_user($_POST, $id);
}
?>

<div class="main">
    <div class="content">
        <div class="section group">
            <div class="content_top">
                <div class="heading">
                    <h3>Update Profile Customers</h3>
                </div>
                <div class="clear"></div>
            </div>
            <form action="" method="post">
                <table class="tblone">
                    <tr>
                        <td colspan="2">
                            <?php
                            if (isset($updateUser)) {
                                echo '<td colspan ="3">'.$updateUser.'</td>';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    $id = Session::get('userId');
                    $get_users = $user->show_users($id);
                    if ($get_users) {
                        while ($result = $get_users->fetch_assoc()) {
                    ?>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td><input type="text" name="name" value="<?php echo $result['fullname'] ?>"></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><input type="email" name="email" value="<?php echo $result['email'] ?>"></td>
                            </tr>
                            <tr>
                                <td>Date of birth</td>
                                <td>:</td>
                                <td><input type="date" name="dob" value="<?php echo $result['dob'] ?>"></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td><input type="textarea" name="address" value="<?php echo $result['address'] ?>"></td>

                            </tr>
                            <tr>
                                <td colspan="3"><input type="submit" name="save" value="Save"></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </form>
        </div>
    </div>
</div>


<?php
include 'inc/footer.php';
?>