<?php

	session_start(); //inicia a sessão
	if(!isset($_SESSION['logado'])==true) //se não há conteúdo na sessão, volta para index
	{
		unset($_SESSION['usuario']); //retira o usuário da sessão
		unset($_SESSION['logado']); //retira a flag da sessão
		//header("Location: login.php");
	}
	$usuariologado =@$_SESSION['usuario']; //variável recebe o nome q está na sessão

?>
<?php

	require_once "conectadb.php";
	$END=@$_POST['codigo_end'];
	
?>
<?php
	
	$query_search = "SELECT * FROM `clientes` WHERE email_cliente = '".$usuariologado."'";
	$resultado = mysqli_query($mysqli,$query_search);
	
	if (!$resultado) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $query;
		echo "erro";
		die($message);
	}
	
	while ($row = mysqli_fetch_array($resultado)) {
		$COD_USUARIO = $row[0];
		$USUARIO = $row[1];
	}
	
?>
<?php
		$query_cadastro = "DELETE FROM `endereco` WHERE `cod_end` = ".$END." AND `cod_cliente` = '".$COD_USUARIO."'";
		if (mysqli_query($mysqli, $query_cadastro)) {
			echo "<script>alert('Exclusão realizada com sucesso !');</script>";
			header("Location: endereco.php");
		}else{
			echo "<script>alert('ERRO!');</script>";
		}
?>