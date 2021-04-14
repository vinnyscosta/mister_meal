<?php
	session_start();
		
	if($_SESSION["logado"]!="ok"){
		
		header("Location: login.php");
	}
	
	session_destroy();
	header("Location: login.php");
	
	
?>