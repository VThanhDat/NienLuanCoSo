    <?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class product
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_product($data, $files)
    {
        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $product_quantity = mysqli_real_escape_string($this->db->link, $data['product_quantity']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);

        //Kiễm tra hình ảnh và lấy hình ảnh cho vào folder upload
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($productName == '' || $product_quantity == '' || $brand == '' || $category == '' || $product_desc == '' || $price == '' || $type == '' || $file_name == '') {
            $alert = "<span class='error'>Fields must not be empty</span>";
            return $alert;
        } else {
            // Check if a product with the same name and price already exists   
            $existingQuery = "SELECT * FROM tbl_product WHERE productName = '$productName' AND price = '$price'";
            $existingResult = $this->db->select($existingQuery);

            if ($existingResult) {
                $alert = "<span class='error'>Product already exists.</span>";
                return $alert;
            }

            // If the product doesn't exist, proceed with the insertion
            move_uploaded_file($file_temp, $uploaded_image);

            $query = "INSERT INTO tbl_product(productName,product_quantity, brandId, catId, product_desc, price, type, image) 
                VALUES('$productName','$product_quantity','$brand','$category','$product_desc','$price','$type','$unique_image')";
            $result = $this->db->insert($query);
            if ($result) {
                $alert = "<span class='success'>Insert Product Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Insert Product Not Successfully</span>";
                return $alert;
            }
        }
    }


    public function show_product()
    {
        $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
        FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
                         INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
        ORDER BY tbl_product.productId DESC";
        // $query = "SELECT * FROM tbl_product ORDER BY productId DESC";

        $result = $this->db->select($query);
        return $result;
    }

    public function getproductbyId($id)
    {
        $query = "SELECT * FROM tbl_product where productId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    

    public function update_product($data, $files, $id)
    {

        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $product_quantity = mysqli_real_escape_string($this->db->link, $data['product_quantity']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);

        //Kiễm tra hình ảnh và lấy hình ảnh cho vào folder upload
        $permited = array('jpg', 'jpeg', 'png', 'gif');

        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($productName == '' || $product_quantity == '' || $brand == '' || $category == '' || $product_desc == '' || $price == '' || $type == '') {
            $alert = "<span class = 'error'>Fields must be not empty</span>";
            return $alert;
        } else {
            if (!empty($file_name)) {
                // Nếu người dùng chọn ảnh
                if ($file_size > 40480) {
                    $alert = "<span class='success'>Image Size should be less then 40MB!</span>";
                    return $alert;
                } else if (in_array($file_ext, $permited) === false) {
                    $alert = "<span class='success'>You can upload only:-" . implode(', ', $permited) . "</span>";
                    return $alert;
                }
                move_uploaded_file($file_temp, $uploaded_image);
                $query = "UPDATE tbl_product SET 
                productName='$productName',
                product_quantity='$product_quantity',
                brandId='$brand',
                catId='$category',
                type='$type',
                price='$price',
                image='$unique_image',
                product_desc='$product_desc'
                
                WHERE productId = '$id'";
            } else {
                // Nếu người dùng không chọn ảnh
                $query = "UPDATE tbl_product SET 
                productName='$productName',
                product_quantity='$product_quantity',
                brandId='$brand',
                catId='$category',
                type='$type',
                price='$price',
                product_desc='$product_desc'
                
                WHERE productId = '$id'";
            }
        }
        $result = $this->db->update($query);
        if ($result) {
            $alert = "<span class = 'success'>Update Product Successfully</span>";
            return $alert;
        } else {
            $alert = "<span class = 'error'>Update Product Not Successfully</span>";
            return $alert;
        }
    }

    public function del_product($id)
    {
        $query = "DELETE FROM tbl_product where productId = '$id'";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class = 'success'>Delete Product Successfully</span>";
            return $alert;
        } else {
            $alert = "<span class = 'error'>Delete Product Not Successfully</span>";
            return $alert;
        }
    }
    //END BACKEND

    public function getproduct_feathered()
    {
        $sp_tungtrang = 4;
        if(!isset($_GET['trang'])){
            $trang = 1;
        }else{
            $trang = $_GET['trang'];
        }
        $tung_trang = ($trang - 1)* 4;
        $query = "SELECT * FROM tbl_product where type = '1' order by productId desc LIMIT $tung_trang, $sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }


    public function getproduct_new()
    {   
        $sp_tungtrang = 4;
        if(!isset($_GET['trang'])){
            $trang = 1;
        }else{
            $trang = $_GET['trang'];
        }
        $tung_trang = ($trang - 1)* 4;
        $query = "SELECT * FROM tbl_product order by productId desc LIMIT $tung_trang, $sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function get_all_product()
    {
        $query = "SELECT * FROM tbl_product order by productId";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_all_product_by_cat($id)
    {
        $query = "SELECT * FROM tbl_product where catId='$id' order by productId";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_all_product_by_brand($id)
    {
        $query = "SELECT * FROM tbl_product where brandId='$id' order by productId";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_details($id)
    {
        $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
        FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
                         INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
                         where tbl_product.productId = '$id'
                         ";

        $result = $this->db->select($query);
        return $result;
    }

    public function getLastestDell()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId = '7' order by productId desc LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }

    public function getLastestOppo()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId = '5' order by productId desc LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }

    public function getLastestHuawei()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId = '4' order by productId desc LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }

    public function getLastestSamsung()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId = '2' order by productId desc LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }

    public function insertCompare($productid, $user_id)
    {

        $productid = mysqli_real_escape_string($this->db->link, $productid);
        $user_id = mysqli_real_escape_string($this->db->link, $user_id);

        $query_compare  = "SELECT * FROM tbl_compare WHERE productId = '$productid' AND user_id = '$user_id'";
        $check_compare =  $this->db->select($query_compare);
        if ($check_compare) {
            $msg = "<span class = 'error'>Product Already Added to Compare</span>";
            return $msg;
        } else {

            $query = "SELECT * FROM tbl_product WHERE productId = '$productid'";
            $result = $this->db->select($query)->fetch_assoc();

            $productName = $result['productName'];
            $price = $result['price'];
            $image = $result['image'];

            $query_insert = "INSERT INTO tbl_compare(productId,price,image,user_id,productName) 
        VALUES('$productid','$price','$image','$user_id','$productName')";

            $insert_compare = $this->db->insert($query_insert);

            if ($insert_compare) {
                $alert = "<span class = 'success'>Added Compare Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class = 'error'>Added Compare Not Successfully</span>";
                return $alert;
            }
        }
    }

    public function get_compare($user_id){
        $query = "SELECT * FROM tbl_compare WHERE user_id = '$user_id' order by id desc";
        $result = $this->db->select($query);
        return $result;
    }

    public function insertWishlist($productid, $user_id)
    {
        $productid = mysqli_real_escape_string($this->db->link, $productid);
        $user_id = mysqli_real_escape_string($this->db->link, $user_id);

        $query_wishlist  = "SELECT * FROM tbl_wishlist WHERE productId = '$productid' AND user_id = '$user_id'";
        $check_wishlist =  $this->db->select($query_wishlist);
        if ($check_wishlist) {
            $msg = "<span class = 'error'>Product Already Added to Wishlist</span>";
            return $msg;
        } else {

            $query = "SELECT * FROM tbl_product WHERE productId = '$productid'";
            $result = $this->db->select($query)->fetch_assoc();

            $productName = $result['productName'];
            $price = $result['price'];
            $image = $result['image'];

            $query_insert = "INSERT INTO tbl_wishlist(productId,price,image,user_id,productName) 
        VALUES('$productid','$price','$image','$user_id','$productName')";

            $insert_wishlist = $this->db->insert($query_insert);

            if ($insert_wishlist) {
                $alert = "<span class = 'success'>Added Wishlist Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class = 'error'>Added Wishlist Not Successfully</span>";
                return $alert;
            }
        }
    }

    public function get_wishlist($user_id){
        $query = "SELECT * FROM tbl_wishlist WHERE user_id = '$user_id' order by id desc";
        $result = $this->db->select($query);
        return $result;
    }

    public function del_wlist($proid,$user_id){
        $query = "DELETE FROM tbl_wishlist where productId = '$proid' AND user_id ='$user_id'";
        $result = $this->db->delete($query);
        return $result;
    }

    public function insert_slider($data, $file){
        $sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);
        
         //Kiễm tra hình ảnh và lấy hình ảnh cho vào folder upload
        $permited = array('jpg', 'jpeg', 'png', 'gif');

        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($sliderName == '' || $type == '') {
            $alert = "<span class = 'error'>Fields must be not empty</span>";
            return $alert;
        } else {
            if (!empty($file_name)) {
                // Nếu người dùng chọn ảnh
                if ($file_size > 40480) {
                    $alert = "<span class='success'>Image Size should be less then 40MB!</span>";
                    return $alert;
                } else if (in_array($file_ext, $permited) === false) {
                    $alert = "<span class='success'>You can upload only:-" . implode(', ', $permited) . "</span>";
                    return $alert;
                }
                move_uploaded_file($file_temp, $uploaded_image);
                $query_insert = "INSERT INTO tbl_slider(sliderName,type,slider_image) 
                VALUES('$sliderName','$type','$unique_image')"; 

                $result= $this->db->insert($query_insert);

                if ($result) {
                    $alert = "<span class = 'success'>Slider Added Successfully</span>";
                    return $alert;
                } else {
                    $alert = "<span class = 'error'>Slider Added Not Successfully</span>";
                    return $alert;
                }
            } 
        }
    }

    public function show_slider()
    {
        $query = "SELECT * FROM tbl_slider where type = '1' ORDER BY slider_id DESC";

        $result = $this->db->select($query);
        return $result;
    }

    public function show_slider_list()
    {
        $query = "SELECT * FROM tbl_slider ORDER BY slider_id DESC";

        $result = $this->db->select($query);
        return $result;
    }

    public function update_type_slider($id, $type){
        $type = mysqli_real_escape_string($this->db->link, $type);

        $query = "UPDATE tbl_slider SET type = '$type' where slider_id = '$id'";
       
        $result = $this->db->update($query);
        return $result;
    }

    public function del_slider($id){
        $query = "DELETE FROM tbl_slider where slider_id = '$id'";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class = 'success'>Delete Slider Successfully</span>";
            return $alert;
        } else {
            $alert = "<span class = 'error'>Delete Slider Not Successfully</span>";
            return $alert;
        }
    }

    public function search_product($tukhoa){
        $tukhoa = $this->fm->validation($tukhoa);
        $query = "SELECT * FROM tbl_product WHERE productName LIKE '%$tukhoa%'";
        $result = $this->db->select($query);
        return $result;
    }

    public function getProductsByBrand($selectedBrand){
        $query = "SELECT * FROM tbl_product WHERE brandId ='$selectedBrand'";
        $result = $this->db->select($query);
        return $result;
    }

    public function getProductsByBrandName($brandName){
        $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
        FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
                         INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
        WHERE tbl_brand.brandName like '%$brandName%'";
        $result = $this->db->select($query);
        return $result;
    }


    public function show_all_product()
    {
        $sp_tungtrang = 8;
        if(!isset($_GET['pageproducts'])){
            $trang = 1;
        }else{
            $trang = $_GET['pageproducts'];
        }
        $tung_trang = ($trang - 1) * 8;
        $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
        FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
                         INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
        ORDER BY tbl_product.productId DESC LIMIT $tung_trang, $sp_tungtrang";
        // $query = "SELECT * FROM tbl_product ORDER BY productId DESC";

        $result = $this->db->select($query);
        return $result;
    }

    public function get_star($id){
        $query = "SELECT * FROM tbl_rating where product_id='$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function avg_star($id){
        $query = "SELECT * FROM tbl_rating WHERE product_id='$id'";
        $result = $this->db->select($query);
    
        $totalStars = 0;
        $totalRatings = 0;
    
        while ($row = $result->fetch_assoc()) {
            $totalStars += $row['rating'];
            $totalRatings++;
        }
    
        $averageRating = ($totalRatings > 0) ? ($totalStars / $totalRatings) : 0;
    
        return $averageRating;
    }
    public function getMinProductPrice()
    {
        $query = "SELECT MIN(price) AS min_price FROM tbl_product";
        $result = $this->db->select($query);
        
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['min_price'];
        } else {
            return 0; // Default value if no result is found
        }
    }
    
    public function getMaxProductPrice()
    {
        $query = "SELECT MAX(price) AS max_price FROM tbl_product";
        $result = $this->db->select($query);
        
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['max_price'];
        } else {
            return 0; // Default value if no result is found
        }
    }

    public function getProductsByPriceRange($minPrice, $maxPrice)
    {
        $sp_tungtrang = 8;
        if (!isset($_GET['pageproducts'])) {
            $trang = 1;
        } else {
            $trang = $_GET['pageproducts'];
        }
        $tung_trang = ($trang - 1) * 8;

        $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
                FROM tbl_product
                INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
                INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
                WHERE tbl_product.price BETWEEN $minPrice AND $maxPrice
                ORDER BY tbl_product.productId DESC 
                LIMIT $tung_trang, $sp_tungtrang";

        $result = $this->db->select($query);

        return $result; 
    }
    
    public function getProductsByBrandIdPriceRange($price_from, $price_to, $brand_id) {
        $sp_tungtrang = 4;
        if(!isset($_GET['pagebrand'])){
            $trang = 1;
        }else{
            $trang = $_GET['pagebrand'];
        }
        $tung_trang = ($trang - 1) * 4;
        $query = "SELECT * FROM tbl_product WHERE brandId = $brand_id AND price BETWEEN $price_from AND $price_to LIMIT $tung_trang, $sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }

    public function getProductsByCatIdPriceRange($price_from, $price_to, $cat_id) {
        $sp_tungtrang = 4;
        if(!isset($_GET['pagecat'])){
            $trang = 1;
        }else{
            $trang = $_GET['pagecat'];
        }
        $tung_trang = ($trang - 1) * 4;
        $query = "SELECT * FROM tbl_product WHERE catId = $cat_id AND price BETWEEN $price_from AND $price_to LIMIT $tung_trang, $sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }

    public function countOrdersWithPaymentStatusTwo($id)
    {
        // Truy vấn để đếm số lượng đơn hàng có trạng thái thanh toán là 2 và có mã đơn hàng tương ứng với một sản phẩm cụ thể
        $query = "SELECT SUM(tbl_order.quantity) AS total_quantity_orders 
                  FROM tbl_placed 
                  INNER JOIN tbl_order ON tbl_placed.order_code = tbl_order.order_code 
                  INNER JOIN tbl_product ON tbl_product.productId = tbl_order.productId 
                  WHERE tbl_placed.status = '2' 
                  AND tbl_product.productId = '$id'";
    
        // Thực thi truy vấn
        $result = $this->db->select($query);
        
        if ($result) {
            // Lấy kết quả từ truy vấn
            $row = $result->fetch_assoc();
            $totalOrders = $row['total_quantity_orders'];
    
            // Cập nhật số lượng sản phẩm đã bán và số lượng sản phẩm còn lại
            $query_update = "UPDATE tbl_product 
                            SET product_soldcount = '$totalOrders',
                                product_remain = (product_quantity - product_soldcount)
                            WHERE productId = '$id'";
            $updateResult = $this->db->update($query_update);
    
            if ($updateResult) {
                // Trả về số lượng sản phẩm đã bán
                return $totalOrders;
            } else {
                // Trả về 0 nếu có lỗi khi cập nhật
                return 0;
            }
        } else {
            // Trả về 0 nếu không có kết quả từ truy vấn
            return 0;
        }
    }
}
?>