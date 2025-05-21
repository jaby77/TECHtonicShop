<?php
include "connect.php";

$view = intval($_POST['view']);

$sql = "SELECT * FROM tbl_product WHERE productID = $view";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result)) {
?>
  <div style="
    max-width: 800px;
    margin: 30px auto;
    background: linear-gradient(145deg, #fff5f5, #ffeaea);
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    overflow: hidden;
    display: flex;
    flex-wrap: wrap;
    border: 1px solid #ffdada;
  ">
    <div style="
      flex: 1 1 240px;
      text-align: center;
      padding: 25px;
      min-width: 240px;
      background-color: #fff0f0;
    ">
      <img src="images/<?php echo htmlspecialchars($row['imagename']); ?>" 
           alt="Product Image"
           style="width: 200px; height: 200px; object-fit: cover; border-radius: 12px; border: 3px solid #d35266;">
    </div>
    <div style="
      flex: 2 1 400px;
      padding: 25px;
      color: #b30000;
    ">
      <h2 style="margin: 0 0 10px; font-size: 24px; color: #d35266;">Product Name</h2>
      <p style="font-size: 18px; font-weight: 500; margin-bottom: 20px;">
        <?php echo htmlspecialchars($row['productname']); ?>
      </p>

      <h3 style="margin: 0 0 10px; font-size: 20px; color: #d35266;">Description</h3>
      <p style="font-size: 16px; line-height: 1.6; color: #660000;">
        <?php echo nl2br(htmlspecialchars($row['description'])); ?>
      </p>
    </div>
  </div>
<?php 
}
?>
