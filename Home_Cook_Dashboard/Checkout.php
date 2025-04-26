<?php
    session_start();

    include "../Connect.php";

    $H_ID = $_SESSION['H_Log'];

    if ($H_ID) {

        $sql1 = mysqli_query($con, "SELECT COUNT(id) AS cart_count FROM carts WHERE consumer_id = '$H_ID'");
        $row1 = mysqli_fetch_array($sql1);

        $cart_count = $row1['cart_count'];

        if (isset($_POST['Submit'])) {

            $buyer_id = $_POST['H_ID'];

            $cart = [];

            $cartSql = mysqli_query($con, "SELECT * from carts WHERE consumer_id = '$buyer_id'");

            $totalPrice = 0;

            while ($cartRow = mysqli_fetch_array($cartSql)) {

                $product_id = $cartRow['product_id'];
                $qty = $cartRow['qty'];

                $productSql = mysqli_query($con, "SELECT farmer_id, price from products WHERE id = '$product_id'");
                $productRow = mysqli_fetch_array($productSql);

                $farmer_id = $productRow['farmer_id'];
                $price = $productRow['price'];

                $totalPrice += ($price * $qty);

                $cart[] = [
                    'cart_id'    => $cartRow['id'],
                    'product_id' => $cartRow['product_id'],
                    'farmer_id'  => $farmer_id,
                    'price'      => $price,
                    'qty'        => $cartRow['qty'],
                ];

            }

            foreach ($cart as $item) {

                $cart_id    = $item['cart_id'];
                $farmer_id  = $item['farmer_id'];
                $product_id = $item['product_id'];
                $qty        = $item['qty'];

                $stmt = $con->prepare("INSERT INTO orders (consumer_id, total_price) VALUES (?, ?) ");

                $stmt->bind_param("id", $buyer_id, $totalPrice);

                if ($stmt->execute()) {

                    $order_id = $stmt->insert_id;

                    $orderItemStmt = $con->prepare("INSERT INTO order_items (order_id, seller_id, product_id, quantity) VALUES (?, ?, ?, ?) ");

                    $orderItemStmt->bind_param("iiii", $order_id, $farmer_id, $product_id, $qty);

                    if ($orderItemStmt->execute()) {

                        $productStmt = $con->prepare("SELECT qty AS product_qty FROM products WHERE id = ?");
                        $productStmt->bind_param("i", $product_id);

                        $productStmt->execute();

                        $productStmt->store_result();

                        if ($productStmt->num_rows > 0) {

                            $productStmt->bind_result($product_qty);
                            $productStmt->fetch();

                            $newQty = $product_qty - $item['qty'];
                            $active = $newQty == 0 ? 0 : 1;

                            $updateProductStmt = $con->prepare("UPDATE products SET qty = ?, active = ? WHERE id = ?");

                            $updateProductStmt->bind_param("iii", $newQty, $active, $product_id);

                            if ($updateProductStmt->execute()) {

                                $DeleteFromCartStmt = $con->prepare("DELETE FROM carts WHERE id = ?");

                                $DeleteFromCartStmt->bind_param("i", $cart_id);
                                $DeleteFromCartStmt->execute();

                            }

                        }
                    }
                }
            }

            echo "<script language='JavaScript'>
            alert ('Thank you for dealing with EcoLacto, Your Order Has Been Placed !');
       </script>";

            echo "<script language='JavaScript'>
      document.location='./Orders.php';
         </script>";

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
                            <a href="index.php" class="nav-item nav-link ">Home</a>
                            <a href="Products.php" class="nav-item nav-link ">Products</a>
                            <a href="Farmers.php" class="nav-item nav-link ">Farmers</a>
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
            <h1 class="text-center text-white display-6">Checkout</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                <li class="breadcrumb-item active text-white">Checkout</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Checkout Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h1 class="mb-4">Billing details</h1>
                <form action="./Checkout.php" method="POST">


                <input type="hidden" name="H_ID" value="<?php echo $H_ID ?>" id="">
                    <div class="row g-5">

                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Products</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    <?php
                                        $sql33 = mysqli_query($con, "SELECT * from carts WHERE consumer_id = '$H_ID'");

                                        $totalPrice = 0;

                                        while ($row33 = mysqli_fetch_array($sql33)) {

                                            $cart_id    = $row33['id'];
                                            $product_id = $row33['product_id'];
                                            $qty        = $row33['qty'];

                                            $sql55 = mysqli_query($con, "SELECT name, image, price, qty from products WHERE id = '$product_id'");
                                            $row55 = mysqli_fetch_array($sql55);

                                            $product_name  = $row55['name'];
                                            $product_image = $row55['image'];
                                            $product_price = $row55['price'];
                                            $product_qty   = $row55['qty'];

                                            $totalPrice += ($product_price * $qty);

                                        ?>




                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center mt-2">
                                                    <img src="../Farmer_Dashboard/<?php echo $product_image ?>" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                                </div>
                                            </th>
                                            <td class="py-5"><?php echo $product_name ?></td>
                                            <td class="py-5"><?php echo $product_price ?> JODs</td>
                                            <td class="py-5"><?php echo $qty ?></td>
                                            <td class="py-5"><?php echo $product_price * $qty ?> JODs</td>
                                        </tr>





                                        <?php }?>


                                        <tr>
                                            <th scope="row">
                                            </th>
                                            <td class="py-5"></td>
                                            <td class="py-5"></td>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark py-3">Subtotal</p>
                                            </td>
                                            <td class="py-5">
                                                <div class="py-3 border-bottom border-top">
                                                    <p class="mb-0 text-dark"><?php echo $totalPrice ?> JODs</p>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">
                                            </th>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                            </td>
                                            <td class="py-5"></td>
                                            <td class="py-5"></td>
                                            <td class="py-5">
                                                <div class="py-3 border-bottom border-top">
                                                    <p class="mb-0 text-dark"><?php echo $totalPrice + 2 ?> JODs</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="checkbox" class="form-check-input bg-primary border-0" id="Transfer-1" name="Transfer" value="Transfer">
                                        <label class="form-check-label" for="Transfer-1">Direct Bank Transfer</label>
                                    </div>
                                    <p class="text-start text-dark">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p>
                                </div>
                            </div>

                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="checkbox" class="form-check-input bg-primary border-0" id="Delivery-1" name="Delivery" value="Delivery">
                                        <label class="form-check-label" for="Delivery-1">Cash On Delivery</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary" name="Submit">Place Order</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Checkout Page End -->

        <?php require './Footer.php'?>



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