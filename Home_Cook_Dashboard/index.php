<?php
    session_start();

    include "../Connect.php";

    $H_ID = $_SESSION['H_Log'];

    if ($H_ID) {

        $sql1 = mysqli_query($con, "SELECT COUNT(id) AS cart_count FROM carts WHERE consumer_id = '$H_ID'");
        $row1 = mysqli_fetch_array($sql1);

        $cart_count = $row1['cart_count'];

        $productsSql = mysqli_query($con, "SELECT id FROM orders WHERE consumer_id = '$H_ID'");
        $productsIDs = [];

        while ($orderRow = mysqli_fetch_array($productsSql)) {

            $order_id = $orderRow['id'];

            $orderItemsSql = mysqli_query($con, "SELECT product_id FROM order_items WHERE order_id = '$order_id'");

            while ($itemRow = mysqli_fetch_array($orderItemsSql)) {

                $productsIDs[] = $itemRow['product_id'];

            }

        }

        $productsIDsValues = "'" . implode("','", $productsIDs) . "'";
        $categoriesIDs     = [];

        $productsSql = mysqli_query($con, "SELECT category_id FROM products WHERE id IN ($productsIDsValues)");

        while ($productRow = mysqli_fetch_array($productsSql)) {

            $categoriesIDs[] = $productRow['category_id'];

        }

        $categoriesIDsValues = "'" . implode("','", $categoriesIDs) . "'";

        $recommendationsProductsSql = mysqli_query($con, "SELECT products.id as product_id, products.name AS products_name, products.description AS products_description, products.image AS product_image, products.price, products.farmer_id, categories.name AS category_name
        FROM products
        INNER JOIN categories ON categories.id = products.category_id
        WHERE products.category_id IN ($categoriesIDsValues)");
        $products = [];

        while ($recommendationsProductRow = mysqli_fetch_array($recommendationsProductsSql)) {

            $products[] = $recommendationsProductRow;

        }

    } else {

        echo '<script language="JavaScript">
        document.location="../Home-Cook-Login.php";
       </script>';
    }

?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>EcoLacto</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">


    <link href="../assets/img/Logo.png" rel="icon" />
    <link href="../assets/img/Logo.png" rel="apple-touch-icon" />

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">


    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">123 Street, New York</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Email@Example.com</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="index.php" class="navbar-brand"><h1 class="text-primary display-6">EcoLacto</h1></a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <a href="Products.php" class="nav-item nav-link">Products</a>
                            <a href="Farmers.php" class="nav-item nav-link">Farmers</a>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                            <?php if ($H_ID) {?>
                                <a href="Orders.php" class="nav-item nav-link">Orders</a>
                                <a href="Meals.php" class="nav-item nav-link">Meals</a>
                            <?php }?>
<?php if (! $H_ID) {?>
                            <a href="../Home-Cook-Login.php" class="nav-item nav-link">Login</a>
                            <?php }?>
                        </div>
                        <?php if ($H_ID) {?>

<div class="d-flex m-3 me-0">
    <a href="./Cart.php" class="position-relative me-4 my-auto">
        <i class="fa fa-shopping-bag fa-2x"></i>
        <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $cart_count ?></span>
    </a>
    <a href="./Profile.php" class="my-auto">
        <i class="fas fa-user fa-2x"></i>
    </a>
    <a href="./Meals-Orders.php" class="my-auto ms-2">
        <i class="fa fa-plus fa-2x"></i>
    </a>
</div>

<?php }?>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->





        <!-- Hero Start -->
        <div class="container-fluid py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
                        <h4 class="mb-3 secondry-text">Welcome to EcoLacto</h4>
                        <h1 class="mb-5 display-3 text-primary">XXXX XXXX XXXX</h1>
                        <div class="position-relative mx-auto">
                            <!-- <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number" placeholder="Search">
                            <button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">Submit Now</button> -->
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">

                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->


        <!-- Featurs Section Start -->
        <div class="container-fluid featurs py-5">
            <div class="container py-5">
                <div class="row g-4">

                    <div class="col-md-6 col-lg-4">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle background-sec mb-5 mx-auto">
                                <i class="fas fa-user-shield fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Security Payment</h5>
                                <p class="mb-0">100% security payment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle background-sec mb-5 mx-auto">
                                <i class="fas fa-exchange-alt fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>30 Day Return</h5>
                                <p class="mb-0">30 day money guarantee</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle background-sec mb-5 mx-auto">
                                <i class="fa fa-phone-alt fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>24/7 Support</h5>
                                <p class="mb-0">Support every time fast</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Featurs Section End -->











        <?php if (! empty($products)) {?>


<div class="container-fluid vesitable py-5">
    <div class="container py-5">
        <h1 class="mb-0">Recommended Products</h1>
        <div class="owl-carousel vegetable-carousel justify-content-center">









        <?php foreach ($products as $product) {

            ?>





            <div class="border border-primary rounded position-relative vesitable-item">
            <div class="vesitable-img">
                <img src="../Farmer_Dashboard/<?php echo $product['product_image'] ?>" class="img-fluid w-100 rounded-top" alt="">
            </div>
            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $product['category_name'] ?></div>
            <div class="p-4 rounded-bottom">
                <h4><?php echo $product['products_name'] ?></h4>
                <p><?php echo substr($product['products_description'], 0, 10) . '....' ?></p>
                <div class="d-flex justify-content-between flex-lg-wrap">
                    <p class="text-dark fs-5 fw-bold mb-0"><?php echo $product['price'] ?> JODs</p>
                    <a href="./Product.php?product_id=<?php echo $product['product_id'] ?>" class="btn border border-secondary rounded-pill px-3 text-primary"> View Product</a>
                </div>
            </div>
        </div>









        <?php }?>
















        </div>
    </div>
</div>


<?php }?>


        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <h1>Products</h1>
                        </div>
                        <div class="col-lg-8 text-end">
                            <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                        <span class="text-dark" style="width: 130px;">All Products</span>
                                    </a>
                                </li>
                            <?php
                                $sql1 = mysqli_query($con, "SELECT * from categories WHERE active = 1");

                                while ($row1 = mysqli_fetch_array($sql1)) {

                                    $category_id   = $row1['id'];
                                    $category_name = $row1['name'];

                                ?>
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-<?php echo $category_id + 1 ?>">
                                        <span class="text-dark" style="width: 130px;"><?php echo $category_name ?></span>
                                    </a>
                                </li>
<?php }?>

                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">

                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                    <?php
                                        $sql1 = mysqli_query($con, "SELECT * from products WHERE active = 1");

                                        while ($row1 = mysqli_fetch_array($sql1)) {

                                            $product_id          = $row1['id'];
                                            $seller_id           = $row1['seller_id'];
                                            $category_id         = $row1['category_id'];
                                            $product_name        = $row1['name'];
                                            $product_description = $row1['description'];
                                            $product_image       = $row1['image'];
                                            $product_price       = $row1['price'];
                                            $active              = $row1['active'];
                                            $created_at          = $row1['created_at'];

                                            $sellerSql = mysqli_query($con, "SELECT * FROM users WHERE id = '$seller_id'");
                                            $sellerRow = mysqli_fetch_array($sellerSql);

                                            $sellerName = $sellerRow['name'];

                                            $categorySql = mysqli_query($con, "SELECT * FROM categories WHERE id = '$category_id'");
                                            $categoryRow = mysqli_fetch_array($categorySql);

                                            $categoryName = $categoryRow['name'];

                                        ?>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item position-relative">

                                                <div class="fruite-img">
                                                    <img src="../Farmer_Dashboard/<?php echo $product_image ?>" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white background-sec px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo $categoryName ?></div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><?php echo $product_name ?></h4>
                                                    <p><?php echo substr($product_description, 0, 10) . '.....' ?></p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0"><?php echo $product_price ?> JODs</p>
                                                        <a href="./Product.php?product_id=<?php echo $product_id ?>" class="btn border border-secondary rounded-pill px-3 text-primary">View Product</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                      <?php }?>

                                    </div>
                                </div>
                            </div>
                        </div>




                        <?php
                            $categoryTabSql = mysqli_query($con, "SELECT * from categories WHERE active = 1");

                            while ($categoryTabRow = mysqli_fetch_array($categoryTabSql)) {

                                $category_id_tab   = $categoryTabRow['id'];
                                $category_name_tab = $categoryTabRow['name'];

                            ?>

                        <div id="tab-<?php echo $category_id_tab + 1 ?>" class="tab-pane fade show p-0">

                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                    <?php
                                        $productTabSql = mysqli_query($con, "SELECT * from products WHERE active = 1 AND category_id = '$category_id_tab'");

                                            while ($productTabRow = mysqli_fetch_array($productTabSql)) {

                                                $product_id              = $productTabRow['id'];
                                                $seller_id_tab           = $productTabRow['seller_id'];
                                                $product_name_tab        = $productTabRow['name'];
                                                $product_description_tab = $productTabRow['description'];
                                                $product_image_tab       = $productTabRow['image'];
                                                $product_price_tab       = $productTabRow['price'];
                                                $active_tab              = $productTabRow['active'];
                                                $created_at_tab          = $productTabRow['created_at'];

                                                $sellerSqlTab = mysqli_query($con, "SELECT * FROM users WHERE id = '$seller_id'");
                                                $sellerRowTab = mysqli_fetch_array($sellerSqlTab);

                                                $sellerNameTab = $sellerRowTab['name'];

                                            ?>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">

                                                <div class="fruite-img">
                                                    <img src="../Farmer_Dashboard/<?php echo $product_image_tab ?>" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo $category_name_tab ?></div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><?php echo $product_name_tab ?></h4>
                                                    <p><?php echo substr($product_description_tab, 0, 10) . '.....' ?></p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0"><?php echo $product_price_tab ?> JODs</p>
                                                        <a href="./Product.php?product_id=<?php echo $product_id ?>" class="btn border border-secondary rounded-pill px-3 text-primary"> View Product</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<?php }?>

                                    </div>
                                </div>
                            </div>
                        </div>
<?php }?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->





        <!-- Vesitable Shop Start-->
        <div class="container-fluid vesitable py-5">
            <div class="container py-5">
                <h1 class="mb-0">Best Farmers</h1>
                <div class="owl-carousel vegetable-carousel justify-content-center">

                <?php
                    $sql1 = mysqli_query($con, "SELECT * from users WHERE user_type_id = 2 AND total_rate >= 3.5 AND active = 1");

                    while ($row1 = mysqli_fetch_array($sql1)) {

                        $farmer_id          = $row1['id'];
                        $farmer_name        = $row1['name'];
                        $farmer_email       = $row1['email'];
                        $farmer_description = $row1['description'];
                        $farmer_image       = $row1['image'];

                    ?>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="../Farmer_Dashboard/<?php echo $farmer_image ?>" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"></div>
                        <div class="p-4 rounded-bottom">
                            <h4><?php echo $farmer_name ?></h4>
                            <p><?php echo substr($farmer_description, 0, 10) . '....' ?></p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0"></p>
                                <a href="./Farmer.php?farmer_id=<?php echo $farmer_id ?>" class="btn border border-secondary rounded-pill px-3 text-primary"> View Farmer</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    }?>


                </div>
            </div>
        </div>
        <!-- Vesitable Shop End -->


        <!-- Banner Section Start-->
        <div class="container-fluid banner bg-secondary my-5">
            <div class="container py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="py-4">
                            <h1 class="display-3 text-white">Ffef</h1>
                            <p class="fw-normal display-3 text-dark mb-4">in Our Store</p>
                            <p class="mb-4 text-dark">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic words etc.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <img src="img/knmein.png" class="img-fluid w-100 rounded" alt="">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner Section End -->


        <!-- Fact Start -->
        <div class="container-fluid py-5">
            <div class="container">
                <div class="bg-light p-5 rounded">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users secondry-text"></i>
                                <h4>satisfied customers</h4>
                                <h1>1963</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users secondry-text"></i>
                                <h4>quality of service</h4>
                                <h1>99%</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users secondry-text"></i>
                                <h4>quality certificates</h4>
                                <h1>33</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users secondry-text"></i>
                                <h4>Available Products</h4>
                                <h1>789</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fact Start -->





        <!-- Footer Start -->
         <?php require './Footer.php'; ?>
        <!-- Footer End -->




        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>



    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

</html>