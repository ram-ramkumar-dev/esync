<?php 
session_start();
include("dbconnect.php");
 if($_SESSION['sess_user']){
	echo("<script>location.href = 'dashboard.php';</script>"); 
}else{
	echo("<script>location.href = 'login.php';</script>"); 
} 
?>
<html>
<head>
<title>Register</title>
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
 //Register Button Submitted and creating a user.
if (isset($_POST['register'])) {
	
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']); 
		$error = false;
		
	$sql=mysqli_query($conn,"SELECT * FROM users where Email='$email'");
		if(mysqli_num_rows($sql)>0){
			$emailexists =  "Email Id Already Exists"; 
			 $error = true;
		}else{ 
		
		
	if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
		$name_error = "Name must contain only alphabets and space";
		$error = true;
	}
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$email_error = "Please Enter Valid Email ID";
		$error = true;
	}
		if(strlen($password) < 6) {
			$password_error = "Password must be minimum of 6 characters";
			$error = true;
		}       
			if(strlen($mobile) < 10) {
				$mobile_error = "Mobile number must be minimum of 10 characters";
				$error = true;
			}
			if($password != $cpassword) {
				$cpassword_error = "Password and Confirm Password doesn't match";
				$error = true;
			}
			if ($error == false) {
				if(mysqli_query($conn, "INSERT INTO users(name, email, mobile ,password,status) VALUES('" . $name . "', '" . $email . "', '" . $mobile . "', '" . md5($password) . "','1')")) {
				$_SESSION['success']="Thank you for registration, Please Login to proceed.";   
				echo("<script>location.href = 'login.php';</script>"); 
				//header("location: registration.php");
				//exit();
			} else {
				echo "Error: " . $sql . "" . mysqli_error($conn);
			}
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
                            <div class="card-header"><strong>Register</strong></div>
                            <div class="card-body">
								<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
									<div class="form-group">
									<label>Name</label>
									<input type="text" name="name" class="form-control" value="" maxlength="50" required="">
									<span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
									</div>
									<div class="form-group ">
									<label>Email</label>
									<input type="email" name="email" class="form-control" value="" maxlength="30" required="">
									<span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?><?php if (isset($emailexists)) echo $emailexists; ?></span>
									</div>
									<div class="form-group">
									<label>Mobile</label>
									<input type="text" name="mobile" class="form-control" value="" maxlength="10" required="">
									<span class="text-danger"><?php if (isset($mobile_error)) echo $mobile_error; ?></span>
									</div>
									<div class="form-group">
									<label>Password</label>
									<input type="password" name="password" class="form-control" value="" maxlength="8" required="">
									<span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
									</div>  
									<div class="form-group">
									<label>Confirm Password</label>
									<input type="password" name="cpassword" class="form-control" value="" maxlength="8" required="">
									<span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
									</div>
									<button type="submit" name="register" class="btn btn-primary">Register</button>
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