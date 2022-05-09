<?php
    session_start();
    include_once('../../conn/index.php');    
    $id_cliente = $_GET['id_cliente'];
    
    $sql = "SELECT * FROM cliente WHERE id = $id_cliente";
    $res = mysqli_query($conn, $sql);
    
    $data = array();
    while($row = mysqli_fetch_array($res)){
        array_push($data,array('nome' => $row['nome']));
        array_push($data,array('endereco' => $row['endereco']));
        array_push($data,array('telefone' => $row['telefone']));
        array_push($data,array('limite_credito' => $row['limite_credito']));
        array_push($data,array('cidade' => $row['cidade']));
        array_push($data,array('estado' => $row['estado']));
        array_push($data,array('email' => $row['email']));
        array_push($data,array('cpf' => $row['cpf']));
    }
    
    mysqli_close($conn);
    $json = json_encode($data);
    echo $json;