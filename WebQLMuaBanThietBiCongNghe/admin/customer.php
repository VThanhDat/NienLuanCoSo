<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../classes/user.php');
include_once($filepath . '/../helpers/format.php');
?>
<?php
if (!isset($_GET['customerid']) || $_GET['customerid'] == NULL) {
    echo "<script>window.location = 'inbox.php'</script>";
} else {
    $id = $_GET['customerid'];
    $order_code = $_GET['order_code'];
}
$user = new user();
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Chi tiết đơn hàng</h2>
        <div class="block copyblock">
            <?php
            $get_customer = $user->show_users($id);
            if ($get_customer) {
                while ($result = $get_customer->fetch_assoc()) {

            ?>
                    <form action="" method="post">
                        <h3>Thông tin người đặt hàng</h3>
                        <table class="form">
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['fullname'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['email'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>Date of birth</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['dob'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>
                                    <input type="text" readonly="readonly" value="<?php echo $result['address'] ?>" name="catName" class="medium" />
                                </td>
                            </tr>

                        </table>
                    </form>
            <?php
                }
            }
            ?>
        </div>
        <table class="data display datatable" id="example">
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
                $get_order = $user->show_order($order_code);
                if ($get_order) {
                    $subtotal = 0;
                    $total = 0;
                    while ($result_order = $get_order->fetch_assoc()) {
                        $subtotal = $result_order['quantity'] * $result_order['price'];
                        $total += $subtotal;

                ?>
                        <tr class="odd gradeX" style="text-align: center;">
                            <td><?php echo $result_order['productName'] ?></td>
                            <td><img src="uploads/<?php echo $result_order['image'] ?>" width="80"></td>
                            <td><?php echo number_format($result_order['price'], 0, ',', '.') ?> VNĐ</td>
                            <td><?php echo $result_order['quantity'] ?></td>
                            <td><?php echo number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
                        </tr>
                <?php
                    }
                }
                ?>
                <tr style="text-align: center;" >
                    <td colspan="5">Thành tiền: <?php echo number_format($total, 0, ',', '.') ?> VNĐ </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
<?php include 'inc/footer.php'; ?>