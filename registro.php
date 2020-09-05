

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Revenge RPG-Registro</title>
    <link rel="stylesheet" type="text/css" href="css/registrologin.css"/>
    <link rel="shortcut icon" type="image/x-icon" href="ativos/favicon.ico"/>
</head>
<body>
        <?php 
            $nome = '';
            $nomeErr = '';
            $senha = '';
            $senhaErr = '';


            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                if (empty($_POST['nome'])) {
                    $nomeErr = "Um nome é necessário.";
                    $nomecerto = false;
                } else {
                    if (ctype_alnum(htmlspecialchars($_POST['nome'])) == true && ctype_space(htmlspecialchars($_POST['nome'])) == false){
                        $algarismocerto = true;
                    } else {
                        $nomeErr = 'Apenas letras e números são permitidos.';
                        $algarismocerto = false;
                    }
                }

                if (empty($_POST['senha'])) {
                    $senhaErr = "Uma senha é necessária.";
                    $senhacerta = false;
                } else {
                    $senhacerta = true;
                }

                if (isset($_POST['nome']) && isset($_POST['senha'])) {
                    $nomedb = htmlspecialchars($_POST['nome']);
                    $senhadb = htmlspecialchars($_POST['senha']);
                    try {
                        $conn = new PDO("mysql:host=localhost; dbname=braba", "root", "");
                        $sql = "select * from usuarios where nome = :nome";
                        $preparado = $conn->prepare($sql);
                        $preparado->bindParam(':nome', $nomedb);
                        $preparado->execute();
                            
                        $count = $preparado->rowCount();
                        if ($count == 0) {
                            $nomecerto = true;
                        } else {
                            $nomecerto = false;
                            $nomeErr = "O nome: {$nomedb} já está em uso.";
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    $conn = null;
                }
                
                
                if ($nomecerto == true && $senhacerta == true && $algarismocerto == true) {
                    setcookie('nome', $nomedb, "/");
                    $ip = $_SERVER['REMOTE_ADDR'];
                    try {
                        $conn = new PDO('mysql:host=localhost; dbname=braba', 'root', '');
                        $preparado = $conn->prepare("insert into usuarios (id, nome, senha, ip) values (default, :nome, :senha, :ip)");
                        $preparado->bindParam(':ip', $ip);
                        $preparado->bindParam(':senha', $senhadb);
                        $preparado->bindParam(':nome', $nomedb);
                        $preparado->execute();
                    } catch (PDOexception $e) {
                        echo "ERRO" . $e->getMessage();
                    }
                    $conn = null;
                    exit(header("location: login.php"));
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
<script src="scripts/loginregistro.js"> </script>
</html>
