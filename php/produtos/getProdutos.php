<?php
    include_once('../../conn/index.php');    
    $id_produto = $_GET['id_produto'];
    
    $sql = "SELECT * FROM produtos WHERE cod = $id_produto";
    $res = mysqli_query($conn, $sql);

    
    $data = array();
    while($row = mysqli_fetch_array($res)){
        $data['nome'] = $row['nome'];
        $data['preco'] = $row['preco'];
        $data['qtd_estoque'] = $row['qtd_estoque'];
        $data['unidade_medida'] = $row['unidade_medida'];
        $data['categoria'] = $row['id_categoria'];
    }

    $json = json_encode($data);
    echo $json;
    mysqli_close($conn);