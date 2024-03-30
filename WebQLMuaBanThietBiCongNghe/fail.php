<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
        $login_check = Session::get('user');  
        if($login_check==false){
          header('Location:login.php');
        }
    ?>
<style>
    h2.fail_order{
        text-align: center;
        color: red;
    }
    p.fail_note{
        text-align: center;
        padding: 8px;
        font-size: 17px;
    }

</style>

<div class="main">
    <div class="content">
        <div class="section group" style="text-align: center;">
            <h2 class="fail_order">Payment Fail</h2>
            <p> Bạn đã thanh toán thất bại</p>
            <p class="fail_note">Vui lòng nhấn vô đây để tiếp tục thanh toán <a href="cart.php">Click Here</a></p>
        </div>
    </div>  
</div>

<?php
include 'inc/footer.php';
?>