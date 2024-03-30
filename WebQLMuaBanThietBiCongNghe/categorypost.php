<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
if (!isset($_GET['idpost']) || $_GET['idpost'] == NULL) {
    echo "<script>window.location = '404.php'</script>";
} else {
    $id = $_GET['idpost'];
}

// if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
//     $updateProduct = $pd->update_product($_POST, $_FILES, $id);
// }
?>


<div class="main">
    <div class="content">
        <?php
        $name_cat = $pos->getcatpostbyId($id);
        if ($name_cat) {
            while ($result_name = $name_cat->fetch_assoc()) {
        ?>
                <div class="content_top">
                    <div class="heading">
                        <h3>Danh mục tin tức: <?php echo $result_name['title'] ?></h3>
                    </div>
                    <div class="clear"></div>
                </div>
        <?php
            }
        }
        ?>
        <div class="section group">
            <?php
            $postbycat = $pos->get_post_by_cat($id);
            // Check if the query executed successfully
            if ($postbycat) {
                while ($result = $postbycat->fetch_assoc()) {
            ?>
                    <div class="grid_1_of_4 images_1_of_4">
                        <a href="details_blog.php?blogid=<?php echo $result['id'] ?>"><img src="admin/uploads/<?php echo $result['image'] ?>" width="150px" alt="" /></a>
                        <h2><?php echo $result['title_blog'] ?></h2>
                        <p><?php echo $fm->textShorten($result['desc_blog'], 150); ?></p>
                        <div class="button"><span><a href="details_blog.php?blogid=<?php echo $result['id'] ?>" class="details">Chi tiết tin tức</a></span></div>
                    </div>
            <?php
                }
            } else {
                echo 'Tin tức không có sẵn';
            }
            ?>
        </div>
        <center style="padding: 10px;">
            <div class="pagination">
                <?php 
                // Check if the query executed successfully
                if ($postbycat !== false) {
					$blog_cate_post_all = $pos->get_all_blog_by_cat($id);
                    $post_count = mysqli_num_rows($blog_cate_post_all);
                    $post_button = ceil($post_count / 8);
                    $current_page = isset($_GET['pagecatepost']) ? $_GET['pagecatepost'] : 1;
                    
                    $visible_pages = 2; // Number of visible pages
                    $half_visible = floor($visible_pages / 2);
                    
                    if ($current_page > 1) {
                        echo '<a style="margin:0 5px" href="categorypost.php?idpost='.$id.'&pagecatepost='.($current_page-1).'">Previous</a>';
                    }

                    for ($i = 1; $i <= $post_button; $i++) {
                        if ($i == 1 || $i == $post_button || ($i >= $current_page - $half_visible && $i <= $current_page + $half_visible)) {
                            echo '<a style="margin:0 5px" '.($i == $current_page ? 'class="active"' : '').' href="categorypost.php?idpost='.$id.'&pagecatepost='.$i.'">'.$i.'</a>';
                        } elseif ($i == 2 || $i == $post_button - 1) {
                            echo '<span>...</span>';
                        }
                    }

                    if ($current_page < $post_button) {
                        echo '<a style="margin:0 5px" href="categorypost.php?idpost='.$id.'&pagecatepost='.($current_page+1).'">Next</a>';
                    }
                }
                ?>
            </div>
        </center>
    </div>
</div>

<?php
include 'inc/footer.php';
?>