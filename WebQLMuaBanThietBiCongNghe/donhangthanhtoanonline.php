<?php
include 'inc/header.php';
include 'inc/slider.php';
?>

<?php
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
//     $cartId = $_POST['cartId'];
//     $quantity = $_POST['quantity'];
//     $stock = $_POST['stock'];
//     $update_quantity_cart = $ct->update_quantity_cart($stock,$quantity, $cartId);
//     if ($quantity <= 0) {
//         $delcart = $ct->del_product_cart($cartId);
//     }
// }
// if (isset($_GET['cartid'])) {
//     $cartid = $_GET['cartid'];
//     $delcart = $ct->del_product_cart($cartid);
// }
?>


<?php
    if (isset($_GET['orderType']) && $_GET['orderType'] == 'momo_wallet' && isset($_GET['message']) && $_GET['message'] == 'Successful.'){
        $user_Id = Session::get('userId');
        $insertOrder = $ct->insertOrder($user_Id, 'momo_wallet');
        echo "<script type='text/javascript'>window.location.href = 'success.php'</script>";
        $delCart = $ct->del_all_data_cart();
    }else if(isset($_GET['message']) && $_GET['message'] == 'Transaction denied by user.'){
        echo "<script type='text/javascript'>window.location.href = 'fail.php'</script>";
    }

    if (isset($_GET['vnp_OrderInfo']) && $_GET['vnp_OrderInfo'] == 'vnpay' && isset($_GET['vnp_TransactionStatus']) && $_GET['vnp_TransactionStatus'] == '00'){
        $user_Id = Session::get('userId');
        $insertOrder = $ct->insertOrder($user_Id, 'vnpay');
        echo "<script type='text/javascript'>window.location.href = 'success.php'</script>";
        $delCart = $ct->del_all_data_cart();
    }else if (isset($_GET['vnp_TransactionStatus']) && $_GET['vnp_TransactionStatus'] != '00'){
        echo "<script type='text/javascript'>window.location.href = 'fail.php'</script>";
    }
?>

<?php
    $login_check = Session::get('user');  
    if($login_check==false){
         echo "<script type='text/javascript'>window.location.href = 'login.php'</script>";
     }
?>


<div class="main">
    <div class="content">
        <div class="cartoption">
            <div class="cartpage">

                <h2>Cổng thanh toán online</h2>

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
                        <th width="20%">Product Name</th>
                        <!-- <th width="20%">Product Stock</th> -->
                        <th width="10%">Image</th>
                        <th width="15%">Price</th>
                        <th width="25%">Quantity</th>
                        <th width="20%">Total Price</th>
                        <!-- <th width="10%">Action</th> -->
                    </tr>   
                    <?php
                    $get_pro_cart = $ct->get_product_cart_checkout(); // Corrected the method call

                    $subtotal = 0;
                    if ($get_pro_cart) {
                        $qty = 0;
                        while ($result = $get_pro_cart->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $result['productName'] ?></td>
                                <td><img src="admin/uploads/<?php echo $result['image'] ?>" alt="" /></td>
                                <td><?php echo $fm->format_currency($result['price']) . ' VND' ?></td>
                                <td><?php echo $result['quantity'] ?></td>
                      
                                <td><?php $total = $result['price'] * $result['quantity'];
                                    echo $fm->format_currency($total) . ' VND';
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
                    <table style="float:right;text-align:left;" width="40%">
                        <tr>
                            <th>Sub Total : </th>
                            <td><?php
                                echo  $fm->format_currency($subtotal) . ' VND';
                                Session::set("sum", $subtotal);
                                Session::set('qty', $qty);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>VAT : </th>
                            <td>10%</td>
                        </tr>
                        <tr>
                            <th>Grand Total :</th>
                            <td><?php
                                $vat = $subtotal * 0.1;
                                $gtotal = $subtotal + $vat;
                                echo  $fm->format_currency($gtotal) . ' VND';
                                ?> </td>
                        </tr>
                    </table>
                <?php
                } else {
                    echo 'Your cart is Empty! Please Shopping Now';
                }
                ?>
            </div>
            <style type="text/css">
                a.btn-thanhtoan {
                    display: block;
                    width: 33%;
                    margin: 6px auto;
                }
            </style>
            <?php
            $check_cart = $ct->check_cart();
            if (Session::get('user_id') == false && $check_cart) {
            ?>

                <form action="congthanhtoan_vnpay.php" method="post">
                    <input type="hidden" name="total_congthanhtoan" value="<?php echo $gtotal ?>">
                    <button class="btn btn-success" name="redirect" id="redirect">Thanh toán VNPAY</button>
                </form>
                <p></p>
                <form action="congthanhtoan_momo.php" method="post">
                    <input type="hidden" name="total_congthanhtoan" value="<?php echo $gtotal ?>">
                    <button class="btn btn-danger" name="captureWallet" >Thanh toán QR MOMO</button>
                </form>
                <p></p>
                <!-- <form action="congthanhtoan_momo.php" method="post">
                    <input type="hidden" name="total_congthanhtoan" value="<?php echo $gtotal ?>">
                    <button class="btn btn-danger" name="payWithATM">Thanh toán MOMO ATM</button>
                </form> -->
                

            <?php
            } else {
            ?>
                <a href="cart.php" class="btn btn-primary btn-thanhtoan">Quay về giỏ hàng</a>
            <?php
            }
            ?>
            <style type="text/css">
                a.muahang {
                    float: right;
                    padding: 10px 20px;
                    border: 1px solid #ddd;
                    background: #414045;
                    color: #fff;
                    cursor: pointer;
                }
            </style>
            <div class="clear"></div>
        </div>
    </div>

    <?php
    include 'inc/footer.php';
    ?>