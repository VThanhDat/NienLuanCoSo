<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>

<?php
if (!isset($_GET['brandid']) || $_GET['brandid'] == NULL) {
    echo "<script>window.location = '404.php'</script>";
} else {
    $id = $_GET['brandid'];
}
?>

<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['themgiohang'])) {
		$product_stock = $_POST['stock'];
		$quantity = $_POST['quantity'];
		$id = $_POST['productId'];
		$insertCart = $ct->add_to_cart($quantity,$product_stock, $id);
		if($insertCart){
			echo "<script>window.location = 'cart.php'</script>";
		}
	}
?>

<?php 
    $min_price = $product->getMinProductPrice();
    $max_price = $product->getMaxProductPrice();

    // Check if the form is submitted for price filtering
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['price_from']) && isset($_GET['price_to'])) {
        $price_from = $_GET['price_from'];
        $price_to = $_GET['price_to'];

        $filtered_products = $product->getProductsByBrandIdPriceRange($price_from, $price_to, $id);
    } else {
        $products_by_brand = $br->get_product_by_brand($id);
    }
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<div class="main">
	<div class="content">
		<?php 
			$products_to_display = isset($filtered_products) ? $filtered_products : $products_by_brand;
    		// Check if there are products to display
   			 if ($products_to_display) {
		?>
			<form action="topbrands.php" method="get">
				<p>
					<label for="amount">Khoảng giá lọc:</label>
					<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
				</p>
				<div id="slider-range" style="margin-bottom: 5px;"></div>
				<input type="hidden" name="brandid" value="<?php echo $id; ?>">
				<input type="hidden" name="price_from" value="" id="price_from">
				<input type="hidden" name="price_to" value="" id="price_to">
				<input type="submit" value="Lọc giá" class="button filter-price">
			</form>
		<?php 
			}
		?>
		<?php
		$name_brand = $br->get_name_by_brand($id);
		if ($name_brand) {
			while ($result_name = $name_brand->fetch_assoc()) {
		?>
				<div class="content_top">
					<div class="heading">
						<h3>Brand : <?php echo $result_name['brandName'] ?></h3>
					</div>
					<div class="clear"></div>
				</div>
		<?php
			}
		}
		?>
		<div class="section group">
			<?php

			if ($products_to_display) {
				while ($result = $products_to_display->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result['productId']?>"><img src="admin/uploads/<?php echo $result['image'] ?>" width="80px" height="100px" alt="" /></a>
						<h2><?php echo $result['productName'] ?> </h2>
						<p><?php echo $fm->textShorten($result['product_desc'], 30) ?></p>
						<p><span class="price"><?php echo $fm->format_currency($result['price']) . " VND" ?></span></p>

						<?php if ($result['product_remain'] <= 0){ ?>
							<input style="color: red;" type="submit" value="Hết hàng" class="button">
						<?php }else { ?>
							<form action="" method="post">
								<input type="hidden" name="quantity" value="1">
								<input type="hidden" name="stock" value="<?php echo $result['product_remain']?>">
								<input type="hidden" name="productId" value="<?php echo $result['productId']?>" class="button">
								<input type="submit" name="themgiohang" value="Thêm giỏ hàng" class="button">
							</form>
						<?php 
						} 
						?>
						<div class="button"><span><a href="details.php?proid=<?php echo $result['productId'] ?>" class="details">Chi tiết</a></span></div>
					</div>
			<?php
				}
				
			} else {
				echo 'Sãn phẩm không có sẵn.';
			}
			?>
		</div>
		<center style="padding: 10px;">
			<div class="pagination">
				<?php
				$product_all = $product->get_all_product_by_brand($id); // Update this line
				if ($product_all === false) {
					die(); 
				}
				$product_count = mysqli_num_rows($product_all);
				$product_button = ceil($product_count / 4);
				$current_page = isset($_GET['pagebrand']) ? $_GET['pagebrand'] : 1;

				$visible_pages = 2; // Number of visible pages
				$half_visible = floor($visible_pages / 2);

				$filter_params = '';
				if (isset($_GET['price_from']) && isset($_GET['price_to'])) {
					$filter_params .= '&price_from=' . $_GET['price_from'] . '&price_to=' . $_GET['price_to'];
				}

				if ($current_page > 1) {
					echo '<a style="margin:0 5px" href="topbrands.php?pagebrand=' . ($current_page - 1) . '&brandid=' . $id . $filter_params . '">Previous</a>';
				}

				for ($i = 1; $i <= $product_button; $i++) {
					if ($i == 1 || $i == $product_button || ($i >= $current_page - $half_visible && $i <= $current_page + $half_visible)) {
						echo '<a style="margin:0 5px" ' . ($i == $current_page ? 'class="active"' : '') . ' href="topbrands.php?pagebrand=' . $i . '&brandid=' . $id . $filter_params . '">' . $i . '</a>';
					} elseif ($i == 2 || $i == $product_button - 1) {
						echo '<span>...</span>';
					}
				}

				if ($current_page < $product_button) {
					echo '<a style="margin:0 5px" href="topbrands.php?pagebrand=' . ($current_page + 1) . '&brandid=' . $id . $filter_params . '">Next</a>';
				}
				?>
			</div>
		</center>
	</div>
</div>

<?php
include 'inc/footer.php';
?>