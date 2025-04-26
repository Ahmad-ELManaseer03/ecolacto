<?php
    session_start();

    include "../Connect.php";

    $H_ID = $_SESSION['H_Log'];

    if ($H_ID) {

        $sql1 = mysqli_query($con, "SELECT COUNT(id) AS cart_count FROM carts WHERE consumer_id = '$H_ID'");
        $row1 = mysqli_fetch_array($sql1);

        $cart_count = $row1['cart_count'];
    } else {

        echo '<script language="JavaScript">
        document.location="../Home-Cook-Login.php";
       </script>';
    }

    $product_id = $_GET['product_id'];

    $sql2 = mysqli_query($con, "select * from products where id='$product_id'");
    $row2 = mysqli_fetch_array($sql2);

    $productName         = $row2['name'];
    $productImage        = $row2['image'];
    $productDescription  = $row2['description'];
    $productPrice        = $row2['price'];
    $productqty          = $row2['qty'];
    $product_category_id = $row2['category_id'];

    $sql3 = mysqli_query($con, "select * from categories where id='$product_category_id'");
    $row3 = mysqli_fetch_array($sql3);

    $categoryName = $row3['name'];

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
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
                            <a href="index.php" class="nav-item nav-link ">Home</a>
                            <a href="Products.php" class="nav-item nav-link active">Products</a>
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
        <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;" id="cartCount"><?php echo $cart_count ?></span>
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


        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <form class="w-75 mx-auto d-flex" action="./Products.php" method="POST">
                                <input type="search" class="form-control p-3" name="product_name" placeholder="product name" aria-describedby="search-icon-1">
                                <button type="submit" id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6"><?php echo $productName ?> Detail</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="./Products.php">Products</a></li>
                <li class="breadcrumb-item active text-white"><?php echo $productName ?> Detail</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Single Product Start -->
        <div class="container-fluid py-5 mt-5">
            <div class="container py-5">
                <div class="row g-4 mb-5">
                    <div class="col-lg-8 col-xl-9">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border rounded">
                                    <a href="#">
                                        <img src="../Farmer_Dashboard/<?php echo $productImage ?>" class="img-fluid rounded" alt="Image"  style="width: 100%;">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3"><?php echo $productName ?></h4>
                                <p class="mb-3">Category: <?php echo $categoryName ?></p>
                                <h5 class="fw-bold mb-3"><?php echo $productPrice ?> JODs</h5>
                                <div class="d-flex mb-4">
                                <?php for ($ii = 1; $ii < $productTotalRate; $ii++) {?>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <?php }?>
                                </div>
                                <p class="mb-4"><?php echo $productDescription ?></p>


                                    <div class="mb-3">


                                    </div>

                                    <div class="input-group quantity mb-5" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border" >
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0" id="qty" value="1" max="<?php echo $productqty ?>">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <?php if($H_ID) {?>

                                        <button class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary" id="addToCart"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
                                    <script>

                                        document.getElementById('addToCart').addEventListener('click',function(e) {

                                            const qty = Number(document.getElementById('qty')?.value)


                                            if(qty > 0) {

                                                const productId =<?php echo json_encode($product_id) ?>;
                                                
                                                $.ajax({
                                                url: `./AddToCart.php?product_id=${productId}&qty=${qty}`,
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(data) {
console.log(data);

                                                    if(!data.error) {
                                                        document.getElementById('cartCount').innerHTML = data.cart_count
                                                        alert('Product Added To Cart')
                                                    } else {
                                                        alert('Something Went wrong')
                                                    }
                                                },
                                                error: function(x, y, z) {
                                                console.log(x, y, z);
                                                
                                            }
                                            })
                                            
                                            }


                                        })

                                    </script>
                                    <?php }?>




                            </div>
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                            aria-controls="nav-about" aria-selected="true">Description</button>
                                        <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                            aria-controls="nav-mission" aria-selected="false">Reviews</button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                        <p><?php echo $productDescription ?> </p>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <div class="row g-4 fruite">
                            <div class="col-lg-12">
                                <div class="input-group w-100 mx-auto d-flex mb-4">
              
                                </div>
                                <div class="mb-4">
                                    <h4>Categories</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                    <?php
                                        $sql1 = mysqli_query($con, "SELECT * from categories WHERE active = 1");

                                        while ($row1 = mysqli_fetch_array($sql1)) {

                                            $category_id   = $row1['id'];
                                            $category_name = $row1['name'];

                                            $sql2 = mysqli_query($con, "SELECT COUNT(id) AS products_count from products WHERE active = 1 AND category_id = '$category_id'");
                                            $row2 = mysqli_fetch_array($sql2);

                                            $products_count = $row2['products_count'];

                                        ?>
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="./Products.php?category_id=<?php echo $category_id ?>"><?php echo $category_name ?></a>
                                                <span>(<?php echo $products_count ?>)</span>
                                            </div>
                                        </li>
                                <?php }?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <h4 class="mb-4">Featured products</h4>

                                <?php
                                    $sql223 = mysqli_query($con, "SELECT * from products WHERE active = 1");

                                    while ($row223 = mysqli_fetch_array($sql223)) {

                                        $product_id         = $row223['id'];
                                        $product_name       = $row223['name'];
                                        $product_image      = $row223['image'];
                                        $product_total_rate = $row223['total_rate'];
                                        $product_price      = $row223['price'];

                                    ?>

                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img src="../Farmer_Dashboard/<?php echo $product_image ?>" class="img-fluid rounded" alt="Image">
                                    </div>
                                    <div>
                                        <a href="./Product.php?product_id=<?php echo $product_id ?>"><h6 class="mb-2"><?php echo $product_name ?></h6></a>
                                        <div class="d-flex mb-2">

                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2"><?php echo $product_price ?> JODs</h5>
                                            <h5 class="text-danger text-decoration-line-through"></h5>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>

                            </div>

                        </div>
                    </div>
                </div>
                <h1 class="fw-bold mb-0">Related products</h1>

                <div class="vesitable">
                    <div class="owl-carousel vegetable-carousel justify-content-center">


                    <?php
                        $sql55 = mysqli_query($con, "SELECT * from products WHERE active = 1 AND category_id = '$product_category_id'");

                        while ($row55 = mysqli_fetch_array($sql55)) {

                            $product_id          = $row55['id'];
                            $category_id         = $row55['category_id'];
                            $product_name        = $row55['name'];
                            $product_image       = $row55['image'];
                            $product_price       = $row55['price'];
                            $product_description = $row55['description'];

                            $sql66 = mysqli_query($con, "SELECT * from categories WHERE id = '$category_id'");
                            $row66 = mysqli_fetch_array($sql66);

                            $category_name = $row66['name'];

                        ?>


                        <div class="border border-primary rounded position-relative vesitable-item" id="<?php echo $product_id ?>">
                            <div class="vesitable-img" style="
    height: 180px;
">
                                <img src="../Farmer_Dashboard/<?php echo $product_image ?>" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white background-sec px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $category_name ?></div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4><?php echo $product_name ?></h4>
                                <p><?php echo substr($product_description, 0, 10) ?></p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold"><?php echo $product_price ?> JODs</p>
                                    <a href="./Product.php?product_id=<?php echo $product_id ?>" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary">View Product</a>
                                </div>
                            </div>
                        </div>


<?php }?>



                    </div>
                </div>
            </div>
        </div>
        <!-- Single Product End -->


        <!-- Footer Start -->
                            <?php require './Footer.php'?>
        <!-- Footer End -->




        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>


    </body>

</html>
