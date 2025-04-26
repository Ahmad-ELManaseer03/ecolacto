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
                                <a href="Orders.php" class="nav-item nav-link active">Orders</a>
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
            <h1 class="text-center text-white display-6">Orders</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                <li class="breadcrumb-item active text-white">Orders</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">View Items</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">







                        </tbody>
                    </table>
                </div>


                <div class="modal fade" id="verticalycentered" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Items</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">


            
              <div class="col-sm-12 col-md-12 col-lg-12">

                  <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Item Image</th>
                              <th scope="col">Store Name</th>
                              <th scope="col">Item Name</th>
                              <th scope="col">Price</th>
                              <th scope="col">QTY</th>
                              <th scope="col">Total</th>
                              <th scope="col">Rate Store</th>
                            </tr>
                          </thead>
                          <tbody id="modaltbody">
  
  
  
  
  
  
  
                          </tbody>
                      </table>
              </div>


                 

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



    <script>
        fetch('./Get_HomeCook_Orders.php')
        .then(res => res.json())
        .then(res => {

            res.orders.forEach(order => {
                let ordersHtml = `
                
                <tr>
                    <td><p class="mb-0 mt-4">${order.order_id} </p></td>
                    <td><p class="mb-0 mt-4">${order.total_price} JODs</p></td>
                    <td><p class="mb-0 mt-4">${order.status}</p></td>
                    <td>
                        <button onclick="onClick(event)" data-bs-toggle="modal" data-bs-target="#verticalycentered" class="btn btn-success" id="btn-${order.order_id}">View Items</button>
                    </td>    
                    <td>


                ${order.status === 'Pending' ?
                `<a href="./CancelOrder.php?order_id=${order.order_id}" class="btn btn-md rounded-circle bg-light border delete-btn"><i class="fa fa-times text-danger"></i></a>`


                : ``}</td>
            
                      
  
                </tr>
                `;

                $('#tbody').append(ordersHtml);

            })
        })


        const onClick = (e) => {
         
            // console.log(e.target.id.split('btn-')[1]);
            $('#modaltbody').empty();
            fetch('./Get_HomeCook_Orders.php')
        .then(res => res.json())
        .then(res => {


            res.orders.filter(order => order.order_id == e.target.id.split('btn-')[1])
            .forEach(order => {

                order.items.forEach(item => {



                    let itemHtml = `
                    
                    
                    <tr>
                    
                    
                    
                        <th scope="row">
                            <div class="d-flex align-items-center">
                                <img src="../Farmer_Dashboard/${item.item_image}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                            </div>
                        </th>
                                                            <td>
                                        <p class="mb-0 mt-4">${item.farmer_name}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">${item.item_name}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">${item.item_price} JODs</p>
                                    </td>
                                    <td>
                                    <p class="mb-0 mt-4">${item.qty}</p>
                                    </td>
                                                                        <td>
                                        <p class="mb-0 mt-4">${item.item_price * item.qty} JODs</p>
                                    </td>
                                                  <td>

                <a href="./Rate-Form.php?seller_id=${item.farmer_id}" class="btn btn-md rounded-circle bg-light border delete-btn">Rate</a>
                </td>
                    
                    
                    
                    </tr>
                    
                    
                    
                    
                    
                    `


                    $('#modaltbody').append(itemHtml);

                })
            })

        })
            
        }
    </script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    </body>

</html>