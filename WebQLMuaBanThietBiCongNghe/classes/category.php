<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
?>

<?php
 class category 
 {
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_category($catName) {
        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
    
        if (empty($catName)) {
            $alert = "<span class='error'>Category must not be empty</span>";
            return $alert;
        } else {
            // Check if the category already exists
            $existingQuery = "SELECT catId FROM tbl_category WHERE catName = '$catName'";
            $existingResult = $this->db->select($existingQuery);
    
            if ($existingResult) {
                $alert = "<span class='error'>Category already exists.</span>";
                return $alert;
            }
    
            // If the category doesn't exist, proceed with the insertion
            $insertQuery = "INSERT INTO tbl_category(catName) VALUES('$catName')";
            $insertResult = $this->db->insert($insertQuery);
    
            if ($insertResult) {
                $alert = "<span class='success'>Insert Category Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Insert Category Not Successfully</span>";
                return $alert;
            }
        }
    }
    

    public function show_category(){
        $query = "SELECT * FROM tbl_category ORDER BY catId DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getcatbyId($id){
        $query = "SELECT * FROM tbl_category where catId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }
 
    public function update_category($catName, $id){
        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
        $id = mysqli_real_escape_string($this->db->link, $id);

        if(empty($catName)){
            $alert = "<span class = 'error'>Category must be not empty</span>";
            return $alert;
        }else{

            $query = "UPDATE tbl_category SET catName='$catName' WHERE catId = '$id'";
            $result = $this->db->update($query);
            if($result){
                $alert = "<span class = 'success'>Update Category Successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class = 'error'>Update Category Not Successfully</span>";
                return $alert;
            }
        }
    }

    public function del_category($id){
        $query = "DELETE FROM tbl_category where catId = '$id'";
        $result = $this->db->delete($query);
        if($result){
            $alert = "<span class = 'success'>Delete Category Successfully</span>";
            return $alert;
        }
        else{
            $alert = "<span class = 'error'>Delete Category Not Successfully</span>";
            return $alert;
        }
    }

    public function show_category_fontend(){
        $query = "SELECT * FROM tbl_category ORDER BY catId DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_product_by_cat($id){
        $sp_tungtrang = 4;
        if(!isset($_GET['pagecate'])){
            $trang = 1;
        }else{
            $trang = $_GET['pagecate'];
        }
        $tung_trang = ($trang - 1) * 4;
        $query = "SELECT * FROM tbl_product WHERE catId ='$id' order by catId desc LIMIT $tung_trang, $sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_name_by_cat($id){
        $query = "SELECT tbl_product.*,tbl_category.catName,tbl_category.catId FROM tbl_product,tbl_category 
        WHERE tbl_product.catId = tbl_category.catId AND tbl_product.catId ='$id' LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }

    public function getAllCategory() {
        $query = "SELECT * FROM tbl_category";
        $result = $this->db->select($query);
        
        // Assuming $this->db->select() is a method to execute the query and fetch results
        return $result;
    }

 }
 
?>