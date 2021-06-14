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
			#carrinho{
				background:#FFFFFF;
			}
			body{
				background:#CCE2FF;
			}
		</style>
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
	
	$PRECO = 0;
	
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
								//echo "<a class='dropdown-item' href='index.php' name='tipo_escolhido' value='".$row[0]."'>".$row[1]."</a>";
								echo "<form action='pagina_lista.php' method='get'><tr><td><input class='dropdown-item' name='tipo_escolhido' type='submit' value='".$row[1]."' action='pagina_lista.php' method='post'></td></tr></form>";
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
		
		<div class="container" id="carrinho">
			<?php
				echo "<br><div class='titulo' style='text-align: center;'><caption><h3>Finalizar Pedido</h3></caption></div><br>";
				$query_select = "SELECT carrinho.cod_item, pratos.nome_prato, pratos.preco_prato, carrinho.quant 
					FROM carrinho
					INNER JOIN pratos ON pratos.cod_prato = carrinho.cod_prato
					INNER JOIN clientes ON clientes.cod_cliente = carrinho.cod_cliente
					WHERE clientes.username = '".$USUARIO."'";
				$resultado_select = mysqli_query($mysqli,$query_select);
				
				if (!$resultado_select) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					echo "erro";
					die($message);
				}else{
					echo "<table class='table'>";
					echo "<thead><tr><th>Quant.</th><th>Item</th><th>Preço</th></tr></thead>";
					echo "<tbody>";
					while ($row = mysqli_fetch_array($resultado_select)) {
						$PRECO = $PRECO + ( $row[2] * $row[3] );
						echo "<tr>
						<td><b>".$row[3]."x</b></td>
						<td>".$row[1]."</td>
						<td>".$row[2]*$row[3]."</td>
						</tr>";
					}
					echo "</tbody>";
					echo "<tr><td>TOTAL: ".$PRECO."</td></tr>";
					echo "</table>";
				}
				mysqli_free_result($resultado_select);
				
				//--Endereço
				
				$query_end = "SELECT `cod_end`, `cep`, `rua`, `numero`, `complemento` FROM `endereco` WHERE `cod_cliente`=".$COD_USUARIO."";
				$resultado_end = mysqli_query($mysqli,$query_end);
				
				if (!$resultado_end) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					echo "erro";
					die($message);
				}else{
					echo"<div class='form-group'>";
						echo"<label for='exampleFormControlSelect1'><b>Selecione um Endereço</b></label>";
						echo"<select name='cboEndereco'class='form-control' id='exampleFormControlSelect1'>";
						echo "<option value=''>...</option>";
							while ($row = mysqli_fetch_array($resultado_end)) {
								echo "<option value=".$row[0].">".$row[1]."	".$row[2].", ".$row[3]." - ".$row[4]."</option>";
							}
							mysqli_free_result($resultado_end);
						echo"</select>";
					echo"</div><br>";
				}

				//--Pagamento

				$query_pag = "SELECT `cod_meio`, `nome_meio` FROM `meio_pagamento`";
				$resultado_pag = mysqli_query($mysqli,$query_pag);
				
				if (!$resultado_pag) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					echo "erro";
					die($message);
				}else{
					echo"<div class='form-group'>";
						echo"<label for='exampleFormControlSelect1'><b>Selecione um Meio de Pagamento</b></label>";
						echo"<select name='cboPagamento'class='form-control' id='exampleFormControlSelect1'>";
						echo "<option value=''>...</option>";
							while ($row = mysqli_fetch_array($resultado_pag)) {
								echo "<option value=".$row[0].">".$row[1]."</option>";
							}
							mysqli_free_result($resultado_pag);
						echo"</select>";
					echo"</div><br>";
				}
			?>
		
			<br>
			<div class='form-group'>
			<form action='add_pedido.php' method='post' style='text-align: right;'>
				<input class='btn btn-info' name='finalizar' type='submit' value='Confirmar Pedido' align='right'>
			</form>
			</div>
			<br>
		</div>

		

		<!-- JavaScript (Opcional) -->
		<!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>