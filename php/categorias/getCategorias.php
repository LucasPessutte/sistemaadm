<?php
    include_once('../../conn/index.php');    
    $id_categoria = $_GET['id_categoria'];
    
    $sql = "SELECT * FROM categoria WHERE id = $id_categoria";
    $res = mysqli_query($conn, $sql);
    
    $data = array();
    while($row = mysqli_fetch_array($res)){
        $data['descricao'] = $row['descricao'];
    }

    $json = json_encode($data);
    echo $json;
    mysqli_close($conn);