<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
if (!isset($_GET['catid']) || $_GET['catid'] == NULL) {
    echo "<script>window.location = '404.php'</script>";
} else {
    $id = $_GET['catid'];
}

// if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
//     $updateProduct = $pd->update_product($_POST, $_FILES, $id);
// }
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

<style>
	.main{
		display: flex;
		gap: 50px;
	}

	.noidung{
		padding: 20px 0;
		background: #FFF;
	}

	.content{
		flex: 1;
	}

	.danhmuc,.brand{
		list-style: none;
		padding: 0;
		margin-top: 10px;
	}

	.danhmuc-li,.brand-li{
		margin-bottom: 5px;
	}

	.danhmuc-li a,.brand-li a{
		text-decoration: none;
        color: #000;
        display: block;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: background-color 0.3s ease;
	}

	.danhmuc-li a:hover,.brand-li a:hover{
		background-color: #f2f2f2;
	}
</style>

<?php 
    $min_price = $product->getMinProductPrice();
    $max_price = $product->getMaxProductPrice();

    // Check if the form is submitted for price filtering
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['price_from']) && isset($_GET['price_to'])) {
        $price_from = $_GET['price_from'];
        $price_to = $_GET['price_to'];

        $filtered_products = $product->getProductsByCatIdPriceRange($price_from, $price_to, $id);
    } else {
        $productbycat = $cat->get_product_by_cat($id);
    }
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<div class="main">
    <div class="content">
		<?php 
			$products_to_display = isset($filtered_products) ? $filtered_products : $productbycat;
			if ($products_to_display) {
		?>
		<form action="productbycat.php" method="get">
            <p>
                <label for="amount">Khoảng giá lọc:</label>
                <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
            </p>
            <div id="slider-range" style="margin-bottom: 5px;"></div>
            <input type="hidden" name="catid" value="<?php echo $id; ?>">
            <input type="hidden" name="price_from" value="" id="price_from">
            <input type="hidden" name="price_to" value="" id="price_to">
            <input type="submit" value="Lọc giá" class="button filter-price">
        </form>
		<?php 
			}
		?>
        <?php
        $name_cat = $cat->get_name_by_cat($id);
        if ($name_cat) {
            while ($result_name = $name_cat->fetch_assoc()) {
                ?>
                <div class="content_top">
                    <div class="heading">
                        <h3>Category : <?php echo $result_name['catName'] ?></h3>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php
            }
        }
        ?>
        <div class="section group">
            <?php
				$products_to_display = isset($filtered_products) ? $filtered_products : $productbycat;
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
                // Free the result set
                $products_to_display->free_result();
            } else {
                echo 'Sản phẩm không có sẵn.';
            }
            ?>
        </div>
		<center style="padding: 10px;">
			<div class="pagination">
				<?php
				$product_all = $product->get_all_product_by_cat($id); // Update this line
				if ($product_all === false) {
					die(); 
				}
				$product_count = mysqli_num_rows($product_all);
				$product_button = ceil($product_count / 4);
				$current_page = isset($_GET['pagecat']) ? $_GET['pagecat'] : 1;

				$visible_pages = 2; // Number of visible pages
				$half_visible = floor($visible_pages / 2);

				$filter_params = '';
				if (isset($_GET['price_from']) && isset($_GET['price_to'])) {
					$filter_params .= '&price_from=' . $_GET['price_from'] . '&price_to=' . $_GET['price_to'];
				}

				if ($current_page > 1) {
					echo '<a style="margin:0 5px" href="productbycat.php?pagecat=' . ($current_page - 1) . '&catid=' . $id . $filter_params . '">Previous</a>';
				}

				for ($i = 1; $i <= $product_button; $i++) {
					if ($i == 1 || $i == $product_button || ($i >= $current_page - $half_visible && $i <= $current_page + $half_visible)) {
						echo '<a style="margin:0 5px" ' . ($i == $current_page ? 'class="active"' : '') . ' href="productbycat.php?pagecat=' . $i . '&catid=' . $id . $filter_params . '">' . $i . '</a>';
					} elseif ($i == 2 || $i == $product_button - 1) {
						echo '<span>...</span>';
					}
				}

				if ($current_page < $product_button) {
					echo '<a style="margin:0 5px" href="productbycat.php?pagecat=' . ($current_page + 1) . '&catid=' . $id . $filter_params . '">Next</a>';
				}
				?>
			</div>
		</center>
    </div>
</div>

<?php
include 'inc/footer.php';
?>
