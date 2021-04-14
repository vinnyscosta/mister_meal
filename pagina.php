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
			body{
				background:#CCE2FF;
			}
            .container {
                align:center;
                border:1px solid;
                border-radius:20px;
            }
            .logo {
                height: 10em;
                display: flex;
                align-items: center;
                justify-content: center
            } 
	</style>
        <link rel="stylesheet" href="css/mm.css">
	</head>
	<body>
	
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
	
    $PRATO_ESCOLHIDO=@$_POST['tipo_escolhido'];

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
					<a class="nav-link" href="index.php">Home <span class="sr-only">(página atual)</span></a>
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
					  Pratos
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
							while ($row = mysqli_fetch_array($resultado)) {
								echo "<form action='pagina_lista.php' method='post'><tr><td><input class='dropdown-item' name='tipo_escolhido' type='submit' value='".$row[1]."' action='pagina_lista.php' method='post'></td></tr></form>";
										
							}

							mysqli_free_result($resultado);
						?>
					</div>
				  </li>
				  <li class="nav-item">
					<?php if($usuariologado != ''){echo "<a class='nav-link' href='carrinho.php'>Carrinho</a>";}?>
				  </li>
				</ul>
				<form class="form-inline my-2 my-lg-0" action='busca.php' method='post'>
				  <input class="form-control mr-sm-2" type="search" name='busca' placeholder="Pesquisar" aria-label="Pesquisar">
				  <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Pesquisar</button>
				</form>
		  </div>
		</nav>
		
		<br>
		
		<div class="container">
		<?php
			$query_select = "SELECT pratos.cod_prato, pratos.nome_prato, pratos.cod_tipo, pratos.preco_prato, pratos.descricao_prato, pratos.disponibilidade
            FROM `pratos` 
            INNER JOIN tipo_pratos ON tipo_pratos.cod_tipo = pratos.cod_tipo
            WHERE tipo_pratos.nome_tipo = '".$TIPO_ESCOLHIDO."' AND pratos.disponibilidade = 'DISPONIVEL'";
			$resultado_select = mysqli_query($mysqli,$query_select);
			
			if (!$resultado_select) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				echo "erro";
				die($message);
			}else{
				echo "<h3>Perfil de ".$USUARIO."</h3>";
				while ($row = mysqli_fetch_array($resultado_select)) {
					echo "<p>Nome Completo: ".$row[0]."</p>";
					echo "<p>Telefone: ".$row[1]."</p>";
					echo "<p>E-mail: ".$row[2]."</p>";
				}
			}
			mysqli_free_result($resultado_select);
		?>
		<a href="altera_perfil.php">Alterar dados aqui...</a>
		</div>
        <br>
		
		<div class="footer">
			<div>
                <h3><a class="nav-link" href="Sobre.php" style="color:white;">Sobre nós</a></h3>
            </div>
            <div>
                <h3 style="text-align:center;color:white;">Redes Sociais</h3>
                <br>Instagram: <a class="link" href="https://www.instagram.com/mistermealdelivery/" style="color:white;">@mistermealdelivery</a>
                <br>Facebook: <a class="link" href="https://www.facebook.com/mistermealdelivery" style="color:white;">Mister Meal Delivery</a>
                <br>Email: mistermealdelivery@hotmail.com
            </div>
            <div>
                <h3><a class="nav-link" href="perguntas.php" style="color:white;">Perguntas Frequentes</a></h3>
            </div>
		</div>
        <br>
		

		<!-- JavaScript (Opcional) -->
		<!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>