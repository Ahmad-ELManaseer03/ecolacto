<?php
    session_start();

    include "../Connect.php";

    $H_ID = $_SESSION['H_Log'];

    if ($H_ID) {

        $sql1 = mysqli_query($con, "SELECT COUNT(id) AS cart_count FROM carts WHERE consumer_id = '$H_ID'");
        $row1 = mysqli_fetch_array($sql1);

        $cart_count = $row1['cart_count'];

        if (isset($_POST['Submit'])) {

            $home_cook_id = $_POST['home_cook_id'];
            $name         = $_POST['name'];
            $description  = $_POST['description'];
            $price        = $_POST['price'];
            $qty          = $_POST['qty'];
            $image        = $_FILES["file"]["name"];
            $image        = 'Meals_Images/' . $image;

            $stmt = $con->prepare("INSERT INTO meals (home_cook_id, name, description, image, price, qty) VALUES (?, ?,?, ?,?, ?) ");

            $stmt->bind_param("isssdi", $home_cook_id, $name, $description, $image, $price, $qty);

            if ($stmt->execute()) {

                move_uploaded_file($_FILES["file"]["tmp_name"], "./Meals_Images/" . $_FILES["file"]["name"]);

                echo "<script language='JavaScript'>
                  alert ('A New Category Has Been Added Successfully !');
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
                            <a href="contact.php" class="nav-item nav-link ">Contact</a>
                            <?php if ($H_ID) {?>
                                <a href="Orders.php" class="nav-item nav-link">Orders</a>
                                <a href="Meals.php" class="nav-item nav-link active">Meals</a>
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
            <h1 class="text-center text-white display-6">Meals</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                <li class="breadcrumb-item active text-white">Meals</li>
            </ol>
        </div>
        <!-- Single Page Header End -->



        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">




                                <div class="mb-3">
                            <button
                                type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#verticalycentered"
                            >
                                Add New Meal
                            </button>
                            </div>




                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">QTY</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">

                        <?php
                            $sql1 = mysqli_query($con, "SELECT * from meals WHERE home_cook_id = '$H_ID' ORDER BY id DESC");

                            while ($row1 = mysqli_fetch_array($sql1)) {

                                $meal_id    = $row1['id'];
                                $name       = $row1['name'];
                                $image      = $row1['image'];
                                $qty        = $row1['qty'];
                                $active     = $row1['active'];
                                $price      = $row1['price'];
                                $created_at = $row1['created_at'];

                            ?>


                            <tr>
                                <td><p class="mb-0 mt-4"><?php echo $meal_id ?></p></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $image ?>" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </td>
                                <td><p class="mb-0 mt-4"><?php echo $name ?></p></td>
                                <td><p class="mb-0 mt-4"><?php echo $price ?></p></td>
                                <td><p class="mb-0 mt-4"><?php echo $qty ?></p></td>
                                <td>
                                    <a href="./Edit-Meal.php?meal_id=<?php echo $meal_id ?>" class="btn btn-primary">Edit</a>
                                    <?php if ($active == 1) {?>

                                        <a href="./DeleteRestoreMeal.php?meal_id=<?php echo $meal_id ?>&isActive=<?php echo 0 ?>" class="btn btn-danger">Delete</a>
                                        <?php } else {?>
                                            <a href="./DeleteRestoreMeal.php?meal_id=<?php echo $meal_id ?>&isActive=<?php echo 1 ?>" class="btn btn-primary">Restore</a>
                                            <?php }?>

                                            <a href="./Keywords.php?meal_id=<?php echo $meal_id ?>" class="btn btn-primary">Keywords</a>
                                </td>
                            </tr>


                            <?php
                            }?>






                        </tbody>
                    </table>
                </div>


                <div class="modal fade" id="verticalycentered" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Meal Info</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">

                <form method="POST" action="./Meals.php" enctype="multipart/form-data">

                <input type="hidden" name="home_cook_id" value="<?php echo $H_ID ?>" id="">

                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-4 col-form-label"
                      >Name</label
                    >
                    <div class="col-sm-8">
                      <input type="text" name="name" class="form-control" required/>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-4 col-form-label"
                      >Price</label
                    >
                    <div class="col-sm-8">
                      <input type="number" step="0.01" min="0.01" name="price" class="form-control" required/>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-4 col-form-label"
                      >QTY</label
                    >
                    <div class="col-sm-8">
                      <input type="number" step="1" min="1" name="qty" class="form-control" required/>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-4 col-form-label"
                      >Description</label
                    >
                    <div class="col-sm-8">
                       <textarea name="description" class="form-control" id="" required></textarea>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-4 col-form-label"
                      >Image</label
                    >
                    <div class="col-sm-8">
                      <input type="file" name="file" class="form-control" required/>
                    </div>
                  </div>



                  <div class="row mb-3">
                    <div class="text-end">
                      <button type="submit" name="Submit" class="btn btn-primary">
                        Submit
                      </button>
                    </div>
                  </div>
                </form>




              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal"
                >
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>

            </div>
        </div>
        <!-- Cart Page End -->


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