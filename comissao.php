<?php
//session_start();
//session_destroy();
//session_unset();
header("Content-type: text/html; charset=utf-8");

include "conexao.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSULTAS</title>
</head>
<body>
    <h1>CONSULTAS:</h1>
    <h2>Comissão - contrato</h2>
    
    <form method="POST" action="res_consulta.php">
        <label>Tipo comissao</label>
        <select name="tipocom">
            <?php
                $query = 'SELECT DISTINCT tipocom FROM COMISSOES_INTEGRANTES';
                $result = $mysqli->query($query,MYSQLI_STORE_RESULT);
                //$test = $result->fetch_array();
                //print_r($result);
                while(list($tipocom) = $result->fetch_row()){
                    echo "<option value='$tipocom'>$tipocom</option>";
                }

            ?>
        </select>

        <label>Contrato</label>
        <select name="contrato">
            <?php
                $query = "SELECT  contratos.idcont, contratos.tipocont, nomeempresa as empresa, 
                CONCAT(contratos.numerocont, '/', contratos.omcont, '/', contratos.anocont) AS contrato
                FROM empresas
                INNER JOIN contratos
                ON empresas.idempresa = contratos.idempresa
                ORDER BY nomeempresa, contratos.anocont, contratos.numerocont;";
                $result = $mysqli->query($query,MYSQLI_STORE_RESULT);
                
                //$test = $result->fetch_array();
                //print_r($test);
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$emp=$row['empresa'];                    
			$ct=$row['contrato'];
                    echo "<option value='$ct'>". $emp . " - " . $ct ."</option>";
                }
            ?>
        </select>
        <br>
        <p>Status:</p>
        <input type="radio" id="st1" name="status" value="vigente"  checked="checked">
        Vigente
        <input type="radio" id="st2" name="status" value="finalizada">
        Finalizada
        <input type="radio" id="st2" name="status" value="revogada">
        Revogada<br><br>
        <input type="submit" name="submit" value="CONSULTAR">
    </form>

    <h2>Militar em comissão</h1>
    <form method="POST" action="res_consulta.php">
    
    </form>
</body>
</html>
