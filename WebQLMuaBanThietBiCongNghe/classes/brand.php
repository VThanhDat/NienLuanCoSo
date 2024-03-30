<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
?>

<?php
 class brand 
 {
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database(); 
        $this->fm = new Format();
    }

    public function insert_brand($brandName){

        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);

        if(empty($brandName)){
            $alert = "<span class = 'error'>Brand must be not empty</span>";
            return $alert;
        }else{

            // Check if the category already exists
            $existingQuery = "SELECT brandId FROM tbl_brand WHERE brandName = '$brandName'";
            $existingResult = $this->db->select($existingQuery);
    
            if ($existingResult) {
                $alert = "<span class='error'>Brand already exists.</span>";
                return $alert;
            }
    

            $query = "INSERT INTO tbl_brand(brandName) VALUES('$brandName')";
            $result = $this->db->insert($query);
            if($result){
                $alert = "<span class = 'success'>Insert Brand Successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class = 'error'>Insert Brand Not Successfully</span>";
                return $alert;
            }
        }
    }

    public function show_brand(){
        $query = "SELECT * FROM tbl_brand ORDER BY brandId DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getbrandbyId($id){
        $query = "SELECT * FROM tbl_brand where brandId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }
 
    public function update_brand($brandName, $id){
        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);
        $id = mysqli_real_escape_string($this->db->link, $id);

        if(empty($brandName)){
            $alert = "<span class = 'error'>Brand must be not empty</span>";
            return $alert;
        }else{

            $query = "UPDATE tbl_brand SET brandName='$brandName' WHERE brandId = '$id'";
            $result = $this->db->update($query);
            if($result){
                $alert = "<span class = 'success'>Update Brand Successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class = 'error'>Update Brand Not Successfully</span>";
                return $alert;
            }
        }
    }

    public function del_brand($id){
        $query = "DELETE FROM tbl_brand where brandId = '$id'";
        $result = $this->db->delete($query);
        if($result){
            $alert = "<span class = 'success'>Delete Brand Successfully</span>";
            return $alert;
        }
        else{
            $alert = "<span class = 'error'>Delete Brand Not Successfully</span>";
            return $alert;
        }
    }

    public function get_name_by_brand($id){
        $query = "SELECT tbl_product.*,tbl_brand.brandName,tbl_brand.brandId FROM tbl_product,tbl_brand
        WHERE tbl_product.brandId = tbl_brand.brandId AND tbl_product.brandId ='$id' LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_product_by_brand($id){
        $sp_tungtrang = 4;
        if(!isset($_GET['pagebrand'])){
            $trang = 1;
        }else{
            $trang = $_GET['pagebrand'];
        }
        $tung_trang = ($trang - 1) * 4;
        $query = "SELECT * FROM tbl_product WHERE brandId ='$id' LIMIT $tung_trang, $sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }
 }
 
?>