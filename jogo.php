<?php

session_start();
if (!isset($_SESSION['nome'])) {
    header("location:login.php");
} 

$conn = new PDO("mysql:host=localhost; dbname=braba", "root", "");
$sql = "select ";
$preparado = $conn->prepare($sql);
$preparado->setFetchMode(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenge RPG-Jogo</title>
    <link rel="stylesheet" type="text/css" href="css/jogo.css"/>
</head>
<body>
    <header>
        <div id="cabecalho"> 
            <h1>Revenge RPG</h1>
            <h2>A vingança está aqui </h2>
        </div>
        <div id="usuario"> 
            <h3> <?php 
            echo "Usuário: {$_SESSION['nome']}<br>";
            echo "Id: {$_SESSION['id']}";
            ?> </h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <input type="submit" value="Desconectar" name="desconectar" id="desconectar">
            </form>
        </div>
    </header>
    <section id="interface">
        <table>
            <tr>
                <th> Posição </th>
                <th> Usuário </th>
                <th> Poder </th>
            <tr>
            <tr>
                <td> 1º </td>
                <td> José </td>
                <td> 100 </td>
            </tr>
        </table>
    </section>
    <footer>
        Brabissímo Tiago &copy; 2020 - <?php echo date("Y"); ?> <br/>
    </footer>
    <?php 
    
    if (isset($_POST['desconectar'])) {
        $_SESSION = array();
        session_destroy();
        header('location:login.php');
    }
    
    ?>
</body>
</html>

