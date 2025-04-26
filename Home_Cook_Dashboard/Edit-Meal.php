<?php
    session_start();

    include "../Connect.php";

    $H_ID    = $_SESSION['H_Log'];
    $meal_id = $_GET['meal_id'];

    if ($H_ID) {

        $sql1 = mysqli_query($con, "SELECT COUNT(id) AS cart_count FROM carts WHERE consumer_id = '$H_ID'");
        $row1 = mysqli_fetch_array($sql1);

        $cart_count = $row1['cart_count'];

        $sql2 = mysqli_query($con, "SELECT * FROM meals WHERE id = '$meal_id'");
        $row2 = mysqli_fetch_array($sql2);

        $name        = $row2['name'];
        $description = $row2['description'];
        $price       = $row2['price'];
        $qty         = $row2['qty'];

        if (isset($_POST['Submit'])) {

            $meal_id     = $_POST['meal_id'];
            $name        = $_POST['name'];
            $description = $_POST['description'];
            $price       = $_POST['price'];
            $qty         = $_POST['qty'];
            $image       = $_FILES["file"]["name"];

            if ($image) {

                $image = 'Meals_Images/' . $image;

                $stmt = $con->prepare("UPDATE meals SET name = ?, description = ?, image = ?, price = ?, qty = ? WHERE id = ? ");
                $stmt->bind_param("sssdii", $name, $description, $image, $price, $qty, $meal_id);

            } else {

                $stmt = $con->prepare("UPDATE meals SET name = ?, description = ?, price = ?, qty = ? WHERE id = ? ");
                $stmt->bind_param("ssdii", $name, $description, $price, $qty, $meal_id);
            }

            if ($stmt->execute()) {

                if ($image) {
                    move_uploaded_file($_FILES["file"]["tmp_name"], "./Meals_Images/" . $_FILES["file"]["name"]);
                }

                echo "<script language='JavaScript'>
                alert ('Meal Updated Successfully !');
           </script>";

                echo "<script language='JavaScript'>
          document.location='./Meals.php';
             </script>";
            }
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
            <h1 class="text-center text-white display-6">Edit Meal</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                <li class="breadcrumb-item active text-white">Edit Meal</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Checkout Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h1 class="mb-4">Meal Info</h1>
                <form action="./Edit-Meal.php?meal_id=<?php echo $meal_id ?>" method="POST">
                    <input type="hidden" name="meal_id" value="<?php echo $meal_id ?>">
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3"> Name<sup>*</sup></label>
                                        <input type="text" name="name" class="form-control" value="<?php echo $name ?>" required>
                                    </div>
                                </div>

                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Price<sup>*</sup></label>
                                <input type="number" step="0.01" min="0.01" value="<?php echo $price ?>" name="price" class="form-control" required/>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">QTY <sup>*</sup></label>
                                <input type="number" step="1" min="1" name="qty" value="<?php echo $qty ?>" class="form-control" required/>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Description<sup>*</sup></label>
                                <textarea name="description" class="form-control" id="" value="<?php echo $description ?>" required><?php echo $description ?></textarea>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Image<sup>*</sup></label>
                                <input type="file" name="file" class="form-control">
                            </div>

                    <div class="row g-4 text-center align-items-center justify-content-center pt-4">

                        <button class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary" type="submit" name="Submit">Save</button>
                    </div>


                        </div>

                    </div>
                </form>
            </div>
        </div>
        <!-- Checkout Page End -->


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