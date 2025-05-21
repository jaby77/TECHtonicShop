<?php
require 'connect.php';
	if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
	  $name = $_POST['name'];
	  $phone = $_POST['phone'];
	  $products = $_POST['products'];
	  $grand_total = $_POST['grand_total'];
	  $address = $_POST['address'];
	  $mop = $_POST['mop'];
	  $data = '';

	  $stmt = $con->prepare('INSERT INTO tbl_orders (name,phone,address,mop,products,total_amount)VALUES(?,?,?,?,?,?)');
	  $stmt->bind_param('ssssss',$name,$phone,$address,$mop,$products,$grand_total);
	  $stmt->execute();
	  $stmt2 = $con->prepare('DELETE FROM tbl_cart');
	  $stmt2->execute();
	  $data .= '<div class="text-center">
					<h1 class="display-4 mt-2 text-danger">Thank You!</h1>
					<h2 class="text-success">Your Order Placed Successfully!</h2>
					<h4 class="bg-danger text-light rounded p-2">Items Purchased : ' . $products . '</h4>
					<h4>Customer Name : ' . $name . '</h4>
					<h4>Mobile Phone No.: ' . $phone . '</h4>
					<h4>Shipping Address: ' . $address . '</h4>
					<h4>Total Amount: ' . number_format($grand_total,2) . '</h4>
					<h4>Payment Option : ' . $mop . '</h4>
				 </div>';
	  echo $data;
	}
?>