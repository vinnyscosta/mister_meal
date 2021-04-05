<!DOCTYPE html>
<html lang="pt-br">

<?php

	require_once "conectadb.php";

?>

    <head>
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>Cadastro - Mister Meal Delivery !</title>
	
        <style type="text/css">
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
            body{
                background:#CCE2FF;
            }	  
        </style>
	
    </head>
    <body>
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
						echo "<a class='nav-link' href='login.php'>Login</a>";
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
				</ul>
				<form class="form-inline my-2 my-lg-0" action='busca.php' method='post'>
				  <input class="form-control mr-sm-2" type="search" name='busca' placeholder="Pesquisar" aria-label="Pesquisar">
				  <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Pesquisar</button>
				</form>
		  </div>
		</nav>
	<?php
		$USERNAME=@$_POST['username'];
		$NOME=@$_POST['nome'];
		$TEL=@$_POST['telefone'];
		$EMAIL=@$_POST['email'];
		$SENHA=@$_POST['senha'];
		
		if($USERNAME != ''){
			if($NOME != ''){
				if($TEL != ''){
					if($EMAIL != ''){
						if($SENHA != ''){
							$query_cadastro = "INSERT INTO `clientes`(`username`, `nome_cliente`, `tel_cliente`, `email_cliente`, `senha_cliente`) VALUES ('".$USERNAME."','".$NOME."','".$TEL."','".$EMAIL."','".$SENHA."')";
							if (mysqli_query($mysqli, $query_cadastro)) {
								echo "<script>alert('Cadastro realizado com sucesso !');</script>";
								$USERNAME='';
								$NOME='';
								$TEL='';
								$EMAIL='';
								$SENHA='';
                                header("Location: login.php");
							}else{
								echo "<script>alert('ERRO! Tente novamente');</script>";
							}
						}
					}
				}
			}
		}
	?>
	
	<div class="logo">
	<img src="img/logo.svg" width="100" height="100" class="d-inline-block align-top" alt="">
	<h2>Cadastro</h2>
    <img src="img/logo.svg" width="100" height="100" class="d-inline-block align-top" alt="">
	</div>
	
	<div class="container">
		<form class="form-horizontal" action="cadastro.php" method="post">
        <br>
		  <div class="form-group">
			<label for="inputusername" class="col-sm-2 control-label">Username</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputName" class="col-sm-2 control-label">Nome</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="inputName" name="nome" placeholder="Nome Completo" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputtelefone" class="col-sm-2 control-label">Telefone</label>
			<div class="col-sm-10">
			  <input type="tel" class="form-control" id="inputtelefone" name="telefone" placeholder="Telefone" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
			  <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Senha</label>
			<div class="col-sm-10">
			  <input type="password" class="form-control" id="inputPassword3" name="senha" placeholder="Password" required>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-outline-primary">Cadastre-se</button>
			  <a href="login.php">Ou faça login aqui...</a>
			</div>
		  </div>
		</form>
	</div>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>