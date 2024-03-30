<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/post.php';?>
<?php
    $post = new post();
    if(!isset($_GET['catepostid']) || $_GET['catepostid'] == NULL){
        echo "<script>window.location = 'postedit.php'</script>";
    }else{
        $id = $_GET['catepostid'];    
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$catPostName = $_POST['catPostName'];
        $catDesc = $_POST['catDesc'];
        $catStatus = $_POST['catStatus'];

		$updateCatPost = $post->update_category_post($catPostName,$catDesc, $catStatus, $id);
	}

?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Sửa danh mục tin tức</h2>
               <div class="block copyblock"> 
                <?php
                if(isset($updateCatPost)){
                    echo $updateCatPost;
                }
                ?>
                <?php
                    $get_cate_post = $post->getcatpostbyId($id);
                    if($get_cate_post){
                        while($result = $get_cate_post->fetch_assoc()){

                ?>
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['title']?>" name="catPostName" placeholder="Sửa danh mục tin tức" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="catDesc" value="<?php echo $result['desc_post']?>" placeholder="Vui lòng thêm mô tả tin tức" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select name="catStatus">
                                    <?php 
                                        if($result['status'] == 0){
                                    ?>
                                    <option selected value="0">Hiển thị</option>
                                    <option value="1">Ẩn</option>
                                    <?php 
                                        }else{
                                    ?>
                                     <option value="0">Hiển thị</option>
                                    <option selected value="1">Ẩn</option>
                                    <?php 
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Update" />
                            </td>
                        </tr>
                    </table>
                    </form>
                <?php
                     }
                    }
                ?>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>