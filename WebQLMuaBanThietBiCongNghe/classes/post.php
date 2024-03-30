<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
?>

<?php
 class post 
 {
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_cate_post($catPostName,$catDesc, $catStatus){

        $catPostName = $this->fm->validation($catPostName);
        $catDesc = $this->fm->validation($catDesc);
        $catStatus = $this->fm->validation($catStatus);
        $catPostName= mysqli_real_escape_string($this->db->link, $catPostName);
        $catDesc= mysqli_real_escape_string($this->db->link, $catDesc);
        $catStatus= mysqli_real_escape_string($this->db->link, $catStatus);

        if(empty($catPostName) || empty($catDesc)){ 
            $alert = "<span class = 'error'>Category post must be not empty</span>";
            return $alert;
        }else{

            $existingQuery = "SELECT id_cate_post FROM tbl_category_post WHERE title = '$catPostName'";
            $existingResult = $this->db->select($existingQuery);
    
            if ($existingResult) {
                $alert = "<span class='error'>Category post already exists.</span>";
                return $alert;
            }

            $query = "INSERT INTO tbl_category_post(title,desc_post,status) VALUES('$catPostName','$catDesc','$catStatus')";
            $result = $this->db->insert($query);
            if($result){
                $alert = "<span class = 'success'>Insert Category Post Successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class = 'error'>Insert Category Post Not Successfully</span>";
                return $alert;
            }
        }
    }

    public function show_category_post(){
        $query = "SELECT * FROM tbl_category_post ORDER BY id_cate_post DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function del_category_post($id){
        $query = "DELETE FROM tbl_category_post where id_cate_post = '$id'";
        $result = $this->db->delete($query);
        if($result){
            $alert = "<span class = 'success'>Delete Category Post Successfully</span>";
            return $alert;
        }
        else{
            $alert = "<span class = 'error'>Delete Category Post Not Successfully</span>";
            return $alert;
        }
    }

    public function update_category_post($catPostName,$catDesc, $catStatus, $id){
        $catPostName = $this->fm->validation($catPostName);
        $catDesc = $this->fm->validation($catDesc);
        $catStatus = $this->fm->validation($catStatus);
        $catPostName= mysqli_real_escape_string($this->db->link, $catPostName);
        $catDesc= mysqli_real_escape_string($this->db->link, $catDesc);
        $catStatus= mysqli_real_escape_string($this->db->link, $catStatus);
        $id = mysqli_real_escape_string($this->db->link, $id);

        if(empty($catPostName) || empty($catDesc)){
            $alert = "<span class = 'error'>Category post must be not empty</span>";
            return $alert;
        }else{

            $query = "UPDATE tbl_category_post SET title='$catPostName', desc_post='$catDesc', status='$catStatus' WHERE id_cate_post = '$id'";
            $result = $this->db->update($query);
            if($result){
                $alert = "<span class = 'success'>Update Category Post Successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class = 'error'>Update Category Post Not Successfully</span>";
                return $alert;
            }

        }
    }

    
    public function getcatpostbyId($id){
        $query = "SELECT * FROM tbl_category_post where id_cate_post = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_post_by_cat($id){
        $sp_tungtrang = 6;
        if(!isset($_GET['pagecatepost'])){
            $trang = 1;
        }else{
            $trang = $_GET['pagecatepost'];
        }
        $tung_trang = ($trang - 1) * 6;

        $query = "SELECT tbl_blog.* FROM tbl_blog where id_cate_post = '$id' and status = '0' order by id desc LIMIT $tung_trang, $sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_blog_by_id($id){
        $query = "SELECT * FROM tbl_blog where id = '$id' and status = '0'";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function get_all_blog_by_cat($id){
        $query = "SELECT * FROM tbl_blog where id_cate_post = '$id' order by id";
        $result = $this->db->select($query);
        return $result;
    }

 }
?>