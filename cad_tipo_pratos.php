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

    <title>Cadastro Tipo - Mister Meal Delivery !</title>
	
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
	
	<?php
		$NOME=@$_POST['nome'];
		$DESCRICAO=@$_POST['descricao'];
		
		if($NOME != ''){
			if($DESCRICAO != ''){
				$query_cadastro = "INSERT INTO `tipo_pratos`(`nome_tipo`, `descricao_tipo`) VALUES ('".$NOME."','".$DESCRICAO."')";
				if (mysqli_query($mysqli, $query_cadastro)) {
					echo "<script>alert('Cadastro realizado com sucesso !');</script>";
					$NOME='';
					$DESCRICAO='';
				}else{
					echo "<script>alert('ERRO!');</script>";
				}
			}
		}
	?>
	
	<div class="logo">
	<img src="img/logo.svg" width="100" height="100" class="d-inline-block align-top" alt="">
	<h2>Mister Meal Delivery !</h2>
	</div>
	
	<div class="container">
		<form class="form-horizontal" action="cadastro_tipo_prato.php" method="post">
		  <div class="form-group" align="center">
		  <h3>Cadastro Tipo de Prato</h3>
		  </div>
		  <div class="form-group">
			<label for="inputName" class="col-sm-2 control-label">Nome</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="inputName" name="nome" placeholder="Nome" required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputdescricao" class="col-sm-2 control-label">Descrição</label>
			<div class="col-sm-10">
			  <textarea class="form-control" id="inputdescricao" name="descricao" placeholder="Descrição..." rows="3" required></textarea>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
			  <a href="adm.php">Voltar...</a>
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