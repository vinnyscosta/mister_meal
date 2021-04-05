<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Login - Mister Meal Delivery !</title>
	
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

            $email = @$_POST["email"];
            $senha = @$_POST["senha"];
            $tipo = @$_POST["tipo_login"];

            if(($email != '') && ($senha != '') && ($tipo != '')){
                //iniciar a sessão
                session_start();

                //login e senha : essas variaveis recebem os dados digitados
                //$email = $_POST["email"];
                //$senha = $_POST["senha"];
                //$tipo = $_POST["tipo_login"];
                
                //realizar a conexão com o banco de dados
                //servidor, usuario, senha, nome_base
                $mysqli = new mysqli("localhost","root","","mister_meal"); 
                mysqli_set_charset($mysqli, "utf8");
                
                //realizar consulta no banco de dados, procurar usuario e senha
                if($tipo=='user'){
                    if($resultado = $mysqli->query("SELECT * FROM `clientes` WHERE email_cliente = '$email'  AND senha_cliente = '$senha'")){
                        $qtd_linhas = $resultado->num_rows;
                        
                        $resultado->close();
                    
                        //se a quantidade de linhas for maior que zero, então existe o usuário e a senha
                        if($qtd_linhas > 0)
                        {
                            $_SESSION['usuario'] = $email; //coloca o email do usuário na sessão
                            $_SESSION['logado'] = "ok"; //flag para verificar se está logado ou não
                            
                            header("Location: index.php"); //envia para index.php
                        }
                        else{
                            unset($_SESSION['usuario']); //retira o usuário da sessão
                            unset($_SESSION['logado']); //retira a flag da sessão
                            header("Location: index.php"); //devolvo o usuário para pagina inicial
                        }
                    }//fim do if da consulta
                }else{
                    if($tipo=='admin'){
                        //echo "adm";
                        if($resultado = $mysqli->query("SELECT * FROM `funcionarios` WHERE email_func = '$email'  AND senha_func = '$senha'")){
                            $qtd_linhas = $resultado->num_rows;
                            
                            $resultado->close();
                        
                            //se a quantidade de linhas for maior que zero, então existe o usuário e a senha
                            if($qtd_linhas > 0)
                            {
                                $_SESSION['usuario'] = $email; //coloca o email do usuário na sessão
                                $_SESSION['logado'] = "ok"; //flag para verificar se está logado ou não
                                
                                header("Location: adm.php"); //envia para index.php
                            }
                            else{
                                unset($_SESSION['usuario']); //retira o usuário da sessão
                                unset($_SESSION['logado']); //retira a flag da sessão
                                header("Location: adm.php"); //devolvo o usuário para pagina inicial
                            }
                        }
                    }
                }
            }
        ?>
        <div class="logo">
            <img src="img/logo.svg" width="100" height="100" class="d-inline-block align-top" alt="">
            <h2>Login</h2>
            <img src="img/logo.svg" width="100" height="100" class="d-inline-block align-top" alt="">
        </div>
	
        <div class="container">
            <form class="form-horizontal" action="login.php" method="post">
            <div class="form-group" align="center">
            <h3>Fazer Login</h3>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Senha</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3" name="senha" placeholder="Password">
                <input type="password" class="form-control" id="inputPassword3" name="senha" placeholder="Password" required>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipo_login" id="tipo_login" value="user" checked>
                <label class="form-check-label" for="exampleRadios1">
                    Usuario
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipo_login" id="tipo_login" value="admin">
                <label class="form-check-label" for="exampleRadios2">
                    Administrador
                </label>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                    <input type="checkbox"> Me lembre
                    </label>
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-outline-primary">Sign in</button>
                <a href="cadastro.php">Ou cadastre-se aqui...</a>
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