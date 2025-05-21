
  <div class="float-left w-75">
    <div class="row">
    <div id="message"></div>
  		
      <?php 
      include ("connect.php");
      $sql_product = "SELECT * FROM tbl_product ORDER BY productID";
      $result_profile = mysqli_query($con, $sql_product);

      if (mysqli_num_rows($result_profile) > 0){
        while($row = mysqli_fetch_array($result_profile)){
    ?>
        <div class="col-sm-3">
           <div class="card h-60 w-200 shadow-lg"
  style="
    background: radial-gradient(circle, rgba(183,28,28,1) 0%, rgba(66,0,0,1) 100%);
    border-radius: 25px;
    border: 3px solid #000000;
    width: 230px;
    color: white;
  ">
            <div class="h-30 d-flex" style="padding-top: 20px;">
              <img src="images/<?php echo $row['imagename'];?>" class="img-fluid card-img" id="<?php echo $row['productID'];?>" alt="<?php echo $row['productname'];?>" style="margin:auto; width:200px; height:200px;">
            </div>

            <div class="card-body">
              <h4 class="card-title" id="<?php echo $row['productID'];?>">
                <?php echo $row['productname'];?>
              </h4>
              <p class="card-text">
                <label>Php. </label>
                <label id="<?php echo $row['productID'];?>"><?php echo $row['price'];?></label>
                <label id="<?php echo $row['productID'];?>" name="<?php echo $row['unit'];?>"> each</label>
              </p>

              <a href="#" class="view-product btn btn-block btn-primary " data-id="<?php echo $row['productID'] ?>" data-bs-toggle='modal' data-bs-target='#product-modal-view'>
                Details
              </a>
              <div class="card-footer p-2">
                      <form action="" class="form-submit">
                        <div class="row p-2">
                          <div class="col-md-6 py-1 pl-1">
                           <b style="color: red;">Quantity:</b>
                          </div>
                          <div class="col-md-6">
                            <input type="number" class="form-control quantity" value="1" min="1">
                          </div>
                          
                        </div>
                        <input type="hidden" class="productID" value="<?= $row['productID'] ?>">
                        <input type="hidden" class="productname" value="<?= $row['productname'] ?>">
                        <input type="hidden" class="price" value="<?= $row['price'] ?>">
                        <input type="hidden" class="imagename" value="<?= $row['imagename'] ?>">
                        <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to cart</button>
                      </form>
                    </div>

            </div>
          </div>
          
        </div>

    <?php
      }
    }
    ?>
  </div>


<script type="text/javascript">

   //when Details is clicked
       $(".view-product").click(function(){
       $("#m-title").text("View Product");
        
             var view = $(this).data('id');
              $.ajax({
                        url: 'view-product.php',
                        type: 'POST',
                        data: {view: view},
                        success: function(response){ 
                            $('.view').html(response); 
                            $('#product-modal-view').modal('show'); 
                        }
                    });
                });

     // send item data to the database
     $(".addItemBtn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var productID = $form.find(".productID").val();
      var productname = $form.find(".productname").val();
      var price = $form.find(".price").val();
      var unit = $form.find(".unit").val();
      var quantity = $form.find(".quantity").val();
      var size = $form.find(".size").val();
      var imagename = $form.find(".imagename").val();

     $.ajax({
  url: 'cart.php',
  type: 'POST',
  data: {
    productID: productID,
    productname: productname,
    price: price,
    quantity: quantity,
    unit: unit,
    size: size,
    imagename: imagename,
  },

        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
        }

      });
      
    });
    
</script>