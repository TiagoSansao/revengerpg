<?php 
session_start()
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenge RPG-Login</title>
    <link rel="stylesheet" type="text/css" href="css/registrologin.css">
    <script src="scripts/adjs.js"></script>
    <script>
        if (typeof(adBlock) == 'undefined') {
            setTimeout(function() { window.alert('Tira o adBlock ai compatriota'); }, 3000)
        }
    </script>
</head>
<body>
<?php 

    $erro = '';

    if (isset($_POST['nome']) && isset($_POST['senha'])) {

        $nome = htmlspecialchars($_POST['nome']);
        $senha = htmlspecialchars($_POST['senha']);
        
        try {
            $conn = new PDO('mysql:host=localhost; dbname=braba', 'root', '');
            $query = "select id, nome, senha, registro from usuarios where nome = :nome and senha = :senha";
            $preparado = $conn->prepare($query);
            $preparado->bindParam(':nome', $nome);
            $preparado->bindParam(':senha', $senha);
            $preparado->execute();
            $preparado->setFetchMode(PDO::FETCH_ASSOC);
            $resultados = $preparado->fetch();

            $count = $preparado->rowCount();
            if($count > 0) {
                $_SESSION['id'] = $resultados['id'];
                $_SESSION['nome'] = $resultados['nome'];
                $_SESSION['registro'] = $resultados['registro'];
                header("location:jogo.php");
            } else {
                $erro = 'Credenciais incorretas.';
            }

                

        } catch (PDOexception $e) {
            echo "ERRO" . $e->getMessage();
        }
        $conn = null;
        }   
    ?>
    <div id="interface">
        <header id="cabecalho">
            <h1>Revenge RPG</h1>
            <h2>A vingança está aqui</h2>
        </header>
        <section id="interativo">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <h2>Logue-se</h2>
                <input type="text" placeholder="Apelido" class="input" value="<?php require 'verificacookies.php'?>" name="nome" maxlength="14"/> <br/> <br/>
                <input type="password" placeholder="Senha" class="input" name="senha" maxlength="30"/> <br>
                <span class="erro"> <?php echo $erro; ?> </span> <br/>
                <input type="submit" value="Entrar" class="button" onmouseover="mouseEntra()"  id="entrar"/>
            </form>
            <a class="link" onclick="seFodeu()"> Esqueceu sua senha? </a>
        </section>
        <form id="registro" action="registro.php" method="post">  
            <button id="registroButton" onmouseover="mouseEntra()">Não cadastrado? Registre-se.</button>
        </form>
        <footer id="rodape">
            Brabissímo Tiago &copy; 2020 - <?php echo date("Y"); ?> <br/>
            <a href="http://www.youtube.com/c/SpiderAura" target="_blank">Youtube</a> │ <a href="http://www.facebook.com" target="_blank">Facebook</a>
        </footer>
    </div>
    <script src="scripts/interatividade.js"> </script>
</body>
</html>