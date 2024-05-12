<?php
ob_start(); // Bắt đầu output buffering
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/session.php');
include_once($filepath . '/../lib/database.php');	
include_once($filepath . '/../lib/PHPMailer.php');
include_once($filepath . '/../lib/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
?>

<?php
/**
 * 
 */
class user
{
	private $db;
	public function __construct()
	{
		$this->db = new Database();
	}

	public function login($email, $password)
	{
		$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";
		$result = $this->db->select($query);

		if ($result) {
			$value = $result->fetch_assoc();

			if ($value['isConfirmed'] == 1) {
				// User account is confirmed
				Session::set('user', true);
				Session::set('userId', $value['id']);
				Session::set('user_name', $value['fullname']);
				header("Location:index.php");
				ob_end_flush(); // Gửi output đi
			} else {
				// User account is not confirmed
				$alert = "Tài khoản chưa được xác minh!";
				return $alert;
			}
		} else {
			// Invalid login credentials
			$alert = "Tên đăng nhập hoặc mật khẩu không đúng!";
			return $alert;
		}
	}

	public function isEmailExists($email)
	{
		$email = mysqli_real_escape_string($this->db->link, $email);

		$query = "SELECT COUNT(*) as count FROM users WHERE email = '$email'";
		$result = $this->db->select($query);

		if ($result) {
			$row = $this->db->fetchAssoc($result);
			return $row['count'] > 0;
		}

		return false;
	}


	public function insert($data)
	{
		$fullName = $data['fullName'];
		$email = $data['email'];
		$dob = $data['dob'];
		$address = $data['address'];
		$password = md5($data['password']);


		$check_email = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$result_check = $this->db->select($check_email);
		// if ($result_check) {
		// 	$alert = "<span class='error'>Email already exists.</span>";
		// 	return $alert;
		// } else {
			// Genarate captcha
			$captcha = rand(10000, 99999);

			$query = "INSERT INTO users VALUES (NULL,'$email','$fullName','$dob','$password',2,'$address',0,'" . $captcha . "') ";
			$result = $this->db->insert($query);
			if ($result) {
				// Send email
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->Mailer = "smtp";

				$mail->SMTPDebug  = 0;
				$mail->SMTPAuth   = TRUE;
				$mail->SMTPSecure = "tls";
				$mail->Port       = 587;
				$mail->Host       = "smtp.gmail.com";
				$mail->Username   = "vodat3489@gmail.com";
				$mail->Password   = "faivmbvhkjxwnayc";

				$mail->IsHTML(true);
				$mail->CharSet = 'UTF-8';
				$mail->SetFrom("vodat3489@gmail.com", "Store BD");
				$mail->AddAddress($email, "recipient-name");
				$mail->addCC('vodat3489@gmail.com');
				$mail->Subject = "Xác nhận email tài khoản - StoreBD";
				$mail->Body = "<h3>Cảm ơn bạn đã đăng ký tài khoản tại website StoreBD</h3></br>Đây là mã xác minh tài khoản của bạn: " . $captcha . "";

				$mail->Send();

				return true;
			} else {
				return false;
			}
		// }
	}

	public function get()
	{
		$userId = Session::get('userId');
		$query = "SELECT * FROM users WHERE id = '$userId' LIMIT 1";
		$mysqli_result = $this->db->select($query);
		if ($mysqli_result) {
			$result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC)[0];
			return $result;
		}
		return false;
	}

	public function getLastUserId()
	{
		$query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
		$mysqli_result = $this->db->select($query);
		if ($mysqli_result) {
			$result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC)[0];
			return $result;
		}
		return false;
	}

	public function confirm($userId, $captcha)
	{
		$query = "SELECT * FROM users WHERE id = '$userId' AND captcha = '$captcha' LIMIT 1";
		$mysqli_result = $this->db->select($query);
		if ($mysqli_result) {
			// Update comfirmed
			$sql = "UPDATE users SET isConfirmed = 1 WHERE id = $userId";
			$update = $this->db->update($sql);
			if ($update) {
				return true;
			}
		}
		return 'Mã xác minh không đúng!';
	}

	public function show_users($id)
	{
		$query = "SELECT * FROM users WHERE id = '$id'";
		$result = $this->db->select($query);

		return $result;
	}

	public function show_order($order_code)
	{
		$query = "SELECT * FROM tbl_order WHERE order_code = '$order_code'";
		$result = $this->db->select($query);

		return $result;
	}

	public function update_user($data, $id)
	{
		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$dob = mysqli_real_escape_string($this->db->link, $data['dob']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		

		if ($name == "" || $email == "" || $dob == "" || $address == "") {
			$alert = "<span class ='error'>Fields must not be empty</span>";
			return $alert;
		} else {
			$query = "UPDATE users SET fullname='$name', email='$email', dob='$dob', address='$address' WHERE id='$id'";
			$result = $this->db->update($query);
			if ($result) {
				// Hiển thị thông báo thành công và chuyển hướng đến trang profile
				echo "<script>alert('Update Profile Customers Successfully');window.location.href = 'profile.php';</script>";
			} else {
				// Hiển thị thông báo lỗi
				echo "<span class ='error'>Update Profile Customers Not Successful</span>";
			}
		}
	}

	public function update_password($data, $id)
	{
		$password_cu = mysqli_real_escape_string($this->db->link, md5($data['password_cu']));
		$password_moi = mysqli_real_escape_string($this->db->link, md5($data['password_moi']));
		$password_nhaplai = mysqli_real_escape_string($this->db->link, md5($data['password_nhaplai']));

		if ($password_cu == "" || $password_moi == "" || $password_nhaplai == "") {
			$alert = "<span class ='error'>Fields must not be empty</span>";
			return $alert;
		} elseif ($password_moi != $password_nhaplai) {
			$alert = "<span class ='error'>New passwords do not match</span>";
			return $alert;
		} else {
			// Kiểm tra mật khẩu cũ
			$query = "SELECT * FROM users WHERE id='$id' AND password='$password_cu'";
			$result = $this->db->select($query);
			if ($result) {
				// Cập nhật mật khẩu mới
				$query_update = "UPDATE users SET password='$password_moi' WHERE id='$id'";
				$result_update = $this->db->update($query_update);
				if ($result_update) {
					// Hiển thị thông báo thành công và chuyển hướng đến trang profile
					echo "<script>alert('Update Password Successfully');window.location.href = 'profile.php';</script>";
				} else {
					// Hiển thị thông báo lỗi
					echo "<span class ='error'>Update Password Not Successful</span>";
				}
			} else {
				// Hiển thị thông báo lỗi khi mật khẩu cũ không chính xác
				echo "<span class ='error'>Incorrect current password</span>";
			}
		}
	}

	public function insert_binhluan($user_id)
	{
		$product_id = $_POST['product_id_binhluan'];
		$tenbinhluan = $_POST['tennguoibinhluan'];
		$binhluan = $_POST['binhluan'];

		if ($tenbinhluan == "" || $binhluan == "") {
			$alert = "<span class ='error'>Fields must not be empty</span>";
			return $alert;
		} else {
			$existingComments = $this->get_binhluan($product_id);

			// Check if $existingComments is an array or object
			if (!is_array($existingComments) && !is_object($existingComments)) {
				// Handle the case where get_binhluan returns false or a non-array/object
				$existingComments = array(); // or initialize it in a way that makes sense for your application
			}

			foreach ($existingComments as $comment) {
				if ($comment['user_id'] == $user_id && $comment['binhluan'] == $binhluan && $comment['tenbinhluan'] == $tenbinhluan) {
					// Bình luận đã tồn tại
					$alert = "<span class ='error'>Bình luận đã tồn tại. Vui lòng viết bình luận khác.</span>";
					return $alert;
				}
			}

			$query = "INSERT INTO tbl_binhluan(user_id,tenbinhluan,binhluan,product_id) VALUES('$user_id','$tenbinhluan','$binhluan','$product_id')";
			$result = $this->db->insert($query);

			if ($result) {
				$alert = "<span class ='success'>Bình luận thành công.</span>";
				return $alert;
			} else {
				$alert = "<span class ='error'>Bình luận không thành công.</span>";
				return $alert;
			}
		}
	}


	public function get_binhluan($id)
	{

		$binhluan_tungtrang = 4;
		if (!isset($_GET['pagecomment'])) {
			$trang = 1;
		} else {
			$trang = $_GET['pagecomment'];
		}
		$tung_trang = ($trang - 1) * 4;
		$query = "SELECT * FROM tbl_binhluan WHERE product_id ='$id' order by product_id desc LIMIT $tung_trang, $binhluan_tungtrang";
		$result = $this->db->select($query);
		return $result;
	}

	public function get_all_comment_product($id)
	{
		$query = "SELECT * FROM tbl_binhluan where product_id ='$id'";
		$result = $this->db->select($query);
		return $result;
	}

	public function get_user_comment()
	{
		$query = "SELECT tbl_binhluan.*,tbl_product.productName  FROM tbl_binhluan
				  INNER JOIN tbl_product ON tbl_binhluan.product_id = tbl_product.productId order by user_id desc";
		$result = $this->db->select($query);
		return $result;
	}

	public function del_comment($id, $user_id)
	{
		$id = mysqli_real_escape_string($this->db->link, $id);
		$user_id = mysqli_real_escape_string($this->db->link, $user_id);

		$query = "DELETE FROM tbl_binhluan WHERE user_id = '$user_id' and binhluan_id='$id'";

		$result = $this->db->delete($query);

		if ($result) {
			$alert = "<span class = 'success'>Delete Comment Successfully</span>";
			return $alert;
		} else {
			$alert = "<span class = 'error'>Delete Comment Not Successfully</span>";
			return $alert;
		}
	}

	public function get_user()
	{
		$query = "SELECT users.*,tbl_role.name FROM users
			INNER JOIN tbl_role ON users.role_id = tbl_role.id
			order by users.id asc";
		$result = $this->db->select($query);
		return $result;
	}

	public function get_user_by_id($userid)
	{
		$userid = mysqli_real_escape_string($this->db->link, $userid);

		$query = "SELECT * FROM users WHERE id = '$userid'";
		$result = mysqli_query($this->db->link, $query);

		if ($result && mysqli_num_rows($result) > 0) {
			$userDetails = mysqli_fetch_assoc($result);
			return $userDetails;
		} else {
			return false; // User not found
		}
	}

	public function del_user_normal($deluserid)
	{
		$deluserid = mysqli_real_escape_string($this->db->link, $deluserid);

		// Fetch user details before deletion
		$userDetails = $this->get_user_by_id($deluserid);

		if ($userDetails) {
			$role_id = $userDetails['role_id'];

			if ($role_id == 1) {
				$alert = "<span class='error'>Cannot delete admin accounts.</span>";
				return $alert;
			}

			$query = "DELETE FROM users WHERE id = '$deluserid' AND role_id = '2'";
			$result = $this->db->delete($query);

			if ($result) {
				$alert = "<span class='success'>Delete User Normal Successfully</span>";
				return $alert;
			} else {
				$alert = "<span class='error'>Delete User Normal Not Successfully</span>";
				return $alert;
			}
		} else {
			$alert = "<span class='error'>User not found.</span>";
			return $alert;
		}
	}

	public function getuserbyId($id){
        $query = "SELECT * FROM users where id = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

	public function update_userID($data, $id, $currentUserRole)
		{
			$name = mysqli_real_escape_string($this->db->link, $data['name']);
			$dob = mysqli_real_escape_string($this->db->link, $data['dob']);
			$address = mysqli_real_escape_string($this->db->link, $data['address']);
			$role = mysqli_real_escape_string($this->db->link, $data['role']);

			if ($name == "" || $dob == "" || $address == "" || $role == "") {
				$alert = "<span class ='error'>Fields must not be empty</span>";
				return $alert;
			} else {
				// Check if the current user has the right to update the user with the specified ID
				$currentUserRole = mysqli_real_escape_string($this->db->link, $currentUserRole);
				
				// If the current user is an admin, or they are updating their own profile
				if ($currentUserRole == 2) {
					$query = "UPDATE users SET fullname='$name', dob='$dob', address='$address', role_id='$role' WHERE id='$id'";
					$result = $this->db->update($query);

					if ($result) {
						$alert = "<span class ='success'>Update Profile Customers Successfully</span>";
						return $alert;
					} else {
						$alert = "<span class ='error'>Update Profile Customers Not Successfully</span>";
						return $alert;
					}
				} else {
					$alert = "<span class ='error'>Không đủ quyền cập nhật hồ sơ người dùng.</span>";
					return $alert;
				}
			}
		}



	public function insert_User($name, $email, $dob, $address, $password, $role)
	{
		$password = md5($password);

		// Check if any of the required fields is empty
		if (empty($name) || empty($email) || empty($dob) || empty($address) || empty($password) || empty($role)) {
			$alert = "<span class='error'>Please fill in all required fields.</span>";
			return $alert;
		}

		$check_email = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$result_check = $this->db->select($check_email);

		if ($result_check) {
			$alert = "<span class='error'>Email already exists.</span>";
			return $alert;
		} else {
			$captcha = rand(10000, 99999);
			$query = "INSERT INTO users VALUES (NULL, '$email', '$name', '$dob', '$password', '$role', '$address', 1, '$captcha')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert = "<span class ='success'>Insert Member Successfully</span>";
				return $alert;
			} else {
				$alert = "<span class ='error'>Insert Member Not Successfully</span>";
				return $alert;
			}
		}
	}

}
?>