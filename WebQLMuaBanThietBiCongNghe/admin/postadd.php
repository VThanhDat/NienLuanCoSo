<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/post.php';?>
<?php
	$post = new post();
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$catPostName = $_POST['catPostName'];
        $catDesc = $_POST['catDesc'];
        $catStatus = $_POST['catStatus'];

		$insertCategoryPost = $post->insert_cate_post($catPostName,$catDesc, $catStatus);
	}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Thêm danh mục tin tức</h2>
               <div class="block copyblock"> 
                <?php
                if(isset($insertCategoryPost)){
                    echo $insertCategoryPost;
                }
                ?>
                 <form autocomplete="off" action="postadd.php" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="catPostName" placeholder="Vui lòng thêm danh mục tin tức" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="catDesc" placeholder="Vui lòng thêm mô tả danh mục" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select name="catStatus">
                                    <option value="0">Hiển thị</option>
                                    <option value="1">Ẩn</option>
                                </select>
                            </td>
                        </tr>
                        
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>