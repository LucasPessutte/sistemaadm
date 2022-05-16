<?php
    include_once('../../conn/index.php');    
    $id_vendedor = $_GET['id_vendedor'];
    
    $sql = "SELECT * FROM vendedor WHERE cod = $id_vendedor";
    $res = mysqli_query($conn, $sql);
    
    $data = array();
    while($row = mysqli_fetch_array($res)){
        $data['nome'] = $row['nome'];
        $data['endereco'] = $row['endereco'];
        $data['cidade'] = $row['cidade'];
        $data['estado'] = $row['estado'];
        $data['celular'] = $row['telefone'];
        $data['porcentagemVenda'] = $row['porc_comissao'];
    }

    $json = json_encode($data);
    echo $json;
    mysqli_close($conn);