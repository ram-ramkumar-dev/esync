<?php 
session_start();
include("dbconnect.php");
 if(!$_SESSION['sess_user']){ 
	echo("<script>location.href = 'login.php';</script>"); 
} 
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
$id = base64_decode($uri_segments[3]); 
?>
<html>
<head>
<title>Edit Product</title>
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

// Get products data
$sql="SELECT * FROM products WHERE product_id='".$id."' ";  
 
$res=mysqli_query($conn,$sql);

$pro=mysqli_fetch_array($res);



 //Edit Button Submitted and updation of the product
if (isset($_POST['edit_product'])) {
	
		$product_name = mysqli_real_escape_string($conn, $_POST['product_name']); 
		$price = mysqli_real_escape_string($conn, $_POST['price']); 
		$upc = mysqli_real_escape_string($conn, $_POST['upc']);  
		$error = false;
		 
			if($_FILES['image']['name']){
		
				 $image=$_FILES['image']['name']; 
				 $new_image=explode('.',$image);
				
				 $type=$new_image[1];   
				 $rand=rand(10000,99999);
				 $new_name=$rand;
				 $imagename=md5($new_name).'.'.$type;
				 $imagepath="uploads/".$imagename;
				 move_uploaded_file($_FILES["image"]["tmp_name"],$imagepath);
			
			} else{
				$imagename = $pro['image'];
			}
 
			if ($error == false) {
				if(mysqli_query($conn, "UPDATE products SET product_name = '".$product_name."', price = '".$price."', upc = '".$upc."', image = '".$imagename."' WHERE product_id = '".$id."' ")) {
				$_SESSION['productseccess']="Your Product is edited Successfully";   
				echo("<script>location.href = '../dashboard.php';</script>"); 
				 
			} else {
				echo "Error: " . $sql . "" . mysqli_error($conn);
			}
		}
	 
mysqli_close($conn);
}
?>
<div id="content" class="flex">
    <div class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header"><strong>Edit Product</strong></div>
                            <div class="card-body">
								<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data">
									<div class="form-group">
									<label>Product Name</label>
									<input type="text" name="product_name" class="form-control" value="<?php echo $pro['product_name']; ?>" maxlength="50" required="">
									<span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
									</div>
									<div class="form-group ">
									<label>Price</label>
									<input type="number" name="price" class="form-control" value="<?php echo $pro['price']; ?>" maxlength="30" required="">
									<span class="text-danger"><?php if (isset($price_error)) echo $email_error; ?> </span>
									</div>
									<div class="form-group">
									<label>Universal Product Code</label>
									<input type="text" name="upc" class="form-control" value="<?php echo $pro['upc']; ?>" maxlength="10" required="">
									<span class="text-danger"><?php if (isset($upc_error)) echo $upc_error; ?></span>
									</div>
									<div class="form-group">
									<label>Image</label>
									<input type="file" name="image" class="form-control" value="" >
									 
									</div>   
									<button type="submit" name="edit_product" class="btn btn-primary">Edit Product</button>
									<a href="dashboard.php"><button type="button" class="btn btn-primary">Back</button></a>
								</form>


                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>