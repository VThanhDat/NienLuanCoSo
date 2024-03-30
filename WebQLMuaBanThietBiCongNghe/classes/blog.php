<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
?>

<?php
 class blog
 {
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_blog($data, $files)
    {
        $title_blog = mysqli_real_escape_string($this->db->link, $data['title_blog']);
        $category_post = mysqli_real_escape_string($this->db->link, $data['category_post']);
        $desc = mysqli_real_escape_string($this->db->link, $data['desc']);
        $content = mysqli_real_escape_string($this->db->link, $data['content']);
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

        if ($title_blog == '' || $category_post == '' || $desc == '' || $content == '' || $type == '' || $file_name == '') {
            $alert = "<span class='error'>Fields must not be empty</span>";
            return $alert;
        } else {
            // Check if a product with the same name and price already exists   
            $existingQuery = "SELECT * FROM tbl_blog WHERE title_blog = '$title_blog'";
            $existingResult = $this->db->select($existingQuery);

            if ($existingResult) {
                $alert = "<span class='error'>Blog already exists.</span>";
                return $alert;
            }

            // If the product doesn't exist, proceed with the insertion
            move_uploaded_file($file_temp, $uploaded_image);

            $query = "INSERT INTO tbl_blog(title_blog, desc_blog, content, id_cate_post, status, image) 
                VALUES('$title_blog','$desc','$content','$category_post','$type','$unique_image')";
            $result = $this->db->insert($query);
            if ($result) {
                $alert = "<span class='success'>Insert Blog Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Insert Blog Not Successfully</span>";
                return $alert;
            }
        }
    }

    public function show_blog()
    {
        $query = "SELECT tbl_blog.*, tbl_category_post.title
        FROM tbl_blog INNER JOIN tbl_category_post ON tbl_blog.id_cate_post = tbl_category_post.id_cate_post
        ORDER BY tbl_blog.id DESC";

        $result = $this->db->select($query);
        return $result;
    }

    public function del_blog($id){
        $query = "DELETE FROM tbl_blog where id = '$id'";
        $result = $this->db->delete($query);
        if($result){
            $alert = "<span class = 'success'>Delete Blog Successfully</span>";
            return $alert;
        }
        else{
            $alert = "<span class = 'error'>Delete Blog Not Successfully</span>";
            return $alert;
        }
    }

    public function update_blog($data, $files, $id)
    {
        $title_blog = mysqli_real_escape_string($this->db->link, $data['title']);
        $category_post = mysqli_real_escape_string($this->db->link, $data['category_post']);
        $desc = mysqli_real_escape_string($this->db->link, $data['desc']);
        $content = mysqli_real_escape_string($this->db->link, $data['content']);
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

        if ($title_blog == '' || $category_post == '' || $desc == '' || $content == '' || $type == '') {
            $alert = "<span class='error'>Fields must not be empty</span>";
            return $alert;
        } else {
            if (!empty($file_name)) {
                // Nếu người dùng chọn ảnh
                if ($file_size > 2000000) {
                    $alert = "<span class='success'>Image Size should be less then 2GB!</span>";
                    return $alert;
                } else if (in_array($file_ext, $permited) === false) {
                    $alert = "<span class='success'>You can upload only:-" . implode(', ', $permited) . "</span>";
                    return $alert;
                }
                move_uploaded_file($file_temp, $uploaded_image);
                $query = "UPDATE tbl_blog SET 
                title_blog='$title_blog',
                desc_blog='$desc',
                status='$type',
                id_cate_post='$category_post',
                image='$unique_image',
                content='$content'
                
                WHERE id = '$id'";
            } else {
                // Nếu người dùng không chọn ảnh
                $query = "UPDATE tbl_blog SET 
                title_blog='$title_blog',
                desc_blog='$desc',
                status='$type',
                id_cate_post='$category_post',
                content='$content'
                
                WHERE id = '$id'";
            }
        }
        $result = $this->db->update($query);
        if ($result) {
            $alert = "<span class = 'success'>Update Post Successfully</span>";
            return $alert;
        } else {
            $alert = "<span class = 'error'>Update Post Not Successfully</span>";
            return $alert;
        }
    }
    public function getblogbyId($id){
        $query = "SELECT * FROM tbl_blog where id = '$id'";
        $result = $this->db->select($query);
        return $result;
    }
    
 }
?>