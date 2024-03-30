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
                    <h3 class="payment">Lịch sử đơn đã đặt chi tiết</h3>
                </div>
                <div class="clear"></div>
                <div class="wrapper_method">
                    <table class="tblone" id="example">
                        <thead>
                            <tr class="odd gradeX">
                                <th>Tên sản phẩm</th>
                                <th>Hỉnh ảnh sản phẩm</th>
                                <th>Giá sản phẩm</th>
                                <th>Số lượng sản phẩm</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $order_code = $_GET['order_code'];
                            $get_order = $user->show_order($order_code);
                            if ($get_order) {
                                $subtotal = 0;
                                $total = 0;
                                while ($result_order = $get_order->fetch_assoc()) {
                                    $subtotal = $result_order['quantity'] * $result_order['price'];
                                    $total += $subtotal;

                            ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $result_order['productName'] ?></td>
                                        <td><img src="admin/uploads/<?php echo $result_order['image'] ?>" width="80"></td>
                                        <td><?php echo number_format($result_order['price'], 0, ',', '.') ?> VNĐ</td>
                                        <td><?php echo $result_order['quantity'] ?></td>
                                        <td><?php echo number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="5">Thành tiền: <?php echo number_format($total + $total*0.1 , 0, ',', '.') ?> VNĐ </td>
                            </tr>
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