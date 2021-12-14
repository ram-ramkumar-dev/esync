<?php session_start();    
if($_SESSION['sess_user']){
	echo("<script>location.href = 'dashboard.php';</script>"); 
}else{
	echo("<script>location.href = 'login.php';</script>"); 
}
?>
 