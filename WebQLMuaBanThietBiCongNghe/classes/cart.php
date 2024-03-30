<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class cart
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function add_to_cart($quantity, $product_stock,$id)
    {

        $quantity = $this->fm->validation($quantity);
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);

        $product_stock = $this->fm->validation($product_stock);
        $product_stock = mysqli_real_escape_string($this->db->link, $product_stock);

        $id = mysqli_real_escape_string($this->db->link, $id);
        $sId = session_id();

        $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
        $result = $this->db->select($query)->fetch_assoc();

        $image = $result['image'];
        $price = $result['price'];
        $productName = $result['productName'];

        $query_cart  = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId = '$sId'";
        $check_cart =  $this->db->select($query_cart);
        if($quantity <= $product_stock){ // nếu số lượng đặt nhỏ hơn số lượng có trong kho
            if ($check_cart) {
                $msg = "<span class = 'error'>Product Already Added</span>";
                return $msg;
            } else {
                $query_insert = "INSERT INTO tbl_cart(stock,productId,quantity,sId,image,price,productName) 
                VALUES('$product_stock','$id','$quantity','$sId','$image','$price','$productName')";
    
                $insert_cart = $this->db->insert($query_insert);
    
                if ($insert_cart) {
                    echo "<script type='text/javascript'>window.location.href = 'cart.php'</script>";
                } else {
                    header('Location:404.php');
                }
            }
        }else{
            $msg = "<span class = 'error'>Số lượng đặt phải nhỏ hơn số lượng tồn kho.</span>";
            return $msg;
        }
    }

    public function get_product_cart()
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $result = $this->db->select($query);

        return $result;
    }

    public function get_product_cart_checkout()
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId' and status = 1";
        $result = $this->db->select($query);

        return $result;
    }

    public function update_quantity_cart($stock,$quantity, $cartId)
    {
        $stock = mysqli_real_escape_string($this->db->link, $stock);
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        $cartId = mysqli_real_escape_string($this->db->link, $cartId);

        if($stock >= $quantity){ // kho > quantity
            $query = "UPDATE tbl_cart SET 
                    quantity='$quantity'
                    WHERE cartId = '$cartId'";
    
            $result = $this->db->update($query);
    
            if ($result) {
                echo "<script type='text/javascript'>window.location.href = 'cart.php'</script>";
            } else {
                $alert = "<span class = 'error'>Update quantity Not Successfully</span>";
                return $alert;
            }
        }else{
            $alert = "<span class = 'error'>Số lượng tồn kho không đủ.</span>";
            return $alert;
        }

    }

    public function del_product_cart($cartid)
    {
        $cartid = mysqli_real_escape_string($this->db->link, $cartid);
        $query = "DELETE FROM tbl_cart WHERE cartId = '$cartid'";
        $result = $this->db->delete($query);
        if ($result) {
            echo "<script type='text/javascript'>window.location.href = 'cart.php'</script>";
        } else {
            $alert = "<span class = 'error'>Delete product cart Not Successfully</span>";
            return $alert;
        }
    }

    public function check_cart()
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $result = $this->db->select($query);

        return $result;
    }

    public function check_order($user_Id)
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_order WHERE user_id = '$user_Id'";
        $result = $this->db->select($query);

        return $result;
    }

    public function del_all_data_cart()
    {
        $sId = session_id();
        $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
        $result = $this->db->delete($query);

        return $result;
    }

    public function insertOrder($user_Id, $paymentMethod1)
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId' AND tbl_cart.status = 1"; // select products from the cart
        $get_product = $this->db->select($query);
        $order_code = rand(0000, 9999);
    
        // insert into tbl_placed
        $query_placed = "INSERT INTO tbl_placed(user_id, order_code, status, date_created) VALUES('$user_Id', '$order_code', '0', CURDATE())";
        $insert_placed = $this->db->insert($query_placed);
    
        if ($get_product) {
    
            while ($result = $get_product->fetch_assoc()) {
                $productId = $result['productId'];
                $productName = $result['productName'];
                $quantity = $result['quantity'];
                $price = $result['price'];
    
                $image = $result['image'];
                $user_id = $user_Id;
                $paymentMethod = $paymentMethod1;
    
                $query_insert = "INSERT INTO tbl_order(order_code, productId, productName, user_id, quantity, price, image, paymentMethod) 
                VALUES('$order_code', '$productId', '$productName', '$user_id', '$quantity', '$price', '$image', '$paymentMethod')";
    
                $insert_order = $this->db->insert($query_insert);
            }
        }
    }
    

    public function getAmountPrice($user_Id)
    {
        $query = "SELECT price,quantity FROM tbl_order WHERE user_id ='$user_Id'";
        $get_price = $this->db->select($query);

        return $get_price;
    }

    public function get_cart_ordered($user_Id)
    {
        $ordered_tungtrang = 8;
        if(!isset($_GET['pageorder'])){
            $trang = 1;
        }else{
            $trang = $_GET['pageorder'];
        }
        $tung_trang = ($trang - 1) * 8;
        $query = "SELECT * FROM tbl_order WHERE user_id ='$user_Id' order by user_id DESC LIMIT $tung_trang, $ordered_tungtrang";
        $get_cart_ordered = $this->db->select($query);

        return $get_cart_ordered;

   
        // $query = "SELECT * FROM tbl_product ORDER BY productId DESC";

        $result = $this->db->select($query);
        return $result;
    }

    public function get_cart_ordered_pagination($user_Id, $items_per_page, $offset)
    {
        $query = "SELECT * FROM tbl_order WHERE user_id ='$user_Id' ORDER BY user_id DESC LIMIT $offset, $items_per_page";
        $get_cart_ordered = $this->db->select($query);

        return $get_cart_ordered;
    }


    public function get_all_ordered()
    {
        $query = "SELECT * FROM tbl_order order by id";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_inbox_cart()
    {
        $query = "SELECT * FROM tbl_placed,users,tbl_order where tbl_placed.user_id = users.id and tbl_order.order_code = tbl_placed.order_code ORDER BY date_created";
        $get_inbox_cart = $this->db->select($query);

        return $get_inbox_cart;
    }

    public function get_inbox_cart_history($user_id)
    {
        $query = "SELECT * FROM tbl_placed,users where tbl_placed.user_id = users.id AND tbl_placed.user_id ='$user_id' ORDER BY date_created";
        $get_inbox_cart = $this->db->select($query);

        return $get_inbox_cart;
    }

    public function shifted($order_code)
    {
        $order_code = mysqli_real_escape_string($this->db->link, $order_code);
        $query = "UPDATE tbl_placed SET 
                    status='1'
                    WHERE order_code = '$order_code'";

        $result = $this->db->update($query);

        if ($result) {
            echo "<script type='text/javascript'>window.location.href = 'inbox.php'</script>";
            // return $alert;
        } else {
            $alert = "<span class = 'error'>Update Order Not Successfully</span>";
            return $alert;
        }
    }

    public function confirm_received($order_code)
    {
        $order_code = mysqli_real_escape_string($this->db->link, $order_code);
    
        // Get order details from tbl_order
        $query_order_details = "SELECT SUM(quantity) AS totalQuantity, SUM(price*quantity + ((price*quantity)*0.1)) AS totalAmount FROM tbl_order WHERE order_code = '$order_code'";
        $result_order_details = $this->db->select($query_order_details);
    
        if ($result_order_details->num_rows > 0) {
            $row = $result_order_details->fetch_assoc();
            $totalQuantity = $row['totalQuantity'];
            $totalAmount = $row['totalAmount'];
    
            // Update or insert into tbl_thongke
            $check_date = "SELECT * FROM tbl_thongke WHERE date_thongke = CURDATE()";
            $result_date = $this->db->select($check_date);
    
            if ($result_date->num_rows > 0) {
                // If an entry exists, update it
                $query_update_thongke = "UPDATE tbl_thongke SET soluong = soluong + $totalQuantity, doanhthu = doanhthu + $totalAmount WHERE date_thongke = CURDATE()";
                $update_thongke = $this->db->update($query_update_thongke);
            } else {
                // If no entry exists, insert a new one
                $query_insert_thongke = "INSERT INTO tbl_thongke (soluong, doanhthu, date_thongke) VALUES ($totalQuantity, $totalAmount, CURDATE())";
                $insert_thongke = $this->db->insert($query_insert_thongke);
            }
    
            // Update order status to 2
            $query_update_order_status = "UPDATE tbl_placed SET status='2' WHERE order_code = '$order_code'";
            $result_update_order_status = $this->db->update($query_update_order_status);
    
            if ($result_update_order_status) {
                echo "<script type='text/javascript'>window.location.href = 'history_order.php'</script>";
            } else {
                $alert = "<span class='error'>Update Order Status Not Successfully</span>";
                return $alert;
            }
        } else {
            $alert = "<span class='error'>Failed to fetch order details</span>";
            return $alert;
        }
    }
    

    public function del_shifted($order_code)
    {
        $order_code = mysqli_real_escape_string($this->db->link, $order_code);

        $query = "DELETE FROM tbl_placed WHERE order_code = '$order_code'";

        $result = $this->db->delete($query);

        if ($result) {
            $alert = "<span class = 'success'>Delete Order Successfully</span>";
            return $alert;
        } else {
            $alert = "<span class = 'error'>Delete Order Not Successfully</span>";
            return $alert;
        }
    }

    public function shifted_confirm($id, $time, $price)
    {
        $id = mysqli_real_escape_string($this->db->link, $id);
        $time = mysqli_real_escape_string($this->db->link, $time);
        $price = mysqli_real_escape_string($this->db->link, $price);

        $query = "UPDATE tbl_order SET 
                    status='2'
                    WHERE user_id = '$id' AND date_order ='$time' AND price='$price'";

        $result = $this->db->update($query);
        return $result;
    }

    public function del_compare($user_id)
    {
        $query = "DELETE FROM tbl_compare WHERE user_id = '$user_id'";
        $result = $this->db->delete($query);

        return $result;
    }
}

?>