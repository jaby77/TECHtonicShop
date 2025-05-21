<?php 
include ("connect.php");
include('includes/header.php');
include('includes/navbar.php');
session_start();

$cart_count = 0;
$cart_result = mysqli_query($con, "SELECT SUM(quantity) as totalQty FROM tbl_cart");
if ($cart_row = mysqli_fetch_assoc($cart_result)) {
    $cart_count = $cart_row['totalQty'] ?? 0;
}
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
                     
                    <a class="add-product btn btn-danger" align="right" href="index.html">Logout</a>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Our available products</h1>
                        <a class="btn btn-primary position-relative" data-bs-toggle="modal" data-bs-target="#product-modal-cart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                    </path>
                </svg>
  <?php if ($cart_count > 0): ?>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
      <?= $cart_count ?>
      <span class="visually-hidden">items in cart</span>
    </span>
  <?php endif; ?>
</a>

                    </div>
                <!-- Begin Page Content -->
  
            <div id="list-product">
    
            </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<!-- Modal: CART -->
<div class="modal fade" id="product-modal-cart">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content bg-dark text-light border-secondary">

      <!-- Modal Header -->
      <div class="modal-header border-secondary">
        <h4 class="modal-title">🛒 Your Shopping Cart</h4>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal Body -->
      <form id="cart-checkout-form" method="POST" action="checkout.php">
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-dark table-bordered align-middle text-center">
              <thead>
                <tr>
                  <th><input type="checkbox" id="selectAll"></th>
                  <th>ID</th>
                  <th>Product</th>
                  <th>Image</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Total</th>
                  <th>
                    <a href="cart.php?clear=all" class="btn btn-sm btn-danger" onclick="return confirm('Clear your entire cart?')">
                      <i class="fas fa-trash"></i> Clear
                    </a>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql_item = "SELECT * FROM tbl_cart";
                $result_shop = mysqli_query($con, $sql_item);
                $carttotal = 0;

                if (mysqli_num_rows($result_shop) > 0):
                  while ($row = mysqli_fetch_array($result_shop)):
                ?>
                <tr>
                  <td>
                    <input type="checkbox" class="item-check" name="checkout_ids[]" value="<?= $row['productID'] ?>" data-total="<?= $row['total'] ?>">
                  </td>
                  <td><?= $row['productID'] ?></td>
                  <td><?= htmlspecialchars($row['productname']) ?></td>
                  <td><img src="images/<?= htmlspecialchars($row['imagename']) ?>" width="60" class="rounded"></td>
                  <td>₱<?= number_format($row['price'], 2) ?></td>
                  <td><?= $row['quantity'] ?></td>
                  <td>₱<?= number_format($row['total'], 2) ?></td>
                  <td>
                    <a href="cart.php?remove=<?= $row['productID'] ?>" class="text-danger" onclick="return confirm('Remove this item?');">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5" class="text-end"><strong>Selected Total:</strong></td>
                  <td colspan="3"><strong id="selectedTotal">₱0.00</strong></td>
                </tr>
                <tr>
                  <td colspan="8" class="text-end">
                    <a href="load-product.php" class="btn btn-outline-success me-2">
                      <i class="fas fa-undo-alt"></i> Return to Shop
                    </a>
                    <button type="submit" class="btn btn-info" id="checkoutBtn" disabled>
                      <i class="fas fa-shopping-cart"></i> Checkout Selected
                    </button>
                  </td>
                </tr>
              </tfoot>
              <?php else: ?>
              <tr>
                <td colspan="8">
                  <div class="alert alert-info text-center m-0">
                    <i class="fas fa-info-circle"></i> Your cart is currently empty.
                  </div>
                </td>
              </tr>
              <?php endif; ?>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JavaScript: Select + Total Calculation -->
<script>
  const selectAll = document.getElementById('selectAll');
  const checkboxes = document.querySelectorAll('.item-check');
  const checkoutBtn = document.getElementById('checkoutBtn');
  const selectedTotalEl = document.getElementById('selectedTotal');

  function updateCheckoutState() {
    const checkedBoxes = [...checkboxes].filter(cb => cb.checked);
    const total = checkedBoxes.reduce((sum, cb) => sum + parseFloat(cb.dataset.total || 0), 0);

    checkoutBtn.disabled = checkedBoxes.length === 0;
    selectedTotalEl.textContent = '₱' + total.toFixed(2);
  }

  selectAll?.addEventListener('change', () => {
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
    updateCheckoutState();
  });

  checkboxes.forEach(cb => {
    cb.addEventListener('change', () => {
      selectAll.checked = [...checkboxes].every(cb => cb.checked);
      updateCheckoutState();
    });
  });

  updateCheckoutState(); // initial state
</script>



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


<script type="text/javascript">
  $(document).ready(function(){
              $.ajax({
                  type:"POST", 
                  url: "fetch-product.php",   
                  data:{},
                  cache:false,
                  success:function(data) {
                    $("#list-product").html(data);
                  }
                });
  });

</script>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
</body>

</html>