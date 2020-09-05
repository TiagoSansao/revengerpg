<?php 

$voto = $_REQUEST['voto'];

$filename = "votacao.txt";
$content = file($filename);

$array = explode("││", $content[0]);
$sim = $array[0];
$nao = $array[1];

if ($voto == 0) {
    $sim = $sim + 1;
}
if ($voto == 1) {
    $nao = $nao + 1;
}

$colocarvoto = $sim . "││" . $nao;
$fp = fopen($filename, "w");
fputs($fp, $colocarvoto);
fclose($fp);
?>


<h4>Resultados: <h4>
<table> 
    <tr>
        <td> Sim: </td>
        <td> <?php echo round(($sim * 100) / ($sim + $nao)); ?>% </td>
    </tr>
    <tr>
        <td> Não: </td>
        <td> <?php echo round(($nao * 100) / ( $sim + $nao )); ?>% </td>
    </tr>
</table>
