<?php 

try {
    $conn = new PDO("mysql:host=localhost; dbname=braba", "root", "");
    $sql = "select id, nome, mensagem from chat order by id desc limit 15";
    $preparado = $conn->prepare($sql);
    $preparado->execute();
    $preparado->setFetchMode(PDO::FETCH_ASSOC);
    $mensagens = $preparado->fetchAll();

    foreach ($mensagens as $msg) {
        echo "<span class='mensagem'> {$msg['nome']}:  {$msg['mensagem']} </span> <br>" ;
        }


} catch (PDOException $e) {
    echo $e->getMessage();
}
$conn = null;

?>