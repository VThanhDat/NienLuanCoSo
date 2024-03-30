<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../classes/user.php');
// include_once ($filepath.'/../helpers/format.php');
?>

<?php
$user = new user();

if (!isset($_GET['usereditid']) || $_GET['usereditid'] == NULL) {
    echo "<script>window.location = 'memberlist.php'</script>";
} else {
    $rolecurrent = $_GET['rolecurrent'];
    $id = $_GET['usereditid'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $updateUser = $user->update_userID($_POST, $id, $rolecurrent);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Cập nhật thông tin người dùng</h2>
        <div class="block">
            <?php
            if (isset($updateUser)) {
                echo $updateUser;
            }
            ?>
            <?php
            $get_userId = $user->getuserbyId($id);
            if ($get_userId) {
                while ($result = $get_userId->fetch_assoc()) {
            ?>
                    <form action="" method="post">
                        <table class="form">

                            <tr>
                                <td>
                                    <label>Email</label>
                                </td>
                                <td>
                                    <input type="text" name="email" value="<?php echo $result['email'] ?>" readonly class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Password</label>
                                </td>
                                <td>
                                    <input type="password" name="password" value="<?php echo $result['password'] ?>" readonly class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Full name</label>
                                </td>
                                <td>
                                    <input type="text" name="name" value="<?php echo $result['fullname'] ?>" class="medium" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>Date of birth</label>
                                </td>
                                <td>
                                    <input type="date" name="dob" value="<?php echo $result['dob'] ?>" class="medium" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>Role</label>
                                </td>
                                <td>
                                    <select id="select" name="role">
                                        <?php
                                        if ($result['role_id'] == 1) {
                                        ?>
                                            <option selected value="1">Admin</option>
                                            <option value="2">Normal</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="1">Admin</option>
                                            <option selected value="2">Normal</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <label>Address</label>
                                </td>
                                <td>
                                    <input type="text" name="address" value="<?php echo $result['address'] ?>" class="medium" />
                                </td>
                            </tr>

    
                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" name="submit" value="Update" />
                                </td>
                            </tr>
                        </table>
                    </form>
            <?php

                }
            }
            ?>
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