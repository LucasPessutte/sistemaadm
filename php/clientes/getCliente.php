<?php
    include_once('../../conn/index.php');    
    $id_cliente = $_GET['id_cliente'];
    
    $sql = "SELECT * FROM cliente WHERE codigo = $id_cliente";
    $res = mysqli_query($conn, $sql);
    
    $data = array();
    while($row = mysqli_fetch_array($res)){
        $data['nome'] = $row['nome'];
        $data['endereco'] = $row['endereco'];
        $data['celular'] = $row['telefone'];
        $data['limite_credito'] = $row['limite_credito'];
        $data['cidade'] = $row['cidade'];
        $data['estado'] = $row['estado'];
        $data['email'] = $row['email'];
        $data['cpf'] = $row['cpf'];
    }

    $json = json_encode($data);
    echo $json;
    mysqli_close($conn);