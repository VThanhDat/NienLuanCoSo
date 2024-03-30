<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath . '/../lib/database.php');

    $db = new Database();

    if(isset($_POST['index'])){
        $index = $_POST['index'];
        $product_id = $_POST['product_id'];
        $user_id = $_POST['user_id'];

        // Check if the user has already rated the product
        $check_query = "SELECT * FROM tbl_rating WHERE product_id='$product_id' AND user_id='$user_id'";
        $check_result = $db->select($check_query);

        if ($check_result && $check_result->num_rows > 0) {
            // User has already rated, update the existing rating
            $update_query = "UPDATE tbl_rating SET rating='$index' WHERE product_id='$product_id' AND user_id='$user_id'";
            $update_result = $db->update($update_query);

            if($update_result){
                echo 'updated';
            } else {
                echo 'update_failed';
            }
        } else {
            // User hasn't rated yet, insert a new rating
            $insert_query = "INSERT INTO tbl_rating(product_id, user_id, rating) VALUES ('$product_id','$user_id','$index')";
            $insert_result = $db->insert($insert_query);

            if($insert_result){
                echo 'done';
            } else {
                echo 'insert_failed';
            }
        }
    }
?>
