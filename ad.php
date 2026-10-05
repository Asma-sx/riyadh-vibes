<?php

require 'auth.php';
require_admin();
include 'connection.php';

if (isset($_POST['add_product'])) {
   check_csrf($_POST['csrf'] ?? '');
   $product_name  = trim($_POST['product_name'] ?? '');
   $product_price = trim($_POST['product_price'] ?? '');

   if ($product_name === '' || $product_price === '' || empty($_FILES['product_image']['name'])) {
      $message[] = 'please fill out all';
   } else {
      $product_image = save_uploaded_image($_FILES['product_image']);
      if (!$product_image) {
         $message[] = 'please upload a JPG or PNG image (max 5 MB)';
      } else {
         $stmt = $conn->prepare('INSERT INTO catagory (name, price, image) VALUES (?, ?, ?)');
         $stmt->bind_param('sss', $product_name, $product_price, $product_image);
         $message[] = $stmt->execute() ? 'new event added successfully' : 'could not add the event';
      }
   }
}

if (isset($_GET['delete'])) {
   check_csrf($_GET['csrf'] ?? '');
   $id = (int)$_GET['delete'];
   $stmt = $conn->prepare('DELETE FROM catagory WHERE id = ?');
   $stmt->bind_param('i', $id);
   $stmt->execute();
   header('Location: ad.php');
   exit;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>event Riyadh vibes</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;400;700&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/templatemo-festava-live.css" rel="stylesheet">
    <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
  

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

:root{
   --green:#27ae60;
   --black:#333;
   --white:#fff;
   --bg-color:#eee;
   --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
   --border:.1rem solid var(--black);
   
}

*{
   font-family: 'Poppins', sans-serif;
   margin:0; padding:0;
   box-sizing: border-box;
   outline: none; border:none;
   text-decoration: none;
   text-transform: capitalize;
   
}

html{
   font-size: 62.5%;
   overflow-x: hidden;
}

.btn{
   display: block;
   width: 100%;
   cursor: pointer;
   border-radius: .5rem;
   margin-top: 1rem;
   font-size: 1.7rem;
   padding:1rem 3rem;
   background: var(--green);
   color:var(--white);
   text-align: center;
}

.btn:hover{
   background: var(--black);
}

.message{
   display: block;
   background: var(--bg-color);
   padding:1.5rem 1rem;
   font-size: 2rem;
   color:var(--black);
   margin-bottom: 2rem;
   text-align: center;
}

.container{
   max-width: 1200px;
   padding:2rem;
   margin:0 auto;
}

.admin-product-form-container.centered{
   display: flex;
   align-items: center;
   justify-content: center;
   min-height: 100vh;
   
}

.admin-product-form-container form{
   max-width: 50rem;
   margin:0 auto;
   padding:2rem;
   border-radius: .5rem;
   background: var(--bg-color);
}

.admin-product-form-container form h3{
   text-transform: uppercase;
   color:var(--black);
   margin-bottom: 1rem;
   text-align: center;
   font-size: 2.5rem;
}

.admin-product-form-container form .box{
   width: 100%;
   border-radius: .5rem;
   padding:1.2rem 1.5rem;
   font-size: 1.7rem;
   margin:1rem 0;
   background: var(--white);
   text-transform: none;
}

.product-display{
   margin:2rem 0;
}

.product-display .product-display-table{
   width: 100%;
   text-align: center;
}

.product-display .product-display-table thead{
   background: var(--bg-color);
}

.product-display .product-display-table th{
   padding:1rem;
   font-size: 2rem;
}


.product-display .product-display-table td{
   padding:1rem;
   font-size: 2rem;
   border-bottom: var(--border);
}

.product-display .product-display-table .btn:first-child{
   margin-top: 0;
}

.product-display .product-display-table .btn:last-child{
   background: crimson;
}

.product-display .product-display-table .btn:last-child:hover{
   background: var(--black);
}









@media (max-width:991px){

   html{
      font-size: 55%;
   }

}

@media (max-width:768px){

   .product-display{
      overflow-y:scroll;
   }

   .product-display .product-display-table{
      width: 80rem;
   }

}

@media (max-width:450px){

   html{
      font-size: 50%;
   }

}
</style>
  
</head>

<body>

    <main>

        <header class="site-header">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12 d-flex flex-wrap">
                        <p class="d-flex me-4 mb-0">
                            <i class="bi-person custom-icon me-2"></i>
                            <strong class="text-dark">Welcome to Riyadh vibes 2024</strong>
                        </p>
                    </div>

                </div>
            </div>
        </header>


        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Riyadh vibes
                    </a>

                <a href="logout.php" class="btn custom-btn d-lg-none ms-auto me-4"> logout</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="index.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="about.php">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="artist.php">Artists</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="eventareas.php">Event Areas</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="price.php">Pricing</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="contact.php">Contact</a>
                        </li>
                    </ul>
                    <a href="logout.php" class="btn custom-btn d-lg-block d-none">Logout</a>

                  
                </div>
            </div>
        </nav>


        <?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.e($message).'</span>';
   }
}

