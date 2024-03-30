<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/post.php';?>
<?php
	$post = new post();
	if(isset($_GET['delcatepostid'])){
        $id = $_GET['delcatepostid'];  
		$del_cat_post = $post->del_category_post($id);  
    }



    if(isset($_GET['type_slider']) && isset($_GET['type'])){
		$id = $_GET['type_slider'];
		$type = $_GET['type'];
		$update_slider = $product->update_type_slider($id, $type);
	}

?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Danh sách danh mục tin tức</h2>
                <div class="block">        
				<?php
                if(isset($del_cat_post)){
                    echo $del_cat_post;
                }
                ?>
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Category Post Name</th>
                            <th>Category Post Desc</th>
                            <th>Category Post Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$show_cate = $post->show_category_post();
							if($show_cate){
								$i = 0;
								while($result = $show_cate->fetch_assoc()){
									$i++;
						?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $result['title']; ?></td>
                            <td><?php echo $result['desc_post']; ?></td>
                            <td>
								<?php 
									if($result['status'] == 0){
                                        echo 'Hiển thị';
								    }else{
                                        echo 'Ẩn';
                                    }
								?>
							</td>
							<td><a href="postedit.php?catepostid=<?php echo $result['id_cate_post'] ?>">Edit</a> || <a onclick="return confirm('Are you want to delete ?')" href="?delcatepostid=<?php echo $result['id_cate_post'] ?>">Delete</a></td>
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

