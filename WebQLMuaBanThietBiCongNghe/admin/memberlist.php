<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php 
	$filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/user.php');
	// include_once ($filepath.'/../helpers/format.php');
?>
<?php
    $user = new user();
	if(isset($_GET['deluserid'])){
		$deluserid = $_GET['deluserid'];
		$del_user= $user->del_user_normal($deluserid);
	}

?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Danh sách thành viên</h2>
                <div class="block">        
					
					<?php 
						if(isset($del_user)){
							echo $del_user;
						}
					?>
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>No.</th>
							<th>Email</th>
							<th>Full Name</th>
							<th>Date</th>
                            <th>Role</th>
                            <th>Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$user = new user();
							$get_all_user = $user->get_user();
							if($get_all_user){
								$i = 0;
								while($result = $get_all_user->fetch_assoc()){
									$i++;
						?>
						<tr class="odd gradeX">
							<td><?php echo $i;?></td>
							<td><?php echo $result['email']?></td>
							<td><?php echo $result['fullname']?></td>
                            <td><?php echo $result['dob']?></td>
                            <td><?php echo $result['name']?></td>
                            <td><?php echo $result['address']?></td>
                            <td><a href="memberedit.php?usereditid=<?php echo $result['id']?>&rolecurrent=<?php echo $result['role_id'] ?>">Edit</a> || <a onclick="return confirm('Are you want to delete ?')" href="?deluserid=<?php echo $result['id'] ?>">Delete</a></td>
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
