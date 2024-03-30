<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../classes/user.php');
// include_once ($filepath.'/../helpers/format.php');
?>

<?php
$user = new user();
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $dob = $_POST['dob'];
        $role = $_POST['role'];
        $address = $_POST['address'];
    
        $insertUser = $user->insert_User($name, $email, $dob, $address, $password, $role);
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Cập nhật thông tin người dùng</h2>
        <div class="block">
            <?php
            if (isset($insertUser)) {
                echo $insertUser;
            }
            ?>
                    <form action="" method="post">
                        <table class="form">

                            <tr>
                                <td>
                                    <label>Email</label>
                                </td>
                                <td>
                                    <input type="text" name="email" value="" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Password</label>
                                </td>
                                <td>
                                    <input type="password" name="password" value="" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Full name</label>
                                </td>
                                <td>
                                    <input type="text" name="name" value="" class="medium" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>Date of birth</label>
                                </td>
                                <td>
                                    <input type="date" name="dob" value="" class="medium" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>Role</label>
                                </td>
                                <td>
                                    <select id="select" name="role">
                                        <option value="1">Admin</option>
                                        <option value="2">Normal</option>
                                        <option value="3">Writer</option>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <label>Address</label>
                                </td>
                                <td>
                                    <input type="text" name="address" value="" class="medium" />
                                </td>
                            </tr>

    
                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" name="submit" value="Thêm người dùng" />
                                </td>
                            </tr>
                        </table>
                    </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        setupLeftMenu();
        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>

<?php include 'inc/footer.php'; ?>