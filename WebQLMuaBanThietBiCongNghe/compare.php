<?php
	include 'inc/header.php';
	// include 'inc/slider.php';
?>

<?php
	// if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
	// 	$cartId = $_POST['cartId'];
	// 	$quantity = $_POST['quantity'];
	// 	$update_quantity_cart = $ct->update_quantity_cart($quantity, $cartId);	
	// 	if($quantity <= 0){
	// 		$delcart = $ct->del_product_cart($cartId);  
	// 	}
	// }
	// if(isset($_GET['cartid'])){
    //     $cartid = $_GET['cartid'];  
	// 	$delcart = $ct->del_product_cart($cartid);  
    // }
?>
<?php
	// if(!isset($_GET['id'])){
	// 	echo "<meta http-equiv='refresh' content='0;URL=?id=live'>";
	// }
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
			    	<h2>Sản phẩm so sánh</h2>
					<?php
						if(isset($update_quantity_cart)){
							echo $update_quantity_cart;
						}
					?>
					<?php
						if(isset($delcart)){
							echo $delcart;
						}
					?>
						<table class="tblone">
							<tr>
								<th width="10%">ID Compare</th>
								<th width="20%">Product Name</th>
								<th width="20%">Image</th>
								<th width="15%">Price</th>
								<th width="15%">Action</th>
							</tr>
							<?php 
								$user_id = Session::get('userId');
								$get_compare = $product->get_compare($user_id); // Corrected the method call

								if($get_compare){
									$i = 0;
									while($result = $get_compare->fetch_assoc()){
										$i++;
							?>
										<tr>
											<td><?php echo $i;?></td>
											<td><?php echo $result['productName'] ?></td>
											<td><img src="admin/uploads/<?php echo $result['image']?>" alt=""/></td>
											<td><?php echo  $fm->format_currency($result['price']).' VND' ?></td>
										
											
											<td><a href="details.php?proid=<?php echo $result['productId'] ?>">View</a></td>
										</tr>
							<?php
									}
								}                        
							?>
							
						</table>
					</div>
					<div class="shopping">
						<div class="shopleft">
								<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

 <?php
	include 'inc/footer.php';
?>