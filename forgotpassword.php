<?php session_start();   
include("dbconnect.php");
 if($_SESSION['sess_user']){
	echo("<script>location.href = 'dashboard.php';</script>"); 
}  
?>
<html>
<head>
<title>Password Reset</title>
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

// Reset Password Button Submitted
if (isset($_POST['new_password'])) {
  $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
  $new_pass_c = mysqli_real_escape_string($conn, $_POST['new_pass_c']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $error = false;	
  
	$sql=mysqli_query($conn,"SELECT * FROM users where email='$email'");
		if(mysqli_num_rows($sql)==0){
			$emailnotfound =  "Email Id Not Found."; 
			 $error = true;
		}else{ 
  
  
		  if (empty($new_pass) ){ $pass_error = "Password is required";  $error = true; }
		  if (empty($new_pass_c)){ $conf_error = "Confirm Password is required";  $error = true; }
		  if ($new_pass !== $new_pass_c){ $match = "Password do not match";  $error = true; }  
		  if ($error == FALSE) { 
			  $new_pass = md5($new_pass);
			  $sql = "UPDATE users SET password='$new_pass' WHERE email='$email'";
			  $results = mysqli_query($conn, $sql); 
			  $_SESSION['success']="Password Successfully changed, Please Login to continue.";   
			  echo("<script>location.href = 'login.php';</script>"); 
			}
		}
}

 
?>  
<div id="content" class="flex">
    <div class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row">
                    <div class="col-md-12"> 
						 
                        <div class="card">
                            <div class="card-header"><strong>Password Reset </strong></div>
                            <div class="card-body">
                             <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                
									<div class="form-group"><label class="text-muted" >Email</label><input required type="email" class="form-control" name="email" placeholder="Email"><span class="text-danger"><?php if (isset($emailnotfound)) echo $emailnotfound; ?></span> </div>
									
									<div class="form-group"><label class="text-muted" >New Password</label><input required type="password" class="form-control" name="new_pass" placeholder="New Password"><span class="text-danger"><?php if (isset($pass_error)) echo $pass_error; ?></span> </div>
                                  
									<div class="form-group"><label class="text-muted">Confirm new password</label><input required type="password" class="form-control"  name="new_pass_c"  placeholder="Confirm new password"><span class="text-danger"><?php if (isset($conf_error)) echo $conf_error; ?><?php if (isset($match)) echo $match; ?></span>  </div>
                                  
                                    
									<button type="submit" name="new_password" class="btn btn-primary">Reset Password</button>
									<a href="login.php"><button type="button" class="btn btn-primary">Login</button></a>
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