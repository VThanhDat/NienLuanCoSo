﻿<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php 
	$filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/cart.php');
	include_once ($filepath.'/../helpers/format.php');
?>
<?php
    $ct = new cart();
    if(isset($_GET['shiftid'])){
		$id = $_GET['shiftid'];
		$shifted = $ct->shifted($id);
	}

	if(isset($_GET['delid'])){
		$id = $_GET['delid'];
		$del_shifted = $ct->del_shifted($id);
	}

?>


        <div class="grid_10">
            <div class="box round first grid">
                <h2>Liệt kê đơn hàng</h2>
                <div class="block">        
					<?php 
						if(isset($shifted)){
							echo $shifted;
						}
					?>
					<?php 
						if(isset($del_shifted)){
							echo $del_shifted;
						}
					?>
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>No.</th>
							<th>Order Time</th>
							<th>Order Code</th>
							<th>Customer Name</th>
							<th>Method Payment</th>
							<th>Action</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$ct = new cart();
							$fm = new Format();
							$get_inbox_cart = $ct->get_inbox_cart();
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
							<td>
								<?php 
								if($result['paymentMethod'] == 'offline') {
									echo 'Tiền mặt';
								} else if($result['paymentMethod'] == 'momo_wallet') {
									echo 'Momo';
								}else if($result['paymentMethod'] == 'vnpay') {
									echo 'Vnpay';
								}else if($result['paymentMethod'] == 'vnpay') {
									echo 'Vnpay';
								}
								?>
							</td>
							<td><a href="customer.php?customerid=<?php echo $result['user_id']?>&order_code=<?php echo $result['order_code']?>">Xem chi tiết</a></td>
							<td>
								<?php 
								if($result['status'] == 0){
								?>

									<a href="?shiftid=<?php echo $result['order_code']?>">Xác nhận</a>
								
								<?php 
								}else if($result['status'] == 1){
								?>
									<?php echo 'Đang vận chuyển...'?>

								<?php 
								}else if($result['status'] == 2){
								?>
									<a href="?delid=<?php echo $result['order_code']?>">Đã nhận | Xóa</a>
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
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
