<?php
  include('includes/header.php');
  require_once 'core/init.php';
  $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
?>

<div id='about' class='view' style="height: 50%;background: url('img/2054.jpg')no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;">
      <div class='mask rgba-black-strong'>
        <div class='container-fluid d-flex align-items-center justify-content-center h-100'>
          <div class='row d-flex justify-content-center text-center'>
            <div class=''>
              <!-- Heading -->
              <h1 class='white-text h1-responsive'>Order Failure</h1>
              <a href='products.php' class='btn btn-outline-white'>SHOP MORE<i class='fa fa-shopping-cart ml-2'></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php
$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt="U5A5zpZYXd";
// Salt should be same Post Request 
If (isset($_POST["additionalCharges"])) {
       $additionalCharges=$_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
  } else {
        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
         }
		 $hash = hash("sha512", $retHashSeq);
  
       if ($hash != $posted_hash) {
	       echo "Invalid Transaction. Please try again";
		   } else {
         echo "
          <div class='container-fluid py-4'>
            <div class='card'>
              <div class='card-header' style='background:rgba(0,0,0,.03);'>
                <h3 class='h3-responsive text-center'><b>We are sorry, your order was unsuccessful!</b></h3>
              </div>
              <div class='card-body'>
                <h5 class='h5-responsive px-2 py-3' style='text-align: justify;line-height: 1.5em'>
                  Greetings, from Khadi Premium Cosmetics. We hope you like our product and continue shopping with us!
                </h5>
                <h5 class='h5-responsive px-2 py-1' style='text-align: justify;line-height: 1.5em'>The status of your order is: <b style='color: red;'>$status</b>, and the corresponding transaction ID is: <b style='color: red;'>$txnid</b>.</h5>
                <h5 class='h5-responsive px-2 py-1' style='text-align: justify;line-height: 1.5em'>You may try making the payment by clicking <a href='https://pmny.in/KIjgdreuroQg'>here</a>. If you have any queries related to placing the order or making payment, you can mail us at <a href='mailto:support@khadipremium.in'>support@khadipremium.in</a> or call us on <b>+91 9619531115</b></h5>
              </div>
              <div class='card-footer'>
                <h5 class='h5-responsive text-center'><b>Continue your shopping with us. </b><a href='products.php' style='margin: 0;cursor: pointer;border:none;border-radius: 10em;background: #1c2a48;color:#fff' class='btn btn-md'>SHOP NOW &nbsp;<i class='fa fa-cart-plus'></i></a></h5>
              </div>
            </div>
          </div>";
		 } 
?>

<div class='container-fluid'>
  <h3 class='h3-responsive px-2 py-2'><b>Suggested Items:</b></h3> 

  <?php 
    $sql = 'SELECT * FROM products WHERE featured = 0 AND deleted = 0 AND beauty_regime = 0 ORDER BY RAND() LIMIT 0,4';
    $products = $db->query($sql);
  ?>

  <div class='row'>   
    <?php while($product = mysqli_fetch_assoc($products)): ?>
    <div class='col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-lg-0 mb-4'>         
      <div class='card card-cascade wider card-ecommerce' style='background-color:'>
        <div class='view zoom view-cascade overlay'>
          <?php $photos = explode(',',$product['image']); ?>
          <img src='<?= $photos[0]; ?>' class='card-img-top img-fluid' alt='<?= $product['title']; ?>'>
          <button onclick='detailsmodal(<?= $product['id']; ?>)' style='background: none;border: none;cursor: pointer'><div class='mask rgba-white-slight'></div></button>
        </div>
        <div class='card-body card-body-cascade text-center'>
              <h5>
                  <strong>
              <button onclick='detailsmodal(<?= $product['id']; ?>)' style='background: none;border: none;cursor: pointer;padding-bottom: 1em'><?=$product['title'];?></button><br>
                      <span class='badge badge-pill my-2' style='background-color: #546e7a'>&#8377; <?=$product['price']; ?></span>
                        &nbsp;&nbsp;&nbsp;
                      <span class='badge badge-pill my-2' style='background-color: #546e7a'><?=$product['weight']; ?></span>
                  </strong>
              </h5>
              <h6 class=''><?=$product['short_desc'];?></h6>
          </div>
          <div class='card-footer px-1 px-3 py-3'>

                <span class='float-right'>
                  <button type='button' style='margin: 0;cursor: pointer;border:none;border-radius: 10em;background: #1c2a48' class='btn btn-md' title='Add to Product' onclick='detailsmodal(<?= $product['id']; ?>)'>Add to Cart &nbsp;<i class='fa fa-cart-plus'></i></button>
                </span>
            </div>
      </div>  
      <br>        
    </div>
    <?php endwhile;?> 

  </div>
</div>

<?php
  include('includes/footer.php');
?>