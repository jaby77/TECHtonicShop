<?php 
session_start();
include("connect.php");
include('includes/header.php');
include('includes/navbar.php');

$grand_total = 0;
$items = [];

if (isset($_POST['checkout_ids']) && is_array($_POST['checkout_ids']) && count($_POST['checkout_ids']) > 0) {
    $checkout_ids = array_map('trim', $_POST['checkout_ids']);

    $placeholders = implode(',', array_fill(0, count($checkout_ids), '?'));
    $types = str_repeat('s', count($checkout_ids));

    $sql = "SELECT productID, productname, price, quantity, total FROM tbl_cart WHERE productID IN ($placeholders)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param($types, ...$checkout_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
        $grand_total += $row['total'];
    }

} else {
    $_SESSION['checkout_error'] = "Please select at least one item to checkout.";
    header("Location: load-product.php");
    exit();
}
?>

<div class="container mt-5">
  <h3 class="text-light mb-4">🧾 Order Summary</h3>

  <div class="table-responsive">
    <table class="table table-dark table-bordered align-middle">
      <thead>
        <tr>
          <th>ID</th>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['productID']) ?></td>
          <td><?= htmlspecialchars($item['productname']) ?></td>
          <td>₱<?= number_format($item['price'], 2) ?></td>
          <td><?= $item['quantity'] ?></td>
          <td>₱<?= number_format($item['total'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
          <td><strong id="grandTotalDisplay">₱<?= number_format($grand_total, 2) ?></strong></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Checkout Form -->
  <form id="checkoutForm" action="confirm-order.php" method="POST" class="bg-secondary p-4 rounded shadow-sm mt-4 needs-validation" novalidate>
    <h5 class="text-light mb-3">💳 Customer Info & Payment</h5>

    <div class="mb-3">
      <label for="name" class="form-label text-light">Full Name</label>
      <input type="text" name="name" id="name" class="form-control" required>
      <div class="invalid-feedback">Please enter your name.</div>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label text-light">Email</label>
      <input type="email" name="email" id="email" class="form-control" required>
      <div class="invalid-feedback">Please enter a valid email address.</div>
    </div>

    <div class="mb-3">
      <label for="mobile" class="form-label text-light">Mobile Number</label>
      <input type="tel" name="mobile" id="mobile" class="form-control" pattern="^(09|\+639)\d{9}$" required placeholder="e.g. 09123456789">
      <div class="invalid-feedback">Please enter a valid Philippine mobile number.</div>
    </div>

    <div class="mb-3">
      <label for="address" class="form-label text-light">Shipping Address</label>
      <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
      <div class="invalid-feedback">Please enter your shipping address.</div>
    </div>

    <div class="mb-3">
      <label for="voucher" class="form-label text-light">🎟️ Voucher Code (Optional)</label>
      <input type="text" name="voucher" id="voucher" class="form-control" placeholder="Enter voucher (e.g., DISCOUNT10)">
      <div class="form-text text-light">
  Try any of these:
  <ul class="mb-0">
    <li><code>DISCOUNT10</code> – 10% OFF</li>
    <li><code>LESS100</code> – ₱100 OFF</li>
    <li><code>FREESHIP</code> – ₱50 Shipping Discount</li>
    <li><code>HALFOFF</code> – 50% OFF</li>
    <li><code>WELCOME25</code> – 25% OFF for new users</li>
  </ul>
</div>

    </div>

    <div class="mb-4">
      <label for="payment_method" class="form-label text-light fw-bold">Select Payment Method</label>
      <select class="form-select" id="payment_method" name="payment_method" required>
        <option value="" selected disabled>Choose a payment method</option>
        <option value="Cash on Delivery">Cash on Delivery</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Gcash">Gcash</option>
        <option value="PayPal">PayPal</option>
        <option value="Bank Transfer">Bank Transfer</option>
      </select>
      <div class="invalid-feedback">Please select a payment method.</div>
    </div>

    <!-- Hidden Inputs -->
    <input type="hidden" name="grand_total" id="grand_total_input" value="<?= $grand_total ?>">
    <?php foreach ($items as $item): ?>
      <input type="hidden" name="products[]" value="<?= $item['productID'] ?>">
      <input type="hidden" name="quantities[]" value="<?= $item['quantity'] ?>">
      <input type="hidden" name="prices[]" value="<?= $item['price'] ?>">
    <?php endforeach; ?>

    <div class="d-grid">
      <button type="button" id="confirmButton" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#receiptModal">
        <i class="fas fa-check-circle"></i> Confirm Order
      </button>
    </div>
  </form>
</div>

<!-- Confirmation Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="receiptModalLabel">🧾 Confirmation Receipt</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Name:</strong> <span id="r_name"></span></p>
        <p><strong>Email:</strong> <span id="r_email"></span></p>
        <p><strong>Mobile:</strong> <span id="r_mobile"></span></p>
        <p><strong>Address:</strong> <span id="r_address"></span></p>
        <p><strong>Payment Method:</strong> <span id="r_payment"></span></p>
        <p><strong>Voucher:</strong> <span id="r_voucher">None</span></p>
        <hr>
        <p><strong>Total:</strong> ₱<span id="r_total"><?= number_format($grand_total, 2) ?></span></p>
        <p class="text-success fw-bold" id="voucherDiscountMsg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-lg">
  <i class="fas fa-check-circle"></i> Submit Order
</button>

      </div>
    </div>
  </div>
</div>
<!-- Modal: Order Receipt -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark text-light border-success">
      <div class="modal-header border-success">
        <h5 class="modal-title">🎉 Order Confirmed!</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Thank you, <strong id="r_name"></strong>!</p>
        <p>Your order has been successfully placed.</p>
        <p><strong>Total Paid:</strong> ₱<span id="r_total"></span></p>
        <p>We'll send a confirmation to <strong id="r_email"></strong> and deliver it to <strong id="r_address"></strong>.</p>
      </div>
      <div class="modal-footer">
        <a href="load-product.php" class="btn btn-outline-light">Back to Shop</a>
      </div>
    </div>
  </div>
</div>

<script>
// Bootstrap form validation
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();

const originalTotal = <?= $grand_total ?>;

function applyVoucher() {
  const voucher = document.getElementById('voucher').value.trim().toUpperCase();
  let discounted = originalTotal;
  let discountText = "";

  switch (voucher) {
    case 'DISCOUNT10':
      discounted = originalTotal * 0.9;
      discountText = "✔ DISCOUNT10 applied: 10% OFF!";
      break;
    case 'LESS100':
      discounted = originalTotal - 100;
      discountText = "✔ LESS100 applied: ₱100 OFF!";
      break;
    case 'FREESHIP':
      discounted = originalTotal - 50;
      discountText = "✔ FREESHIP applied: ₱50 OFF for shipping!";
      break;
    case 'HALFOFF':
      discounted = originalTotal * 0.5;
      discountText = "✔ HALFOFF applied: 50% OFF!";
      break;
    case 'WELCOME25':
      discounted = originalTotal * 0.75;
      discountText = "✔ WELCOME25 applied: 25% OFF for first order!";
      break;
    default:
      discounted = originalTotal;
      discountText = "";
  }

  if (discounted < 0) discounted = 0;

  document.getElementById('grandTotalDisplay').innerText = `₱${discounted.toFixed(2)}`;
  document.getElementById('grand_total_input').value = discounted.toFixed(2);
  document.getElementById('r_total').innerText = discounted.toFixed(2);
  document.getElementById('voucherDiscountMsg').innerText = discountText;
}

// Update live when typing voucher
document.getElementById('voucher').addEventListener('input', applyVoucher);

// On confirm button click, show receipt
document.getElementById('confirmButton').addEventListener('click', function () {
  const form = document.getElementById('checkoutForm');
  if (!form.checkValidity()) {
    form.classList.add('was-validated');
    return;
  }

  // Populate modal fields
  document.getElementById('r_name').innerText = document.getElementById('name').value.trim();
  document.getElementById('r_email').innerText = document.getElementById('email').value.trim();
  document.getElementById('r_mobile').innerText = document.getElementById('mobile').value.trim();
  document.getElementById('r_address').innerText = document.getElementById('address').value.trim();
  document.getElementById('r_payment').innerText = document.getElementById('payment_method').value;
  document.getElementById('r_voucher').innerText = document.getElementById('voucher').value || 'None';

  applyVoucher();
});

</script>


