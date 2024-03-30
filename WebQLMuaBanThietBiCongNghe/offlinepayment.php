<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
    if (isset($_GET['orderid']) && $_GET['orderid'] == 'order' && isset($_GET['paymentMethod']) && $_GET['paymentMethod'] == 'offline') {
        $user_Id = Session::get('userId');
        $insertOrder = $ct->insertOrder($user_Id, 'offline');
        $delCart = $ct->del_all_data_cart();
        echo "<script type='text/javascript'>window.location.href = 'success.php'</script>";
    }
?>

<?php
$login_check = Session::get('user');
if ($login_check == false) {
    header('Location:login.php');
}
?>

<style>
    .box_left {
        border: 1px solid #666;
        padding: 4px;
    }

    .box_right {
        border: 1px solid #666;
        padding: 4px;
    }
    a.a_order{
        background: red;
        padding: 7px 20px;
        color: #fff;
        font-size: 21px;
    }
</style>
<form action="" method="post">

<div class="main">
    <div class="content">
        <div class="section group">
            <div class="heading">
                <h3>Offline Payment</h3>
            </div>
            <div class="clear"></div>
            <div class="box_left">
                <div class="cartpage">
                    <?php
                    if (isset($update_quantity_cart)) {
                        echo $update_quantity_cart;
                    }
                    ?>
                    <?php
                    if (isset($delcart)) {
                        echo $delcart;
                    }
                    ?>
                    <table class="tblone">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Product Name</th>
                            <th width="15%">Price</th>
                            <th width="25%">Quantity</th>
                            <th width="20%">Total Price</th>
                        </tr>
                        <?php
                        $get_pro_cart = $ct->get_product_cart_checkout(); // Corrected the method call

                        $subtotal = 0;
                        if ($get_pro_cart) {
                            $qty = 0;
                            $i = 0;
                            while ($result = $get_pro_cart->fetch_assoc()) {
                                $i++;
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $result['productName'] ?></td>
                                    <td><?php echo  $fm->format_currency($result['price']) . ' VND' ?></td>
                                    <td>
                                        <?php echo $result['quantity'] ?>
                                    </td>
                                    <td><?php $total = $result['price'] * $result['quantity'];
                                        echo  $fm->format_currency($total) . ' VND';
                                        ?></td>
                                </tr>
                        <?php
                                $subtotal += $total;
                                $qty = $qty + $result['quantity'];
                            }
                        }
                        ?>

                    </table>
                    <?php
                    $check_cart = $ct->check_cart();
                    if ($check_cart) {

                    ?>
                        <table style="float:right;text-align:left;margin:5px;" width="40%">
                            <tr>
                                <th>Sub Total : </th>
                                <td><?php
                                    echo $subtotal . ' VND';
                                    Session::set("sum", $subtotal);
                                    Session::set('qty', $qty);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>VAT : </th>
                                <td>10% (<?php echo  $vat = $subtotal * 0.1; ?>)</td>
                            </tr>
                            <tr>
                                <th>Grand Total :</th>
                                <td><?php
                                    $vat = $subtotal * 0.1;
                                    $gtotal = $subtotal + $vat;
                                    echo $gtotal . ' VND';
                                    ?> </td>
                            </tr>
                        </table>
                    <?php
                    } else {
                        echo 'Your cart is Empty! Please Shopping Now';
                    }
                    ?>
                </div>
            </div>
            <div class="box_right">
                <table class="tblone">
                    <?php
                    $id = Session::get('userId');
                    $get_users = $user->show_users($id);
                    if ($get_users) {
                        while ($result = $get_users->fetch_assoc()) {
                    ?>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td><?php echo $result['fullname'] ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><?php echo $result['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Date of birth</td>
                                <td>:</td>
                                <td><?php echo $result['dob'] ?></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td><?php echo $result['address'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"><a href="editprofile.php">Update Profile</a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>  
    <center>
        <a href="?orderid=order&paymentMethod=offline" class="a_order">Order now</a><br><br>
    </center>
</div>
</form>
<?php
include 'inc/footer.php';
?>