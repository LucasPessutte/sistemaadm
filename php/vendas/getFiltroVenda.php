<?php
session_start();
include_once('../../conn/index.php');

$id_categoria = $_GET['id_categoria'];
$opcao = $_GET['op'];

$where = "";
if (!empty($id_categoria)) {
    $where .= " WHERE p.id_categoria = $id_categoria";
}

$sql = "SELECT p.*, c.descricao AS categoria FROM produtos AS p INNER JOIN categoria AS c ON p.id_categoria = c.id";
$sql .= $opcao == "remove" ? "" : $where;
$res = mysqli_query($conn, $sql);
?>