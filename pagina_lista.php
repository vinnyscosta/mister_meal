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
        <link rel="stylesheet" href="css/mm.css">
		<title>Home - Mister Meal Delivery !</title>
		<style type="text/css">
			
			body{
				background:#CCE2FF;
			}
			
			#pagina{
				background:#FFFFFF;
			}
			
			.titulo{
				text-align:center;
			}

		</style>
	</head>
	<body>
	
	<?php
	
	$TIPO_ESCOLHIDO=@$_POST['tipo_escolhido'];
	
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
								  <a class='dropdown-item' href='pedidos_feitos.php'>Pedidos Recentes</a>
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
							//
							while ($row = mysqli_fetch_array($resultado)) {
								//echo "<a class='dropdown-item' href='index.php' name='tipo_escolhido' value='".$row[0]."'>".$row[1]."</a>";
								echo "<form action='pagina_lista.php' method='post'><tr><td><input class='dropdown-item' name='tipo_escolhido' type='submit' value='".$row[1]."' action='pagina_lista.php' method='post'></td></tr></form>";
							}
							//echo "</form>";

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
		
		<?php
		if ($TIPO_ESCOLHIDO==''){
			echo "Nenhum tipo selecionado.";
		} else {
			echo "<main>";
			echo "<div class='container' id='pagina'>";
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
				echo "<br><div class='titulo'><caption><h3>".$TIPO_ESCOLHIDO."</h3></caption></div><br>";
				echo "<div class='lista_produtos' class='list-group'>";
				//echo "<tr><th>ID</th><th>Item</th><th>Quantidade</th></tr>";
				while ($row = mysqli_fetch_array($resultado_select)) {
					//echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td><input type='number' min='0' max='10000' class='form-control' id='preco' name='preco' value='".$row[3]."' required></td></tr>";
					echo "<div class='produtos'>
							<a href='#' class='list-group-item list-group-item-action'>
								<div class='divfoto'>
									<img class='foto' src='img/".$row[0].".jpg'>
								</div>
                                <br>
								<div clas='desc'>
									<h5>".$row[1]."</h5>
									<h6 class='produto-descricao'>".$row[4]."<h6>
									<h5 class='produto-preco'>".$row[3]."<h5>
								</div>
                                <br>
								<div class='adic'>
								<form action='add_carrinho.php' method='post'>
									<input type='hidden' name='item_escolhido' VALUE='".$row[0]."'>
									<input class='btn btn-info' name='item' type='submit' value='Adicionar ao carrinho'>
								</form>
								</div>
							</a>
						</div>";
				}
				
				echo "<caption>Produtos do tipo ".$TIPO_ESCOLHIDO."</caption><br>";
				echo "</div>";
			}
			mysqli_free_result($resultado_select);
            echo "<br>";
			echo "</div>";
			echo "</main>";
		}
		?>
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