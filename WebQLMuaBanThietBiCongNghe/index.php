<?php
include 'inc/header.php';
include 'inc/slider.php';
?>
<style>
	.main {
		display: flex;
		gap: 50px;
	}

	.noidung {
		padding: 20px 0;
		background: #FFF;
	}

	.content {
		flex: 1;
	}

	.danhmuc,
	.brand {
		list-style: none;
		padding: 0;
		margin-top: 10px;
	}

	.danhmuc-li,
	.brand-li {
		margin-bottom: 5px;
	}

	.danhmuc-li a,
	.brand-li a {
		text-decoration: none;
		color: #000;
		display: block;
		padding: 5px;
		border: 1px solid #ccc;
		border-radius: 5px;
		transition: background-color 0.3s ease;
	}

	.danhmuc-li a:hover,
	.brand-li a:hover {
		background-color: #f2f2f2;
	}	
</style>

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

<div class="main">
	<!-- <div class="noidung">
		<div class="content_top">
			<div class="heading">
				<h3>Danh mục</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			echo '<ul class="danhmuc">';
			$cate = $cat->show_category();
			if ($cate) {
				while ($result_new = $cate->fetch_assoc()) {
					echo '<li class="danhmuc-li"><a href="productbycat.php?catid=' . $result_new['catId'] . '">' . $result_new['catName'] . '</a></li>';
				}
			}
			echo '</ul>';
			?>
		</div>

		<div class="content_bottom">
			<div class="heading">
				<h3>Thương hiệu</h3>
			</div>
			<div class="clear"></div>
		</div>

		<div class="section group">
			<?php
			echo '<ul class="brand">';
			$brand = $br->show_brand();
			if ($brand) {
				while ($result_new = $brand->fetch_assoc()) {
					echo '<li class="brand-li"><a href="topbrands.php?brandid=' . $result_new['brandId'] . '">' . $result_new['brandName'] . '</a></li>';
				}
			}
			echo '</ul>';
			?>
		</div>

	</div> -->

	<!-- Product feathered -->
	<div class="content">
		<div class="content_top">
			<div class="heading">
				<h3>Sản phẩm nổi bật</h3>
			</div>
			<div class="clear"></div>
		</div>

		<div class="section group">
			<?php
			$product_feathered = $product->getproduct_feathered();
			if ($product_feathered) {
				while ($result = $product_feathered->fetch_assoc()) {

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
			}
			?>
		</div>

		
		<!-- Product new -->
		<div class="content_bottom">
			<div class="heading">
				<h3>Sản phẩm mới</h3>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="section group">
			<?php
			$product_new = $product->getproduct_new();
			if ($product_new) {
				while ($result_new = $product_new->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result_new['productId']?>"><img src="admin/uploads/<?php echo $result_new['image'] ?>" width="80px" height="100px" alt="" /></a>
						<h2><?php echo $result_new['productName'] ?> </h2>
						<p><?php echo $fm->textShorten($result_new['product_desc'], 30) ?></p>
						<p><span class="price"><?php echo $fm->format_currency($result_new['price']) . " VND" ?></span></p>
					
						<?php if ($result_new['product_remain'] <= 0){ ?>
							<input style="color: red;" type="submit" value="Hết hàng" class="button">
						<?php }else { ?>
							<form action="" method="post">
								<input type="hidden" name="quantity" value="1">
								<input type="hidden" name="stock" value="<?php echo $result_new['product_remain']?>">
								<input type="hidden" name="productId" value="<?php echo $result_new['productId']?>" class="button">
								<input type="submit" name="themgiohang" value="Thêm giỏ hàng" class="button">
							</form>
						<?php 
						} 
						?>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_new['productId'] ?>" class="details">Chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>

		<!-- Phân trang -->
		<center style="padding: 10px;">
			<div class="pagination">
				<?php
				$product_all = $product->get_all_product();
				$product_count = mysqli_num_rows($product_all);
				$product_button = ceil($product_count / 4);
				$current_page = isset($_GET['trang']) ? $_GET['trang'] : 1;

				$visible_pages = 2; // Number of visible pages
				$half_visible = floor($visible_pages / 2);

				if ($current_page > 1) {
					echo '<a style="margin:0 5px" href="index.php?trang=' . ($current_page - 1) . '">Trước</a>';
				}

				for ($i = 1; $i <= $product_button; $i++) {
					if ($i == 1 || $i == $product_button || ($i >= $current_page - $half_visible && $i <= $current_page + $half_visible)) {
						echo '<a style="margin:0 5px" ' . ($i == $current_page ? 'class="active"' : '') . ' href="index.php?trang=' . $i . '">' . $i . '</a>';
					} elseif ($i == 2 || $i == $product_button - 1) {
						echo '<span>...</span>';
					}
				}

				if ($current_page < $product_button) {
					echo '<a style="margin:0 5px" href="index.php?trang=' . ($current_page + 1) . '">Tiếp</a>';
				}
				?>
			</div>
		</center>
	</div>
</div>

<?php
include 'inc/footer.php';
?>