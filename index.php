<?php
session_start();
include 'config/conn.php';

$MSG = $_GET['message'] ?? '';

$selectProduct = "SELECT * FROM products";
$stmt = $conn->prepare($selectProduct);
$stmt->execute();

if(isset($_POST['register-user'])){
    
    $full_name     = $_POST['full_name'];
    $email         = $_POST['email'];
    $password      = $_POST['password'];
    $password      = password_hash($password, PASSWORD_BCRYPT);
    $phone         = $_POST['phone'];

    try {
         $insertRegisterUser = "INSERT INTO `users`(`full_name`, `email`, `password`, `phone`)VALUES(:full_name, :email, :password, :phone);";
    $stmt = $conn->prepare($insertRegisterUser);
    $stmt->execute([
        ':full_name' => $full_name,
        ':email'     => $email,
        ':password'  => $password,
        ':phone'     => $phone, 
    ]);
    header('location:congrats.php?goto_page=index.php&message=success--User Register Successfully');
      
    } catch (\Throwable $th) {
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ecommerce</title>
    
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <?php
    include 'config/alerts.php';
    ?>
    <!-- Plugins CSS File -->
    <?php
    include 'config/css-links.php';
    ?>
</head>

<body>
    <div class="page-wrapper">
        <header class="header header-7">
         
        <!-- HEADER -->
        <?php
        include 'config/header.php';
        ?>

        <!-- NAVBAR -->
         <?php
         include 'config/navbar.php';
         ?>   
        </header>

        <main class="main">
            <div class="container-fluid">

            <div class="mb-6"></div><!-- End .mb-6 -->

            <div class="container-fluid">
                <div class="heading heading-center mb-3">
                    <h2 class="title">NEW ARRIVALS</h2><!-- End .title -->

                    <ul class="nav nav-pills justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="new-women-link" data-toggle="tab" href="#new-women-tab" role="tab" aria-controls="new-women-tab" aria-selected="true">Womens Clothing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="new-men-link" data-toggle="tab" href="#new-men-tab" role="tab" aria-controls="new-men-tab" aria-selected="false">Mens Clothing</a>
                        </li>
                    </ul>
                </div><!-- End .heading -->
                <div class="tab-content">
                    <div class="tab-pane p-0 fade show active" id="new-women-tab" role="tabpanel" aria-labelledby="new-women-link">
                        <div class="products">
                        <div class="row">
                        <?php
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                        
                        ?>
                            
                                <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                                    <div class="product product-7 text-center">
                                        <figure class="product-media">
                                            
                                            <a href="#">
                                                <img src="backend/assets/product-img/<?= $row['image']?>" alt="Product image" class="product-image">
                                                <img src="backend/assets/product-img/<?= $row['image']?>" alt="Product image" class="product-image-hover">
                                            </a>

                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                                <a href="#" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                            </div><!-- End .product-action-vertical -->

                                            <div class="product-action">
                                                <a href="add_to_cart.php?id=<?= $row['id']?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                            </div><!-- End .product-action -->
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <h3 class="product-title"><a href="#"><?= $row['description']?></a></h3><!-- End .product-title -->
                                            <div class="product-price">
                                                <span class="new-price">$<?= $row['price']?></span>
                                                <span class="old-price">$84.00</span>
                                            </div><!-- End .product-price -->
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val" style="width: 40%;"></div><!-- End .ratings-val -->
                                                </div><!-- End .ratings -->
                                                <span class="ratings-text">( 4 Reviews )</span>
                                            </div><!-- End .rating-container -->
                                        </div><!-- End .product-body -->
                                    </div><!-- End .product -->
                                </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                                <?php
                                  }
                                ?>
                            </div><!-- End .row -->
                        </div><!-- End .products -->
                    </div><!-- .End .tab-pane -->

                </div><!-- End .tab-content -->

               
                <hr class="mt-0 mb-6">
                
            <div class="brands-border owl-carousel owl-simple" data-toggle="owl" 
                data-owl-options='{
                    "nav": false, 
                    "dots": false,
                    "margin": 0,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":2
                        },
                        "420": {
                            "items":3
                        },
                        "600": {
                            "items":4
                        },
                        "900": {
                            "items":5
                        },
                        "1024": {
                            "items":6
                        },
                        "1360": {
                            "items":7
                        }
                    }
                }'>

                
            </div><!-- End .owl-carousel -->
        </main><!-- End .main -->

        <?php
        include 'config/footer.php';
        ?>
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="#" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>
            
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

    <!-- LOGIN REGISTER  -->
 <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form method="post" action="#">
                                        <div class="form-group">
                                            <label for="register-email">Name</label>
                                            <input type="text" class="form-control" id="name" name="full_name" required>
                                             <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email" name="email" required>
                                             <label for="password">Password</label>
                                            <input type="text" class="form-control" id="password" name="password" required>
                                             <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone" required>
                                             
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" name="register-user" class="btn btn-outline-primary-2">
                                                <span>Register</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            
                                        </div><!-- End .form-footer -->
                                    </form>
                                   
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                   
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

    <!-- LOGIN REGISTER END -->

   
    <!-- Plugins JS File -->
    <?php
    include 'config/js-links.php';
    ?>
</body>


<!-- molla/index-7.html  22 Nov 2019 09:56:58 GMT -->
</html>