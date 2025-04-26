<?php
    session_start();

    include "../Connect.php";

    $farmer_id = $_GET['farmer_id'];

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

    $sql2 = mysqli_query($con, "select * from users where id='$farmer_id'");
    $row2 = mysqli_fetch_array($sql2);

    $farmerName        = $row2['name'];
    $farmerEmail       = $row2['email'];
    $farmerPhone       = $row2['phone'];
    $farmerTotalRate   = $row2['total_rate'];
    $farmerImage       = $row2['image'];
    $farmerDescription = $row2['description'];

    if (isset($_POST['Submit'])) {

        $feedback  = $_POST['feedback'];
        $farmer_id = $_POST['farmer_id'];
        $H_ID      = $_POST['H_ID'];

        $stmt = $con->prepare("INSERT INTO seller_feedbacks (consumer_id, seller_id, feedback) VALUES (?, ?, ?) ");

        $stmt->bind_param("iis", $H_ID, $farmer_id, $feedback);

        if ($stmt->execute()) {

            echo "<script language='JavaScript'>
              alert ('Thank you !');
         </script>";

            echo "<script language='JavaScript'>
        document.location='./Farmer.php?farmer_id={$farmer_id}';
           </script>";

        }

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
                            <a href="index.php" class="nav-item nav-link ">Home</a>
                            <a href="Products.php" class="nav-item nav-link ">Products</a>
                            <a href="Farmers.php" class="nav-item nav-link active">Farmers</a>
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


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6"><?php echo $farmerName ?> Detail</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="./Farmers.php">Farmers</a></li>
                <li class="breadcrumb-item active text-white"><?php echo $farmerName ?> Detail</li>
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
                                        <img src="../Farmer_Dashboard/<?php echo $farmerImage ?>" class="img-fluid rounded" alt="Image" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3"><?php echo $farmerName ?></h4>
                                <p class="mb-3">Phone:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo $farmerPhone ?></p>
                                <h5 class="fw-bold mb-3"></h5>
                                <div class="d-flex mb-4">
                                <?php for ($ii = 1; $ii < $farmerTotalRate; $ii++) {?>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <?php }?>

                                </div>
                                <p class="mb-4"><?php echo $farmerDescription ?></p>

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
                                        <p><?php echo $farmerDescription ?> </p>

                                    </div>
                                    <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">




                                    <?php
                                        $sql33 = mysqli_query($con, "SELECT * from seller_feedbacks WHERE seller_id = '$farmer_id'");

                                        while ($row33 = mysqli_fetch_array($sql33)) {

                                            $buyer_id   = $row33['consumer_id'];
                                            $feedback   = $row33['feedback'];
                                            $created_at = $row33['created_at'];

                                            $sql44 = mysqli_query($con, "SELECT * from users WHERE id = '$buyer_id'");
                                            $row44 = mysqli_fetch_array($sql44);

                                            $buyer_name = $row44['name'];
                                            $buyer_image = $row44['image'];

                                            $sql55 = mysqli_query($con, "SELECT * from seller_rate WHERE consumer_id = '$buyer_id' AND seller_id = '$farmer_id'");
                                            $row55 = mysqli_fetch_array($sql55);

                                            $buyer_seller_rate = $row55['rate'];

                                        ?>

                                        <div class="d-flex">
                                            <img src="<?php echo $buyer_image?>" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                            <div class="">
                                                <p class="mb-2" style="font-size: 14px;"><?php echo $created_at ?></p>
                                                <div class="d-flex justify-content-between">
                                                    <h5><?php echo $buyer_name ?></h5>
                                                    <div class="d-flex mb-3">
                                                    <?php for ($iii = 1; $iii < $buyer_seller_rate; $iii++) {?>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <p><?php echo $feedback ?></p>
                                            </div>
                                        </div>
<?php }?>

                                    </div>

                                </div>
                            </div>
                            <form action="./Farmer.php?farmer_id=<?php echo $farmer_id ?>" method="POST">
                                <h4 class="mb-5 fw-bold">Leave a Reply</h4>
                                <div class="row g-4">

                                <input type="hidden" name="farmer_id" value="<?php echo $farmer_id ?>">
                                <input type="hidden" name="H_ID" value="<?php echo $H_ID ?>">

                                    <div class="col-lg-12">
                                        <div class="border-bottom rounded my-4">
                                            <textarea name="feedback" id="" class="form-control border-0" cols="30" rows="8" placeholder="Your Review *" spellcheck="false"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between py-3 mb-5">
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0 me-3"></p>
                                                <div class="d-flex align-items-center" style="font-size: 12px;">

                                                </div>
                                            </div>
                                             <button class="btn border border-secondary text-primary rounded-pill px-4 py-3" type="submit" name="Submit">Post Comment</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <h1 class="fw-bold mb-0"><?php echo $farmerName ?> products</h1>
                <div class="vesitable">
                    <div class="owl-carousel vegetable-carousel justify-content-center">



                    <?php
                        $sql55 = mysqli_query($con, "SELECT * from products WHERE active = 1 AND farmer_id = '$farmer_id'");


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
                            <div class="vesitable-img" style="height: 180px;">
                                <img src="../Farmer_Dashboard/<?php echo $product_image ?>" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $category_name ?></div>
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
