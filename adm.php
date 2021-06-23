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

		<title>ADM - Mister Meal Delivery !</title>
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
				height:360px;
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
	
	$TIPO_ESCOLHIDO=@$_POST['tipo_escolhido'];
	
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
		<div class='container'>
            <div class="list-group">
            <?php
                $query_select = "SELECT `cod_pedido`, `cod_cliente`, `cod_end`, `cod_meio`, `itens`, `total`, 
                FROM `pedido` WHERE 'status_pedido' = 'ABERTO'";
                $resultado_select = mysqli_query($mysqli,$query_select);
                
                if (!$resultado_select) {
                    echo "<h4>Sem pedidos em aberto.</h4>";
                }else{
                    echo "<ul class='list-group list-group-flush'>";
                    while ($row = mysqli_fetch_array($resultado_select)) {
                        echo 
                        "<li class='list-group-item'>
                            <p>
                                Pedido: #".$row[0]."
                            </p>
                            <p>
                                ".$row[1]."
                            </p>
                            <p>
                                Endereço: ".$row[2]."
                            </p>
                            <pclass='pagamento'>
                                Pagamento por: ".$row[3]."
                            </p>
                            <p class='desc_pedido'>
                                ".$row[4]."
                            </p>
                            <p class='valor'>
                                Valor: ".$row[5]."
                            </p>
                        </li>";
                    }
                    echo "</ul>";
                    echo "<br>";
                    mysqli_free_result($resultado_select);
                }
            ?>
            </div>
        </div>
		
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