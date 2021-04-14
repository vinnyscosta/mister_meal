<!DOCTYPE html>
<html lang="pt-br">

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
		
			echo $COD_USUARIO;
	}
	
	?>

	<?php
		$CEP=@$_POST['cep'];
		$RUA=@$_POST['rua'];
		$NUMERO=@$_POST['numero'];
		$COMPLEMENTO=@$_POST['complemento'];
		$BAIRRO=@$_POST['bairro'];
		$CIDADE=@$_POST['cidade'];
		$ESTADO=@$_POST['estado'];
		$COD_END=@$_POST['cod_end'];
		$ALTERA=@$_POST['altera'];
		
		if($ALTERA == '1'){
			if($COD_END != ''){
				if($CEP != ''){
					if($RUA != ''){
						if($NUMERO != ''){
							if($COMPLEMENTO != ''){
								if($BAIRRO != ''){
									if($CIDADE != ''){
										if($ESTADO != ''){
											$query_up_end = "UPDATE `endereco` SET `cep`=".$CEP.",`rua`='".$RUA."',`numero`=".$NUMERO.",`complemento`='".$COMPLEMENTO."',`bairro`='".$BAIRRO."',`cidade`='".$CIDADE."',`estado`='".$ESTADO."' WHERE `cod_end`=".$COD_END."";
											if (mysqli_query($mysqli, $query_up_end)) {
												echo "<script>alert('Cadastro realizado com sucesso !');</script>";
												$CEP='';
												$RUA='';
												$NUMERO='';
												$COMPLEMENTO='';
												$BAIRRO='';
												$CIDADE='';
												$ESTADO='';
												$COD_END='';
												$ALTERA='0';
                                                echo "<script>alert!(Endereço alterado);</script>";
                                                header("Location: endereco.php");
											}else{
												echo "<script>alert('ERRO! Tente novamente');</script>";
											}
										}else{ echo "<script>alert('ESTADO');</script>";}
									}else{ echo "<script>alert('CIDADE');</script>";}
								}else{ echo "<script>alert('BAIRRO');</script>";}
							}else{ echo "<script>alert('COMPLEMENTO');</script>";}
						}else{ echo "<script>alert('NUMERO');</script>";}
					}else{ echo "<script>alert('RUA');</script>";}
				}else{ echo "<script>alert('CEP');</script>";}
			}else{ echo "<script>alert('SEM COD. END');</script>";}
		}
											
	?>	

	
	<div class="logo">
	<img src="img/logo.svg" width="100" height="100" class="d-inline-block align-top" alt="">
	<h2>Mister Meal Delivery !</h2>
	</div>
	
	<div class="container">
		<form class="form-horizontal" action="editar_endereco.php" method="post">
		  <div class="form-group" align="center">
		  <h3>Alterar Endereco</h3>
		  </div>
		  <div class="form-group">
			<label for="inputCep" class="col-sm-2 control-label">Cep</label>
			<div class="col-sm-10">
			  <input type="number" class="form-control" id="inputCep" name="cep" placeholder="00000000" <?php echo "value = ".$CEP.""?> required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputRua" class="col-sm-2 control-label">Rua</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="inputRua" name="rua" placeholder="Rua" <?php	echo "value = '".$RUA."'"?> required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputNumero" class="col-sm-2 control-label">Numero</label>
			<div class="col-sm-10">
			  <input type="number" class="form-control" id="inputNumero" name="numero" placeholder="0000" <?php	echo "value = ".$NUMERO.""?> required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputComplemento" class="col-sm-2 control-label">Complemento</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="inputComplemento3" name="complemento" placeholder="Complemento" <?php	echo "value = '".$COMPLEMENTO."'"?> >
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputBairro" class="col-sm-2 control-label">Bairro</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="bairro" name="bairro" placeholder="bairro" <?php	echo "value = '".$BAIRRO."'"?> required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputCidade" class="col-sm-2 control-label">Cidade</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="cidade" name="cidade" placeholder="cidade" <?php	echo "value = '".$CIDADE."'"?> required>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEstado" class="col-sm-2 control-label">Estado</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="inputEstado" name="estado" placeholder="estado" <?php echo "value = '".$ESTADO."'"?> required>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type='hidden' name='altera' VALUE='1'>
				<input type='hidden' name='cod_end' <?php echo "value = '".$COD_END."'"?>>
			  <button type="submit" class="btn btn-outline-primary">Alterar</button>
			  <a href="endereco.php">Voltar...</a>
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