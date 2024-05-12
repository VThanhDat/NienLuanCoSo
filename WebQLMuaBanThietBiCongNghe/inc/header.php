<?php
include 'lib/session.php';
Session::init();
?>
<?php
include_once 'lib/database.php';
include_once 'helpers/format.php';

spl_autoload_register(function ($className) {
    include_once "classes/" . $className . ".php";
});

$db = new Database();
$fm = new Format();
$ct = new cart();
$us = new user();
$br = new brand();
$cat = new category();
$user = new user();
$product = new product();
$pos = new post();

?>

<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: max-age=2592000");
?>
<!DOCTYPE HTML>

<head>
    <title>Store Website</title>
    <meta http-equiv="Content-Type" content="text/php; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/menu.css" rel="stylesheet" type="text/css" media="all" />
    <script src="js/jquerymain.js"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <script type="text/javascript" src="js/nav-hover.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function($) {
            $('#dc_mega-menu-orange').dcMegaMenu({
                rowItems: '4',
                speed: 'fast',
                effect: 'fade'
            });
        });
    </script>
</head>

<body>
    <div class="wrap">
        <div class="header_top">
            <div class="logo">
                <a href="index.php"><img src="images/logo.png" alt="" /></a>
            </div>
            <div class="search_box">
                <form action="search.php" method="post">
                    <input type="text" name="tukhoa" placeholder="Tìm kiếm sản phẩm">
                    <input type="submit" name="search_product" value="Tìm kiếm">
                </form>
            </div>
            <div class="header_top_right">
                <div class="shopping_cart">
                    <div class="cart">
                        <a href="#" title="View my shopping cart" rel="nofollow">
                            <span class="cart_title">Cart</span>
                            <span class="no_product">
                                <?php
                                $check_cart = $ct->check_cart();
                                if ($check_cart) {
                                    $sum = Session::get("sum");
                                    $qty = Session::get("qty");
                                    echo  $fm->format_currency($sum) . ' đ' . '-' . 'Qty:' . $qty;
                                } else {
                                    echo 'Trống';
                                }
                                ?>
                            </span>
                        </a>
                    </div>
                </div>
                <?php
                if (isset($_GET['user_id'])) {
                    $user_id = $_GET['user_id'];
                    $delCart = $ct->del_all_data_cart();
                    $delCompare = $ct->del_compare($user_id);
                    Session::destroy();
                }
                ?>
                <div class="login">
                    <?php
                    $login_check = Session::get('user');
                    if ($login_check == false) {
                        echo '<a href="login.php">Login</a></div>';
                    } else
                        echo '<a href="?user_id=' . Session::get('userId') . '"><i class="fa-solid fa-right-to-bracket"></i></a></div>';
                    ?>
                    <div class="login">
                        <?php
                        $login_check = Session::get('user');
                        if ($login_check == false) {
                            echo '<a href="register.php">Register</a></div>';
                        } else {
                            echo '<a href="profile.php"><i class="fa-solid fa-user"></i></a></div>';
                        }
                        ?>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                
                <div class="topnav" id="myTopnav">
                    <a href="index.php">Trang chủ</a>
                    <a href="products.php">Sản phẩm</a>
                    <div class="dropdown">
                        <button class="dropbtn">Danh mục sản phẩm <i class="fa fa-caret-down"></i></button>
                        <div class="dropdown-content">
                            <?php
                                $cate = $cat->show_category();
                                if ($cate) {
                                    while ($result_new = $cate->fetch_assoc()) {
                                        ?>
                                        <a href="productbycat.php?catid=<?php echo $result_new['catId']; ?>"><?php echo $result_new['catName']; ?></a>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                    </div> 
                    
                    <div class="dropdown">
                        <button class="dropbtn">Thương hiệu <i class="fa fa-caret-down"></i></button>
                        <div class="dropdown-content">
                                <?php
                                $brand = $br->show_brand();
                                if ($brand) {
                                    while ($result_new = $brand->fetch_assoc()) {
                                        ?>
                                        <a href="topbrands.php?brandid=<?php echo $result_new['brandId']; ?>"><?php echo $result_new['brandName']; ?></a>
                                        <?php
                                    }
                                }
                                ?>
                        </div>
                    </div> 

                    <div class="dropdown">
                        <button class="dropbtn">Tin tức <i class="fa fa-caret-down"></i></button>
                        <div class="dropdown-content">
                                 <?php
                                $post_show = $pos->show_category_post();
                                if ($post_show) {
                                    while ($result_new = $post_show->fetch_assoc()) {

                                ?>
                                            <a href="categorypost.php?idpost=<?php echo $result_new['id_cate_post'] ?>"><?php echo $result_new['title'] ?></a>
                                <?php
                                    }
                                }
                                ?>
                        </div>
                    </div> 
                    <a href="cart.php">Giỏ hàng</a>
                    <?php
                        $login_check = Session::get('user');
                        if ($login_check) {
                            echo '<a href="compare.php">So sánh</a>';
                            echo '<a href="wishlist.php">Yêu thích</a>';
                            echo '<a href="history_order.php">Đã đặt hàng</a>';
                        }
                        ?>
                    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
                    </div>

                    <div style="padding-left:16px">
                </div>
