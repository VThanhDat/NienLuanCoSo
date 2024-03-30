<?php
include 'inc/header.php';
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email already exists
    if ($user->isEmailExists($email)) {
        $result = "<span class='error'>Email already exists.</span>";
    } else {
        // Email does not exist, proceed with registration
        $result = $user->insert($_POST);
        if ($result == true) {
            $userId = $user->getLastUserId(); 
            header("Location:./confirm.php?id=".$userId['id']."");
        }
    }
}
?>

<div class="main">
    <div class="content">
        <div class="featuredProducts">
            <h1>Đăng ký</h1>
        </div>
        <div class="container-single">
            <div class="noname">
                <form action="register.php" method="post" class="form-login">
                    <label for="fullName">Họ tên</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Họ tên..." required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email..." required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">

                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Mật khẩu..." required>

                    <label for="repassword">Nhập lại mật khẩu</label>
                    <input type="password" id="repassword" name="repassword" required placeholder="Nhập lại mật khẩu..." oninput="check(this)">

                    <label for="address">Địa chỉ</label>
                    <textarea name="address" id="address" cols="30" rows="5" required></textarea>

                    <label for="dob">Ngày sinh</label>
                    <input type="date" name="dob" id="dob" required>

                    <input type="submit" value="Đăng ký" name="submit">
                </form>
            </div>
        </div>
        <div class="clear"></div>
        <p style="text-align: center;" class="error"><?= !empty($result) ? $result : '' ?></p>
    </div>
</div>
<script language='javascript' type='text/javascript'>
    function check(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Password Must be Matching.');
        }else{
            input.setCustomValidity('');
        }
    }
</script>

<?php
    include 'inc/footer.php';
?>