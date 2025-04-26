<?php
    session_start();

    include "../Connect.php";

    $H_ID         = $_SESSION['H_Log'];
    $product_name = $_POST['product_name'];
    $selected_category_id = $_GET['category_id'];

    if ($H_ID) {

        $sql1 = mysqli_query($con, "SELECT COUNT(id) AS cart_count FROM carts WHERE consumer_id = '$H_ID'");
        $row1 = mysqli_fetch_array($sql1);

        $cart_count = $row1['cart_count'];
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
            <h1 class="text-center text-white display-6">Products</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                <li class="breadcrumb-item active text-white">Products</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <h1 class="mb-4">EcoLacto</h1>
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-xl-3">
                                <div class="input-group w-100 mx-auto d-flex">

                                </div>
                            </div>
                            <div class="col-6"></div>
                            <div class="col-xl-3">
                                <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                    <label for="fruits">Default Sorting:</label>
                                    <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3" form="fruitform">
                                        <option value="">Nothing</option>
                                        <option value="price">High price to low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
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
                                                    <div class="d-flex justify-content-between fruite-name category-link" id="<?php echo $category_id ?>">
                                                        <a href="./Products.php?category_id=<?php echo $category_id ?>" ><?php echo $category_name ?></a>
                                                        <span>(<?php echo $products_count ?>)</span>
                                                    </div>
                                                </li>

                                 <?php }?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4 class="mb-2">Price</h4>
                                            <input type="range" class="form-range w-100 price-change" id="rangeInput" name="rangeInput" min="0" max="500" value="0" oninput="rangeShowVal(this.value)">
                                            <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <h4 class="mb-3">Top Rated Farmers</h4>

                                        <?php
                                            $sql1 = mysqli_query($con, "SELECT * from users WHERE active = 1 AND user_type_id = 2 AND total_rate >= 3.5");

                                            while ($row1 = mysqli_fetch_array($sql1)) {

                                                $farmer_id         = $row1['id'];
                                                $farmer_name       = $row1['name'];
                                                $farmer_image      = $row1['image'];
                                                $farmer_total_rate = $row1['total_rate'];

                                            ?>
                                        <div class="d-flex align-items-center justify-content-start">
                                            <div class="rounded me-4" style="width: 100px; height: 100px;">
                                                <img src="../Farmer_Dashboard/<?php echo $farmer_image ?>" class="img-fluid rounded" alt="">
                                            </div>
                                            <div>
                                                <a href="./Farmer.php?farmer_id=<?php echo $farmer_id ?>"><h6 class="mb-2"><?php echo $farmer_name ?></h6></a>
                                                <div class="d-flex mb-2">
                                                    <?php for ($ii = 1; $ii < $seller_total_rate; $ii++) {?>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <?php }?>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <h5 class="fw-bold me-2"></h5>
                                                    <h5 class="text-danger text-decoration-line-through"></h5>
                                                </div>
                                            </div>
                                        </div>
<?php }?>


                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row g-4 justify-content-center" id="products_div">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->


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

    <script>
        const rangeShowVal = (value) => {


                document.getElementById('amount').innerHTML = value

                        $.ajax({
                        url: `./GetProducts.php?price=${value}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {


                            $('#products_div').empty();

                        data.forEach((product, i) => {

                                let productHtml = `


                                                  <div class="col-md-6 col-lg-6 col-xl-4" id="${i}">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="../Farmer_Dashboard/${product.image}" class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="text-white background-sec px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">${product.category_name}</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>${product.name}</h4>
                                                <p>${product.description.substring(0, 10)}</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">${product.price} JODs</p>
                                                    <a href="./Product.php?product_id=${product.id}" class="btn border border-secondary rounded-pill px-3 text-primary">View Product</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                `;

                $('#products_div').append(productHtml)
           })

        }
    });
}

            $('#fruits').change(function(e){


                $.ajax({
                url: `GetProducts.php?filter=${this.value}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#products_div').empty();
                data.forEach((product, i) => {

                        let productHtml = `


                                                        <div class="col-md-6 col-lg-6 col-xl-4" id="${i}">
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <img src="../Farmer_Dashboard/${product.image}" class="img-fluid w-100 rounded-top" alt="">
                                                    </div>
                                                    <div class="text-white background-sec px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">${product.category_name}</div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4>${product.name}</h4>
                                                        <p>${product.description.substring(0, 10)}</p>
                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0">${product.price} JODs</p>
                                                            <a href="./Product.php?product_id=${product.id}" class="btn border border-secondary rounded-pill px-3 text-primary">View Product</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                        `;

                        $('#products_div').append(productHtml)
                })

                }
            });
            })

        $(document).ready(function() {

            let categoryId =                                                                                     <?php echo json_encode($selected_category_id); ?>;
            let productName =                                                           <?php echo json_encode($product_name); ?>;


            let url = 'GetProducts.php'

            if(categoryId) {

                url = `GetProducts.php?category_id=${categoryId}`
            } else if(productName) {
                url = `GetProducts.php?product_name=${productName}`
            }


            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#products_div').empty();
                data.forEach((product, i) => {

                        let productHtml = `


                                                        <div class="col-md-6 col-lg-6 col-xl-4" id="${i}">
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <img src="../Farmer_Dashboard/${product.image}" class="img-fluid w-100 rounded-top" alt="">
                                                    </div>
                                                    <div class="text-white background-sec px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">${product.category_name}</div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4>${product.name}</h4>
                                                        <p>${product.description.substring(0, 10)}</p>
                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0">${product.price} JODs</p>
                                                            <a href="./Product.php?product_id=${product.id}" class="btn border border-secondary rounded-pill px-3 text-primary">View Product</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                        `;

                        $('#products_div').append(productHtml)
                })

                }
            });

            $('.category-link').click(e => {

                e.preventDefault();          

                $.ajax({
                url: `./GetProducts.php?category_id=${e.target.href.split('?category_id=')[1]}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {

                    $('#products_div').empty();

                data.forEach((product, i) => {

                        let productHtml = `


                                                        <div class="col-md-6 col-lg-6 col-xl-4" id="${i}">
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <img src="../Farmer_Dashboard/${product.image}" class="img-fluid w-100 rounded-top" alt="">
                                                    </div>
                                                    <div class="text-white background-sec px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">${product.category_name}</div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4>${product.name}</h4>
                                                        <p>${product.description.substring(0, 10)}</p>
                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0">${product.price} JODs</p>
                                                            <a href="./Product.php?product_id=${product.id}" class="btn border border-secondary rounded-pill px-3 text-primary">View Product</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                        `;

                        $('#products_div').append(productHtml)
                })

                }
            });



            });
        });







    </script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

</html>
