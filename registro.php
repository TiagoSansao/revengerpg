<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenge RPG-Registro</title>
    <link rel="stylesheet" type="text/css" href="css/registrologin.css">
</head>
<body>
        <?php 
            $nome = '';
            $nomeErr = '';
            $senha = '';
            $senhaErr = '';

            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                function ajeitarInput($input) {
                    $input = trim($input);
                    $input = stripslashes($input);
                    $input = htmlspecialchars($input);
                    return $input;
                }

                if (empty($_POST['nome'])) {
                    $nomeErr = "Um nome é necessário.";
                    $nomecerto = false;
                } else {
                    if (!preg_match("/^[a-zA-Z-' ]*$/", ajeitarInput($_POST['nome']))){
                        $nomeErr = 'Nome com caracteres inválidos.';
                        $nomecerto = false;
                    } else {
                        $nomecerto = true;
                    }
                }

                if (empty($_POST['senha'])) {
                    $senhaErr = "Uma senha é necessária.";
                    $senhacerta = false;
                } else {
                    $senhacerta = true;
                }
                
                if ($nomecerto == true && $senhacerta == true) {
                    $nomedb = htmlspecialchars($_POST['nome']);
                    $senhadb = htmlspecialchars($_POST['senha']);
                    setcookie('nome', $nomedb, "/");
                    header("location:login.php");
                    try {
                        $conn = new PDO('mysql:host=localhost; dbname=braba', 'root', '');
                        $preparado = $conn->prepare("insert into usuarios (id, nome, senha) values (default, :nome, :senha)");
                        $preparado->bindParam(':senha', $senhadb);
                        $preparado->bindParam(':nome', $nomedb);
                        $preparado->execute();
                    } catch (PDOexception $e) {
                        echo "ERRO" . $e->getMessage();
                    }
                    $conn = null;
                }
        }
        ?>
    <div id="interface">
        <header id="cabecalho">
            <h1>Revenge RPG</h1>
            <h2>A vingança está aqui</h2>
        </header>

        <section id="interativo">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <h2>Registre-se</h2>
                <input type="text" placeholder="Apelido" class="input"  name="nome" maxlength="14"/> <br> <span class="erro"> <?php echo $nomeErr;?></span><br/>
                <input type="password" placeholder="Senha" class="input" name="senha" maxlength="30"/> <br> <span class="erro"> <?php echo $senhaErr?> </span> <br/>
                <input type="submit" value="Registrar" onmouseover="mouseEntra()" class="button" id="registrar"/> <br> <br>
            </form>
        </section>
        <form id="voltarLogin" action="login.php" method="post">  
            <button id="voltarLoginButton" onmouseover="mouseEntra()">Voltar para o Login</button>
        </form>
        <footer id="rodape">
        Brabissímo Tiago &copy; 2020 - <?php echo date("Y"); ?> <br/>
            <a href="http://www.youtube.com/c/SpiderAura" target="_blank">Youtube</a> │ <a href="http://www.facebook.com" target="_blank">Facebook</a>
        </footer>
    </div>
</body>
<script src="scripts/interatividade.js"> </script>
</html>