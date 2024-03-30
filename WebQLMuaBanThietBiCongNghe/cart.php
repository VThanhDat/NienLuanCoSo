<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
	$cartId = $_POST['cartId'];
	$stock = $_POST['stock'];
	$quantity = $_POST['quantity'];
	$update_quantity_cart = $ct->update_quantity_cart($stock,$quantity, $cartId);
	if ($quantity <= 0) {
		$delcart = $ct->del_product_cart($cartId);
	}
}
if (isset($_GET['cartid'])) {
	$cartid = $_GET['cartid'];
	$delcart = $ct->del_product_cart($cartid);
}
?>
<?php
	if(!isset($_GET['id'])){
		echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
	}
?>
<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class="cartpage">
				<h2>Giỏ hàng của bạn</h2>
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
						<th width="20%">Product Stock</th>
						<th width="10%">Image</th>
						<!-- <th width="15%">Price</th> -->
						<th width="25%">Quantity</th>
						<th width="20%">Total Price</th>
						<th width="10%">Buy</th>
						<th width="10%">Action</th>
					</tr>
					<?php
					$get_pro_cart = $ct->get_product_cart(); // Corrected the method call

					if ($get_pro_cart) {
						$subtotal = 0;
						$qty = 0;
						while ($result = $get_pro_cart->fetch_assoc()) {
					?>
							<tr>
								<td><?php echo $result['productName'] ?></td>
								<td><?php echo $result['stock'] ?></td>
								<td><img src="admin/uploads/<?php echo $result['image'] ?>" alt="" /></td>
								<!-- <td><?php echo $fm->format_currency($result['price']) . ' VND' ?></td> -->
								<td>
									<form action="" method="post">
										<input type="hidden" name="cartId" value="<?php echo $result['cartId'] ?>" />
										<input type="hidden" name="stock" value="<?php echo $result['stock'] ?>" />
										<input type="number" name="quantity" min="0" value="<?php echo $result['quantity'] ?>" />
										<input type="submit" name="submit" value="Update">
									</form>
								</td>
								<td><?php $total = $result['price'] * $result['quantity'];
									echo $fm->format_currency($total) . ' VND';
									?></td>
									<td>
										<div class="form-check">
											<input type="checkbox" 
											<?php 
												echo $result['status'] == 1 ? 'checked' : ''
											?>
											class="form-check-input buy_checked" value="<?php echo $result['cartId']?>" id="defaultCheck1">
						
											<label for="defaultCheck1" class="form-check-label">
												Mua hàng	
											</label>
										</div>
									</td>
								<td><a href="?cartid=<?php echo $result['cartId'] ?>">Xóa</a></td>
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
					echo 'Giỏ hàng của bạn đang trống! Vui lòng mua hàng ngay.';
				}
				?>
			</div>
			<div class="shopping">
				<div class="shopleft">
					<a href="index.php"> <img src="images/shop.png" alt="" /></a>
				</div>
				<div class="shopright">
					<a href="payment.php"> <img src="images/check.png" alt="" /></a>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>

<?php
include 'inc/footer.php';
?>