<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
    if (isset($_GET['orderid']) && $_GET['orderid'] == 'order') {
        $user_Id = Session::get('userId');
        $insertOrder = $ct->insertOrder($user_Id,'');
        $delCart = $ct->del_all_data_cart();
        header('Location:success.php');
    }
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
//     $quantity = $_POST['quantity'];
//     $AddtoCart = $ct->add_to_cart($quantity, $id);
// }
?>

<?php
        $login_check = Session::get('user');  
        if($login_check==false){
          header('Location:login.php');
        }
    ?>
<style>
    h2.success_order{
        text-align: center;
        color: red;
    }
    p.success_note{
        text-align: center;
        padding: 8px;
        font-size: 17px;
    }
</style>
<form action="" method="post">

<div class="main">
    <div class="content">
        <div class="section group">
            <h2 class="success_order">Success Order</h2>
            <?php
                $user_Id = Session::get('userId');
                $get_amount = $ct->getAmountPrice($user_Id); 
                if($get_amount){
                    $amount = 0;
                    while($result = $get_amount->fetch_assoc()){
                        $price = $result['price'];
                        $quantity = $result['quantity'];
                        $amount += $price*$quantity;
                    }
                }
            ?>
            <p class="success_note">Total Price You Have Bought From My Website : <?php 
                $vat = $amount * 0.1; 
                $total = $vat + $amount;
                echo $fm->format_currency($total). ' VND';
            ?>
            </p>
            <p class="success_note">We will contact as soon as possible. Please see your order details here <a href="history_order.php">Click Here</a></p>
        </div>
    </div>  
</div>
</form>
<?php
include 'inc/footer.php';
?>