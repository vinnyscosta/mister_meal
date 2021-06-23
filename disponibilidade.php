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
	
	$EMAIL=@$_POST['email'];
	$SENHA=@$_POST['senha'];
	$LOG_STATUS=$usuariologado;

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
	
		<!-- Meta tags Obrigatórias -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

		<title>Home - Mister Meal Delivery !</title>
		<style type="text/css">
			.carousel-inner {
			  border-radius:20px;
			}
			body{
				background:#CCE2FF;
			}
			#pagina{
				background:#FFFFFF;
			}
			.produtos li{
				display:inline-block;
				text-align:center;
				width:25%;
				height:420px;
				vertical-align: top;
				margin:0 0.5%;
				padding:30px 20px;
				box-sizing: border-box;
				border:1px solid #000000;
				border-radius: 10px;
			}
			.produtos li:hover{
				border-color: #BBD1FF;
			}

			.produtos li:active{
				border-color: #BBD1FF;
			}

			.produtos li:hover h2{
				font-size: 34px;
			}
		</style>
	</head>
	<body>
	
	<?php
	
	$TIPO_ESCOLHIDO=@$_GET['tipo_escolhido'];
	
		$query_search = "SELECT * FROM `funcionarios` WHERE email_func = '".$usuariologado."'";
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
	
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		  <a class="navbar-brand" href="#">
			<img src="img/logo.svg" width="40" height="40" class="d-inline-block align-top" alt="">
			Mister Meal Delivery !
		  </a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
				<ul class="navbar-nav mr-auto">
				  <li class="nav-item active">
					<a class="nav-link" href="adm.php">Home <span class="sr-only">(página atual)</span></a>
				  </li>
				  <li class="nav-item">
					<?php
						if($usuariologado == ''){
							echo "<a class='nav-link' href='login.php'>Login</a>";
						} else {
							echo "<li class='nav-item dropdown'>
								<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
								  ".$USUARIO."
								</a>
								<div class='dropdown-menu' aria-labelledby='navbarDropdown'>
								  <a class='dropdown-item' href='perfil.php'>Ver Perfil</a>
								  <a class='dropdown-item' href='endereco.php'>Endereços de entrega</a>
								  <a class='dropdown-item' href='#'>Pedidos Recentes</a>
								  <div class='dropdown-divider'></div>
								  <a class='dropdown-item' href='sair.php'>Sair</a>
								</div>
								</li>";
							}
					?>
				  </li>
				  <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  Status Pratos
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<?php
							$query_tipo = "SELECT * FROM tipo_pratos";
							$resultado = mysqli_query($mysqli,$query_tipo);
												
							if (!$resultado) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								$message .= 'Whole query: ' . $query;
								echo "erro";
								die($message);
							}
							echo "<form action='disponibilidade.php' method='get'>";
							while ($row = mysqli_fetch_array($resultado)) {
								//echo "<a class='dropdown-item' href='index.php' name='tipo_escolhido' value='".$row[0]."'>".$row[1]."</a>";
								echo "<tr><td><input class='dropdown-item' name='tipo_escolhido' type='submit' value='".$row[1]."' action='index.php' method='post'></td></tr>";
							}
							echo "</form>";

							mysqli_free_result($resultado);
						?>
					</div>
				  </li>
				  <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  Cadastros
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					  <a class="dropdown-item" href="cad_tipo_pratos.php">Tipo de Prato</a>
					  <a class="dropdown-item" href="cad_pratos.php">Prato</a>
					</div>
				  </li>
				  <li class="nav-item">
					<a class="<?php if($usuariologado == ''){echo "nav-link disabled";} else {echo "nav-link";}?>" href="carrinho.php">Pedidos</a>
				  </li>
				</ul>
                <!--
				<form class="form-inline my-2 my-lg-0">
				  <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
				  <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Pesquisar</button>
				</form>
                -->
		  </div>
		</nav>
		
		<br>
		
		<?php
		if ($TIPO_ESCOLHIDO==''){
			echo "<main>";
			echo "
				<div class='container'>
					<div id='carouselExampleIndicators' class='carousel slide' data-ride='carousel'>
					  <ol class='carousel-indicators'>
						<li data-target='#carouselExampleIndicators' data-slide-to='0' class='active'></li>
						<li data-target='#carouselExampleIndicators' data-slide-to='1'></li>
						<li data-target='#carouselExampleIndicators' data-slide-to='2'></li>
					  </ol>
					  <div class='carousel-inner'>
						<div class='carousel-item active'>
						  <img class='d-block w-100' src='img/1.jpg' width='400' height='400' alt='Primeiro Slide'>
						  <div class='carousel-caption d-none d-md-block'>
							<h5>Prato 1</h5>
							<p>ingredientes</p>
						  </div>
						</div>
						<div class='carousel-item'>
						  <img class='d-block w-100' src='img/2.jpg' width='400' height='400' alt='Segundo Slide'>
						  <div class='carousel-caption d-none d-md-block'>
							<h5>Prato 2</h5>
							<p>ingredientes</p>
						  </div>
						</div>
						<div class='carousel-item'>
						  <img class='d-block w-100' src='img/3.jpg' width='400' height='400' alt='Terceiro Slide'>
						  <div class='carousel-caption d-none d-md-block'>
							<h5>Prato 3</h5>
							<p>ingredientes</p>
						  </div>
						</div>
					  </div>
					  <a class='carousel-control-prev' href='#carouselExampleIndicators' role='button' data-slide='prev'>
						<span class='carousel-control-prev-icon' aria-hidden='true'></span>
						<span class='sr-only'>Anterior</span>
					  </a>
					  <a class='carousel-control-next' href='#carouselExampleIndicators' role='button' data-slide='next'>
						<span class='carousel-control-next-icon' aria-hidden='true'></span>
						<span class='sr-only'>Próximo</span>
					  </a>
					</div>
				</div>
				";
		} else {
			echo "<div class='container' id='pagina'>";
			$query_select = "SELECT pratos.cod_prato, pratos.nome_prato, pratos.cod_tipo, pratos.preco_prato, pratos.descricao_prato, pratos.disponibilidade
				FROM `pratos` 
				INNER JOIN tipo_pratos ON tipo_pratos.cod_tipo = pratos.cod_tipo
				WHERE tipo_pratos.nome_tipo = '".$TIPO_ESCOLHIDO."'";
			$resultado_select = mysqli_query($mysqli,$query_select);
			
			if (!$resultado_select) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				echo "erro";
				die($message);
			}else{
				echo "<ul class='produtos'>";
				echo "<caption><h3>".$TIPO_ESCOLHIDO."</h3></caption><br>";
				//echo "<tr><th>ID</th><th>Item</th><th>Quantidade</th></tr>";
				while ($row = mysqli_fetch_array($resultado_select)) {
					//echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td><input type='number' min='0' max='10000' class='form-control' id='preco' name='preco' value='".$row[3]."' required></td></tr>";
					echo "<li>
                            <form action='disponibilidade.php' method='post'>
                                <img src='img/".$row[0].".jpg' width='200' height='200'>
                                <h5>".$row[1]."</h5>
                                <p class='produto-descricao'>".$row[4]."</p>
                                <p class='produto-preco'>".$row[3]."</p>
                                <p>";
                                    if($row[5]=='DISPONIVEL'){
                                       echo "<input type='submit' class='btn btn-success' value='DISPONIVEL'>";
                                    }else{
                                        echo "<input type='submit' class='btn btn-danger' value='INDISPONIVEL'>";
                                    }
                                echo "
                                </p>
                            <form>
						</li>";
				}
				echo "</table>";
			}
			mysqli_free_result($resultado_select);
			echo "</div>";
			echo "</main>";
		}
		?>
		
		<br>
		
		<?php
		//echo "<h5>".$TIPO_ESCOLHIDO."</h5>";
		?>

		<!-- JavaScript (Opcional) -->
		<!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>