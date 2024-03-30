<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
	echo "<script>window.location = '404.php'</script>";
} else {
	$id = $_GET['proid'];
}
$user_id = Session::get('userId');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])) {
	$productid = $_POST['productid'];
	$insertCompare = $product->insertCompare($productid, $user_id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
	$product_stock = $_POST['product_stock'];
	$quantity = $_POST['quantity'];
	$insertCart = $ct->add_to_cart($quantity, $product_stock, $id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlist'])) {
	$productid = $_POST['productid'];
	$insertWishlist = $product->insertWishlist($productid, $user_id);
}

if (isset($_POST['binhluan_submit'])) {
	$binhluan = $user->insert_binhluan($user_id);
}

?>

<style>
	.button_details input[type=submit] {
		float: left;
		margin: 5px;
	}

	ul.rating-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	ul.rating-list li {
		display: inline-block;
		margin-right: 10px;
	}

	ul.rating-list li.rating,
	ul.rating-list li.rating_login {
		font-size: 40px;
		cursor: pointer;
	}

	ul.rating-list li.rating {
		color: #ffcc00;
	}

	ul.rating-list li.rating_login {
		color: #ccc;
	}

	ul.rating-list li.rounded {
		border-radius: 50%;
		background-color: #ffcc00;
		color: #fff;
		padding: 5px;
	}

	ul.rating-list li.solan {
		font-size: 16px;
		color: #777;
	}

	ul.rating-list li:nth-child(odd) {
		background-color: #f9f9f9;
		padding: 5px;
	}

	ul.rating-list li:nth-child(even) {
		background-color: #fff;
		padding: 5px;
	}

	ul.rating-list li span {
		font-size: 18px;
		color: #333;
	}
</style>

<div class="main">
	<div class="content">
		<div class="section group">
			<?php
			$get_product_details = $product->get_details($id);
			$get_sold_quantity = $product->countOrdersWithPaymentStatusTwo($id);
			if ($get_product_details) {
				while ($result_details = $get_product_details->fetch_assoc()) {
			?>

					<div class="cont-desc span_1_of_2">
						<div class="grid images_3_of_2">
							<img src="admin/uploads/<?php echo $result_details['image'] ?>" alt="" />
						</div>
						<div class="desc span_3_of_2">
							<h2><?php echo $result_details['productName'] ?> </h2>
							<p><?php echo $fm->textShorten($result_details['product_desc'], 50) ?></p>
							<div class="price">
								<p>Giá: <span><?php echo  $fm->format_currency($result_details['price']) . " VND" ?></span></p>
								<p>Danh mục: <span><?php echo $result_details['catName'] ?></span></p>
								<p>Thương hiệu:<span><?php echo $result_details['brandName'] ?></span></p>
								<p>Tổng số lượng:<span><?php echo $result_details['product_quantity'] ?>/cái</span></p>
								<p>Số lượng đã bán:<span><?php echo $result_details['product_soldcount'] ?>/cái</span></p>
								<p>Kho:<span><?php echo $result_details['product_remain'] ?>/cái</span></p>

							</div>
							<div class="add-cart">
								<form action="" method="post">
									<input type="hidden" class="buyfield" name="product_stock" value="<?php echo $result_details['product_remain'] ?>" />
									<input type="number" class="buyfield" name="quantity" value="1" min="1" />
									<?php
									if ($result_details['product_remain'] > 0) {
									?>
										<input type="submit" class="buysubmit" name="submit" value="Mua hàng" />
									<?php
									}
									?>
								</form>
								<?php
								if (isset($insertCart)) {
									echo $insertCart;
								}
								?>
							</div>

							<div class="add-cart">
								<div class="button_details">
									<form action="" method="post">
										<!-- <a href="?wlist=<?php echo $result_details['productId'] ?>" class="buysubmit">Save to Wishlist</a> -->
										<!-- <a href="?compare=<?php echo $result_details['productId'] ?>" class="buysubmit">Compare Product</a> -->
										<input type="hidden" class="buysubmit" name="productid" value="<?php echo $result_details['productId'] ?>" />

										<?php
										$login_check = Session::get('user');
										if ($login_check) {
											echo '<input type="submit" class="buysubmit" name="compare" value="Thêm vào so sánh" />' . '  ';
										} else {
											echo '';
										}
										?>
									</form>
									<form action="" method="post">
										<!-- <a href="?wlist=<?php echo $result_details['productId'] ?>" class="buysubmit">Save to Wishlist</a> -->
										<!-- <a href="?compare=<?php echo $result_details['productId'] ?>" class="buysubmit">Compare Product</a> -->
										<input type="hidden" class="buysubmit" name="productid" value="<?php echo $result_details['productId'] ?>" />

										<?php
										$login_check = Session::get('user');
										if ($login_check) {
											echo '<input type="submit" class="buysubmit" name="wishlist" value="Thêm vào yêu thích" />';
										} else {
											echo '';
										}
										?>
									</form>
								</div>
								<div class="clear"></div>
								<p>
									<?php
									if (isset($insertCompare)) {
										echo $insertCompare;
									}
									?>
									<?php
									if (isset($insertWishlist)) {
										echo $insertWishlist;
									}
									?>
								</p>
							</div>
						</div>
						<div class="product-desc">
							<h2>Chi tiết sản phẩm</h2>
							<p><?php echo $fm->textShorten($result_details['product_desc'], 150) ?></p>
						</div>
					</div>

			<?php
				}
			}
			?>


			<div class="rightsidebar span_3_of_1">
				<h2>Danh mục sản phẩm</h2>
				<ul>
					<?php
					$getall_category = $cat->show_category_fontend();
					if ($getall_category) {
						while ($result_allcat = $getall_category->fetch_assoc()) {
					?>
							<li><a href="productbycat.php?catid=<?php echo $result_allcat['catId'] ?>"><?php echo $result_allcat['catName'] ?></a></li>
					<?php
						}
					}
					?>
				</ul>

			</div>
		</div>

		<div class="binhluan">
			<div class="row">
				<div class="col-md-8">
					<div class="product-desc">
						<h2>Đánh giá sao</h2>
					</div>
					<ul class="rating-list">
						<?php
						$trungbinhsao = 0; // Initialize outside the loop
						$solan = 0;

						// Get star ratings
						$get_star = $product->get_star($id);
						if ($get_star) {
							$tongsao = 0;
							while ($result_star = $get_star->fetch_assoc()) {
								$tongsao += $result_star['rating'];
								$solan += 1;
							}
							$trungbinhsao = ($solan > 0) ? ($tongsao / $solan) : 0;
						}

						// Get product details
						$get_product_details_2 = $product->get_details($id);
						if ($get_product_details_2) {
							while ($result_details2 = $get_product_details_2->fetch_assoc()) {
								?>
								<?php
								for ($count = 1; $count <= 5; $count++) {
									if (Session::get('userId')) {
										$color = ($count <= round($trungbinhsao)) ? 'color:#ffcc00' : 'color: #ccc';
										?>
										<li class="rating" style="cursor: pointer; font-size: 40px; <?php echo $color ?>" id="<?php echo $result_details2['productId'] ?>-<?php echo $count ?>" data-product_id="<?php echo $result_details2['productId'] ?>" data-rating="<?php echo $count ?>" data-index="<?php echo $count ?>" data-user_id="<?php echo Session::get('userId') ?>">
											&#9733;
										</li>
										<?php
									} else {
										$color = ($count <= round($trungbinhsao)) ? 'color:#ffcc00' : 'color: #ccc';
										?>
										<li class="rating_login" style="cursor: pointer; font-size: 40px; <?php echo $color; ?>">
											&#9733;
										</li>
										<?php
									}
									?>
								<?php
								}
								?>
								<li>
									<?php
									if (isset($trungbinhsao) && isset($solan)) {
										echo '<li>Đã đánh giá: ' . number_format($trungbinhsao, 1) . '/5</li>';
										echo '<li>Số lần đánh giá: ' . $solan . '</li>';
									} else {
										echo '<li>Chưa có đánh giá</li>';
										echo '<li>Số lần đánh giá: 0</li>';
									}
									?>
								</li>
								<?php
							}
						}
						?>
					</ul>
					<div class="product-desc">
						<h2>Ý kiến sản phẩm</h2>
					</div>
					<?php
					// Lấy danh sách bình luận từ cơ sở dữ liệu
					if (isset($binhluan)) {
						echo $binhluan;
					}

					if (Session::get('user')) {
						// Hiển thị Form Bình luận
						echo '<form action="" method="post">';
						echo '<p><input type="hidden" value="' . $id . '" name="product_id_binhluan"></p>';
						echo '<p><input type="text" placeholder="Điền tên" class="form-control" name="tennguoibinhluan"></p>';
						echo '<p><textarea rows="5" style="resize: none;" placeholder="Bình luận ..." name="binhluan" class="form-control"></textarea></p>';
						echo '<p><input type="submit" class="btn btn-success" name="binhluan_submit" value="Gửi bình luận"></p>';
						echo '</form>';
					} else {
						// Hiển thị thông báo yêu cầu đăng nhập
						echo '<p>Bạn cần đăng nhập để thêm bình luận.</p>';
						// Đưa ra các lựa chọn đăng nhập/đăng ký	
						echo '<p><a href="login.php">Đăng nhập</a> hoặc <a href="register.php">Đăng ký</a></p>';
					}
					?>
					<?php
					$get_product_comment = $user->get_binhluan($id);
					if ($get_product_comment) {
						while ($result_comment = $get_product_comment->fetch_assoc()) {
					?>
							<div style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px; border-radius: 5px;">
								<p style="font-weight: bold; color: #007bff;"><?php echo $result_comment['tenbinhluan'] ?></p>
								<p style="margin-top: 5px;"><?php echo $result_comment['binhluan'] ?></p>
							</div>
					<?php
						}
					}
					?>

					<center style="padding: 10px;">
						<div class="pagination">
							<?php
							// Check if the query executed successfully
							if ($get_product_comment !== false) {
								$comment_all = $user->get_all_comment_product($id);
								$comment_count = mysqli_num_rows($comment_all);
								$comment_button = ceil($comment_count / 4);
								$current_page = isset($_GET['pagecomment']) ? $_GET['pagecomment'] : 1;

								$visible_pages = 2; // Number of visible pages
								$half_visible = floor($visible_pages / 2);

								if ($current_page > 1) {
									echo '<a style="margin:0 5px" href="details.php?proid=' . $id . '&pagecomment=' . ($current_page - 1) . '">Previous</a>';
								}

								for ($i = 1; $i <= $comment_button; $i++) {
									if ($i == 1 || $i == $comment_button || ($i >= $current_page - $half_visible && $i <= $current_page + $half_visible)) {
										echo '<a style="margin:0 5px" ' . ($i == $current_page ? 'class="active"' : '') . ' href="details.php?proid=' . $id . '&pagecomment=' . $i . '">' . $i . '</a>';
									} elseif ($i == 2 || $i == $comment_button - 1) {
										echo '<span>...</span>';
									}
								}

								if ($current_page < $comment_button) {
									echo '<a style="margin:0 5px" href="details.php?proid=' . $id . '&pagecomment=' . ($current_page + 1) . '">Next</a>';
								}
							}
							?>
						</div>
					</center>
				</div>
			</div>
		</div>
	</div>
	<?php
	include 'inc/footer.php';
	?>