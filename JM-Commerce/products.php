<?php
include_once("sql-connection.php");
include_once("check-session.php");

check_session();
if (!check_cookie())
    setcookie("cart", new_cart(), time() + (86400 * 30));
connect();
?>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title><?php if(isset($_GET["g"])) echo $_GET["g"]; else echo "Products"; ?> - JM Commerce</title>


    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">

    <link rel="stylesheet" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/lightbox.css">
<!--

TemplateMo 571 Hexashop

https://templatemo.com/tm-571-hexashop

-->
    </head>
    
    <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->
    
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.php" class="logo">
                            <img src="assets/images/logo.png">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="index.php" class="active">Home</a></li>
                            <li class="submenu">
                                <a href="products.php">Browse</a>
                                <ul>
                                    <li><a href="products.php?g=Pop">Pop</a></li>
                                    <li><a href="products.php?g=Rock">Rock</a></li>
                                    <li><a href="products.php?g=Hip-Hop">Hip-Hop</a></li>
                                    <li><a href="products.php?g=Metalcore">Metalcore</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:;">Account</a>
                                <ul>
                                    <li><?php if (!isset($_COOKIE["id"])) echo '<a href="login.php">Log In</a>'; else echo '<a>' . $_COOKIE["user"] . '</a>'; ?></a></li>
                                    <li><?php if (!isset($_COOKIE["id"])) echo '<a href="register.php">Sign Up</a>'; else echo '<a href="logout.php">Log Out</a>'; ?></a></li>
                                </ul>
                            </li>
                            <li class="scroll-to-section"><a href="products.php?g=Cart">Cart</a></li>
                            <li class="scroll-to-section"><a href="index.php#men">Latest</a></li>
                            <?php if($_COOKIE["permission"] > 1) echo '<li class="scroll-to-section"><a href="new-product.php">New (Admin)</a></li>'; ?>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <div class="page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Products</h2>
                        <span>Check our awesome products!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->


    <!-- ***** Products Area Starts ***** -->
    <section class="section" id="products">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2><?php if(!isset($_GET["g"])) echo "Latest";
                                        else echo $_GET["g"]; ?> Products</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <?php if(!isset($_GET["g"])) echo get_products(null);
                        elseif($_GET["g"] == "Cart") echo get_cart_products();
                        else echo get_products($_GET["g"]); ?>
            </div>
            <div class="row">
                <?php if($_GET["g"] == "Cart") echo '<a href="checkout.php"><button class="btn btn-dark">Go to checkout</button></a>'; ?>
            </div>
        </div>
    </section>
    <!-- ***** Products Area Ends ***** -->
    
    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
        </div>
    </footer>
    

    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/accordions.js"></script>
    <script src="assets/js/datepicker.js"></script>
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    <script src="assets/js/slick.js"></script> 
    <script src="assets/js/lightbox.js"></script> 
    <script src="assets/js/isotope.js"></script> 
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>

    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);
                
            });
        });

    </script>

  </body>

</html>
