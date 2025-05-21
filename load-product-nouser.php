<?php 
include ("connect.php");
include('includes/header.php');
include('includes/navbar.php');
session_start();

?>
    
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                   
                    <div
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 ">
                        <div>
                        <h3 class="h3 mb-0 text-gray-800" 
    style="font-family: 'Poppins', sans-serif; font-weight: 700; color: white !important; display: flex; align-items: center; gap: 15px;">
  <img src="images/logo.png" alt="TECHtonic Logo" 
       style="height: 70px; width: auto; max-width: 220px; object-fit: contain; box-shadow: 0 2px 6px rgba(0,0,0,0.3); border-radius: 8px;">
  TECHtonic: Performance and Protection, Perfected.
</h3>
                        </div>
                    </div>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
    
                    <a class="add-product btn btn-success" align="right" href="login.php">Login</a>
                        
                     

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Products We Offer</h1>
                        <a class="add-product btn btn-primary" align="right" href="login.php"><i class="fa-sm text-white-50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                    </path>
                </svg>
                        </i>Cart</a>
                    </div>
                <!-- Begin Page Content -->
  
            <div id="list-product">
    
            </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        <div class="container my-5">
  <div class="row g-4">
    
    <!-- Card 1 -->
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="images/1.jpg" class="card-img-top" style="height: 250px; object-fit: cover;" alt="First image">
        <div class="card-body">
          <h5 class="card-title">Laptops</h5>
          <p class="card-text text-muted">"Power, Performance, Price — The Perfect Laptop Awaits!"</p>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="images/2.jpg" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Second image">
        <div class="card-body">
          <h5 class="card-title">Smart Phones</h5>
          <p class="card-text text-muted">"Your Future, in Your Hand — Phone Deals You Can't Miss!"</p>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <img src="images/3.jpg" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Third image">
        <div class="card-body">
          <h5 class="card-title"> Phone Cases</h5>
          <p class="card-text text-muted">"Your Phone’s New Favorite Outfit!"</p>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- The Modal-DETAILS -->
<div class="modal fade" id="product-modal-view">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="m-title">View Details</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
          <div class="view modal-body">

          </div>
      
    </div>
  </div>
</div>



<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
</body>

</html>