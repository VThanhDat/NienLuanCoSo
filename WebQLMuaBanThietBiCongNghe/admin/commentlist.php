<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php 
	$filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/user.php');
	include_once ($filepath.'/../helpers/format.php');
?>
<?php
    $user = new user();
	if(isset($_GET['delcommentid'])){
		$delcommentid = $_GET['delcommentid'];
		$user_id = $_GET['user_id'];
		$del_comment= $user->del_comment($delcommentid, $user_id);
	}

?>


        <div class="grid_10">
            <div class="box round first grid">
                <h2>Danh sách bình luận</h2>
                <div class="block">        
					
					<?php 
						if(isset($del_comment)){
							echo $del_comment;
						}
					?>
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>No.</th>
							<th>Product</th>
							<th>Name</th>
							<!-- <th>Customer ID</th> -->
							<th>Description</th>
							<!-- <th>Address</th> -->
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$user = new user();
							$fm = new Format();
							$get_user_comment = $user->get_user_comment();
							if($get_user_comment){
								$i = 0;
								while($result = $get_user_comment->fetch_assoc()){
									$i++;

						?>
						<tr class="odd gradeX">
							<td><?php echo $i;?></td>
							<td><?php echo $result['productName']?></td>
							<td><?php echo $result['tenbinhluan']?></td>
							<!-- <td><?php echo $result['user_id']?></td> -->
							<td><?php echo $fm->textShorten($result['binhluan'], 20) ?></td>
							<!-- <td><a href="customer.php?customerid=<?php echo $result['user_id']?>">View Customer</a></td> -->
							<td>
                                <a href="?delcommentid=<?php echo $result['binhluan_id']?>&user_id=<?php echo $result['user_id'] ?>">Xóa</a>
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
