<?php
include 'inc/header.php';
include 'inc/slider.php';
?>
<?php
if (!isset($_GET['blogid']) || $_GET['blogid'] == NULL) {
    echo "<script>window.location = '404.php'</script>";
} else {
    $id = $_GET['blogid'];
}

// if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
//     $updateProduct = $pd->update_product($_POST, $_FILES, $id);
// }
?>


<div class="main">
    <div class="content">
        <?php
        $blog_detail = $pos->get_blog_by_id($id);
        if ($blog_detail) {
            while ($result = $blog_detail->fetch_assoc()) {
        ?>
                <div class="content_top">
                    <div class="heading">
                        <h3><?php echo $result['title_blog'] ?></h3>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="section group">
                    <div class="col-md-12">
                        <h2><?php echo $result['title_blog'] ?></h2>
                        <p><?php echo $result['content']; ?></p>
                    </div>
            <?php
            }
        }
            ?>
                </div>
    </div>
</div>

<?php
include 'inc/footer.php';
?>