<?php

session_start();
if (!isset($_SESSION['nome'])) {
    header("location:login.php");
    die();
} 

if (isset($_REQUEST["m"])) {
    $msg = htmlspecialchars($_REQUEST["m"]);
    $nome = htmlspecialchars($_SESSION["nome"]);

    try {

        $conn = new PDO("mysql:host=localhost; dbname=braba", "root", "");
        $sql = "insert into chat values (default, :nome, :mensagem)";
        $preparado = $conn->prepare($sql);
        $preparado->bindParam(":nome", $nome);
        $preparado->bindParam(":mensagem", $msg);
        $preparado->execute();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $conn = null;
}
    
    if (isset($_POST['desconectar'])) {
        $_SESSION = array();
        session_destroy();
        header('location:login.php');
        die();
    }


?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenge RPG-Jogo</title>
    <link rel="stylesheet" type="text/css" href="css/jogo.css"/>
    <link rel="shortcut icon" type="image/x-icon" href="ativos/favicon.ico"/>
</head>
<body>
    <header>
        <section id="musica"> 
            <audio>

            </audio>
        </section> 
        <section id="cabecalho"> 
            <h1>Revenge RPG</h1>
            <h2>A vingança está aqui </h2>
        </section>
        <section id="usuario"> 
            <h3> <?php 
            echo "Usuário: {$_SESSION['nome']}<br>";
            echo "Id: {$_SESSION['id']}";
            ?> </h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <input type="submit" value="Desconectar" name="desconectar" id="desconectar">
            </form>
        </section>
    </header>
    
    <section id="propagandatop">

    </section>
    <section id="tela"> 
        <aside id="chat">
            <article id="mensagens">

            </article>
                <?php require 'ativos/chat.html' ?>
            </aside>

        <section id="interface"> 
            <div class="cartas">
                
            </div>
        </section>

        <aside id="propaganda">
            <?php require 'ativos/votacao.html' ?>
        </aside>

    </section>

    <footer>
        <h3>Brabíssimo Tiago &copy; 2020 - <?php echo date("Y"); ?> <br/> </h3>
        <h4><a href="http://www.youtube.com/c/SpiderAura" target="_blank">Youtube</a> │ <a href="http://www.facebook.com" target="_blank">Facebook</a> </h4>
    </footer>

</body>
</html>

