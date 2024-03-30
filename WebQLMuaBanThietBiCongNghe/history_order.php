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
    $ct = new cart();
    if(isset($_GET['danhanhang'])){
		$danhanhang = $_GET['danhanhang'];
		$danhanhang = $ct->confirm_received($danhanhang);
	}
?>

<div class="main">
    <div class="content">
        <div class="section group">
            <div class="content_top">
                <div class="heading">
                    <h3 class="payment">Lịch sử đơn đã đặt</h3>
                </div>
                <div class="clear"></div>
                <div class="wrapper_method">
                    <table class="tblone" id="example">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Order Time</th>
                                <th>Order Code</th>
                                <th>Customer Name</th>
                                <th>Action</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // $ct = new cart();
                                // $fm = new Format();

                                $get_inbox_cart = $ct->get_inbox_cart_history(Session::get('userId'));
                                if($get_inbox_cart){
                                    $i = 0;
                                    while($result = $get_inbox_cart->fetch_assoc()){
                                        $i++;

                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $i;?></td>
                                <td><?php echo $fm->formatDate($result['date_created']);?></td>
                                <td><?php echo $result['order_code']?></td>
                                <td><?php echo $result['fullname']?></td>
                                <td><a href="history_order_details.php?customerid=<?php echo $result['user_id']?>&order_code=<?php echo $result['order_code']?>">Xem đơn hàng</a></td>
                                <td>
                                    <?php 
                                    if($result['status'] == 0){
                                    ?>
                                        <?php echo 'Chưa xác nhận'?>

                                    <?php 
                                    }else if($result['status'] == 1){
                                    ?>

                                        <a href="?danhanhang=<?php echo $result['order_code']?>">Đã nhận hàng</a>
                                    
                                    <?php 
                                    }else if($result['status'] == 2){
                                    ?>
                                        <?php echo 'Đơn thành công'?>

                                    <?php 
                                    }
                                    ?>
                                      
                                </td>
                            </tr>

                            <?php 
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include 'inc/footer.php';
?>