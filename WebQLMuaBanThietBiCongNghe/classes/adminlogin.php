<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/session.php');
Session::checkLogin();
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');

class AdminLogin
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function login_admin($email, $password)
    {
        $email = $this->fm->validation($email);
        $password = $this->fm->validation($password);

        $email = mysqli_real_escape_string($this->db->link, $email);
        $password = mysqli_real_escape_string($this->db->link, $password);

        if (empty($email) || empty($password)) {
            $alert = "Email and password must not be empty";
            return $alert;
        } else {
            $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND role_id = 1 LIMIT 1";
            $result = $this->db->select($query);

            if ($result != false) {
                $value = $result->fetch_assoc();
                Session::set('adminlogin', true);
                Session::set('adminId', $value['id']);
                Session::set('adminEmail', $value['email']);
                Session::set('adminFullname', $value['fullname']);
                header('Location:index.php');
            } else {
                $alert = "Email and password do not match";
                return $alert;
            }
        }
    }
}
?>
