<?php
	session_start();
	include 'connect.php';

	// add products to cart
	if (isset($_POST['productID'])) {
	  $productID = $_POST['productID'];
	  $productname = $_POST['productname'];
	  $price = $_POST['price'];
	  $quantity = $_POST['quantity'];
	  $unit = "piece";
	  $imagename = $_POST['imagename'];
	  $total = $price * $quantity;

	  $stmt = $con->prepare('SELECT productID FROM tbl_cart WHERE productID=?');
	  $stmt->bind_param('s',$productID);
	  $stmt->execute();
	  $res = $stmt->get_result();
	  $r = $res->fetch_assoc();
	  $code = $r['productID'] ?? '';


	  if (!$code) {
	    $query = $con->prepare('INSERT INTO tbl_cart (productID, productname, price, quantity, unit, imagename, total) VALUES (?,?,?,?,?,?,?)');
	    $query->bind_param('sssssss',$productID,$productname,$price,$quantity,$unit,$imagename,$total);
	    $query->execute();

	    echo '<div class="alert alert-success alert-dismissible mt-2">
  				<button type="button" class="btn-close" data-bs-dismiss="alert" onClick="window.location.reload();"></button>
  				<strong>Item successfully added to your cart!</strong>
				</div>';
	  } else {
	    echo '<div class="alert alert-danger alert-dismissible mt-2">
  				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  				<strong>Item already added to your cart!</strong>
				</div>';
	  }
	}
	
	// remove item added to the cart
	if (isset($_GET['remove'])) {
	  $productID = $_GET['remove'];

	  $stmt = $con->prepare('DELETE FROM tbl_cart WHERE productID=?');
	  $stmt->bind_param('i',$productID);
	  $stmt->execute();

	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'Item removed from the cart!';
	  header('location:load-product.php');
	}

	// clear the cart
	if (isset($_GET['clear'])) {
	  $stmt = $con->prepare('DELETE FROM tbl_cart');
	  $stmt->execute();
	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'All Item removed from the cart!';
	  header('location:load-product.php');
	}

	if(isset($_POST['qty'])){
		$qty = $_POST['qty'];
		$pid = $_POST['pid'];
		$pprice = $_POST['pprice'];

		$tprice = $qty * $pprice;

		$stmt = $con->prepare("UPDATE tbl_cart SET qty=?, total_price=? WHERE id=?");
		$stmt->bind_param("isi", $qty,$tprice,$pid);
		$stmt->execute();
	}
?>