<?php session_start();   
include("dbconnect.php");
 if($_SESSION['sess_user']){
	echo("<script>location.href = 'dashboard.php';</script>"); 
}  
?>
<html>
<head>
<title>Login</title>
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
//Login Button Submitted
if(isset($_POST["login"])){  
  
	// Checking validation
	if(!empty($_POST['email']) && !empty($_POST['password'])) {  
		
		$email=$_POST['email'];  
		$password=$_POST['password'];   
	  
		$query="SELECT * FROM users WHERE email='".$email."' AND password='".md5($password)."'";  
		 
		$res=mysqli_query($conn,$query);
		
		//Checking with right credentials
		$numrows=mysqli_num_rows($res); 
		
		if($numrows!=0)  {  
			while($row=mysqli_fetch_assoc($res))  {  
				$dbemail=$row['email'];  
				$dbuser_id=$row['user_id'];  
				$dbpassword=$row['password'];   
			}   
			//Set the session
			$_SESSION['sess_user_email']=$dbemail;   
			$_SESSION['sess_user']=$dbuser_id;   
			//redirecting to the dashboard page
			echo("<script>location.href = 'dashboard.php';</script>"); 
		} else {  
			echo "Invalid username or password!";  
		}  
	  
	} else {  
		echo "All fields are required!";  
	}  
}  
 
?>  
<div id="content" class="flex">
    <div class="">
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row">
                    <div class="col-md-12">
						<p style="color:green;">	
							<?php if(isset($_SESSION['success'] )) {
									echo $_SESSION['success'];
									unset($_SESSION['success']);
								}   ?>
						</p>
						 
                        <div class="card">
                            <div class="card-header"><strong>Login to your account</strong></div>
                            <div class="card-body">
                               <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                
									<div class="form-group"><label class="text-muted" for="exampleInputEmail1">Email address</label><input required type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email"> </div>
                                  
									<div class="form-group"><label class="text-muted" for="exampleInputPassword1">Password</label><input required type="password" class="form-control" id="exampleInputPassword1" name="password"  placeholder="Password">  </div>
                                 
									<div class="form-group"><a href="forgotpassword.php"> Forgot Password? </a></div>
                                    
									<button type="submit" name="login" class="btn btn-primary">Login</button>
									<a href="register.php"><button type="button" class="btn btn-primary">Register</button></a>
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