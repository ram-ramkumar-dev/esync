<?php 
session_start();
include("dbconnect.php");
if(!$_SESSION['sess_user']){ 
	echo("<script>location.href = 'login.php';</script>"); 
}  
?>
<html>
<head>
<title>Dashboard</title>
<link defer type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<style>
body {
    background-color: #f9f9fa
}

.flex {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto
}

@media (max-width:991.98px) {
    .padding {
        padding: 1.5rem
    }
}

@media (max-width:767.98px) {
    .padding {
        padding: 1rem
    }
}

.padding {
    padding: 5rem
}

.card {
    background: #fff;
    border-width: 0;
    border-radius: .25rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
    margin-bottom: 1.5rem
}

.card-header {
    background-color: transparent;
    border-color: rgba(160, 175, 185, .15);
    background-clip: padding-box
}

.card-body p:last-child {
    margin-bottom: 0
}

.card-hide-body .card-body {
    display: none
}

.form-check-input.is-invalid~.form-check-label,
.was-validated .form-check-input:invalid~.form-check-label {
    color: #f54394
} 
</style>
<body>
<?php 

//Deletion of the products
if(isset($_POST['remove_product'])){

  if(isset($_POST['remove'])){
	 
    foreach($_POST['remove'] as $removeid){ 
      $removeproduct = "DELETE from products WHERE product_id=".$removeid;
      mysqli_query($conn,$removeproduct);
    }
  }
 
}
?>
<?php 
// Get products data
$sql="SELECT * FROM products WHERE user_id='".$_SESSION['sess_user']."' order by product_id desc ";  
 
$res=mysqli_query($conn,$sql);

?>
  
            <div class="padding">
                <div class="row">
						  
						<div class="col-md-12">
						<p style="color:green;">
						<?php if(isset($_SESSION['productseccess'] )) {
									echo $_SESSION['productseccess'];
									unset($_SESSION['productseccess']);
								}   ?></p>
						<div class="card">
                            <div class="card-header"><strong>List Of Products</strong><button style="float: right;"><a href="addproduct.php" style="float: right;font-size: 18px;">Add Product</a></button></div>
                            <div class="card-body">
						  <form method='post' action=''>
							<input type='submit' value='Delete' onclick="return confirm('Are You Sure ?')" name='remove_product'><br><br>	
						  <table class="table table-bordered">
							<thead>
							  <tr>
								<th></th>
								<th>Product Id</th>
								<th>Product Name</th>
								<th>Price</th>
								<th>UPC</th>
								<th>Status</th>
								<th>Image</th>
								<th>Action</th>
							  </tr>
							</thead>
							<tbody>
							  	<?php if($res){ while($product=mysqli_fetch_array($res))  { ?>  
								<tr>
									<td><input type="checkbox" name='remove[]' value="<?php echo $product['product_id']; ?>" /></td>
									<td><?php echo $product['product_id']; ?></td>
									<td><?php echo $product['product_name']; ?></td>
									<td><?php echo $product['price']; ?></td>
									<td><?php echo $product['upc']; ?></td>
									<td><?php	echo  $product['status'] == 1 ? 'Active' : 'In Active' ?></td>
									<td><img src="uploads/<?php echo $product['image']; ?>" width="50px"height="50px"/></td>
									<td><button type="button"><a href="editproduct.php/<?php echo base64_encode($product['product_id']);?>">Edit</a></button></td>
								</tr>
								<?php } } else{ ?>
								<tr><td  colspan="6" >No Products.</td></tr>
								<?php } ?>
							</tbody>
						  </table>
						  </form>
						</div>
				</div>
			</div>
			</div>
		</div> 

</body>
</html>