?>
   
<div class="container">

   <div class="admin-product-form-container" >

      <form action="" method="post" enctype="multipart/form-data">
         <h3>add a new Event to Riyadh vibes </h3>
         <input type="text" placeholder="Enter event name" name="product_name" class="box">
         <input type="text" placeholder="Enter event place" name="product_price" class="box">
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
         <input type="hidden" name="csrf" value="<?php echo e($_SESSION['csrf']); ?>">
         <input type="submit" class="btn" name="add_product" value="add event">
      </form>

   </div>

   <?php

   $select = mysqli_query($conn, "SELECT * FROM catagory");
   
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>event image</th>
            <th>event name</th>
            <th>event place</th>
            <th>action</th>
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="uploaded_img/<?php echo e($row['image']); ?>" height="100" alt=""></td>
            <td><?php echo e($row['name']); ?></td>
            <td><?php echo e($row['price']); ?></td>
            <td>
               <a href="up.php?edit=<?php echo (int)$row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> Edit </a>
               <a href="ad.php?delete=<?php echo (int)$row['id']; ?>&amp;csrf=<?php echo e($_SESSION['csrf']); ?>" onclick="return confirm('Delete this event?');" class="btn"> <i class="fas fa-trash"></i> Delete </a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>

</div>



   


       


    
    </main>


    <footer class="site-footer">
        <div class="site-footer-top" style="height: 80px;">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-12">
                        <h3 class="text-white mb-lg-0">Riyadh vibes</h2>
                    </div>

                    <div class="col-lg-6 col-12 d-flex justify-content-lg-end align-items-center">
                        <ul class="social-icon d-flex justify-content-lg-end">
                            <li class="social-icon-item">
                                <a href="https://twitter.com/riyadhSeason" class="social-icon-link">
                                    <span class="bi-twitter"></span>
                                </a>
                            </li>

                        

                            <li class="social-icon-item">
                                <a href="https://instagram.com/riyadhseason" class="social-icon-link">
                                    <span class="bi-instagram"></span>
                                </a>
                            </li>

                            <li class="social-icon-item">
                                <a href="https://www.facebook.com/profile.php?id=100044570013610&mibextid=ZbWKwL" class="social-icon-link">
                                    <span class="bi-facebook"></span>
                                </a>
                            </li>

                           
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12 mb-4 pb-2">
                    <h5 class="site-footer-title mb-3">Links</h5>

                    <ul class="site-footer-links">
                        <li class="site-footer-link-item">
                            <a href="index.php" class="site-footer-link">Home</a>
                        </li>

                        <li class="site-footer-link-item">
                            <a href="about.php" class="site-footer-link">About</a>
                        </li>

                        <li class="site-footer-link-item">
                            <a href="artist.php" class="site-footer-link">Artists</a>
                        </li>

                        <li class="site-footer-link-item">
                            <a href="eventareas.php" class="site-footer-link">Event Areas</a>
                        </li>

                        <li class="site-footer-link-item">
                            <a href="price.php" class="site-footer-link">Pricing</a>
                        </li>

                        <li class="site-footer-link-item">
                            <a href="vontact.php" class="site-footer-link">Contact</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                    <h5 class="site-footer-title mb-3">Have a question?</h5>

                    <p class="text-white d-flex mb-1">
                        <a href="tel: +966-54-892-9234" class="site-footer-link">
                                +966-54-892-9234
                            </a>
                    </p>

                    <p class="text-white d-flex">
                        <a href="mailto:hello@company.com" class="site-footer-link">
                        Riyadh vibes@gmail.com
                            </a>
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 col-11 mb-4 mb-lg-0 mb-md-0">
                    <h5 class="site-footer-title mb-3">Location</h5>

                    <p class="text-white d-flex mt-3 mb-2">
                        blvdcity, kingdomarena, blvdworld, zoo riyadh</p>

                    <a class="link-fx-1 color-contrast-higher mt-3" href="#">
                        <span>Our Maps</span>
                        <svg class="icon" viewBox="0 0 32 32" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="16" cy="16" r="15.5"></circle><line x1="10" y1="18" x2="16" y2="12"></line><line x1="16" y1="12" x2="22" y2="18"></line></g></svg>
                    </a>
                </div>
            </div>
        </div>

      
    </footer>

    <!--

T e m p l a t e M o

-->

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>



