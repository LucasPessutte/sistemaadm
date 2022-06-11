<?php
include_once('../../conn/index.php');
$sql = "SELECT p.cod, p.nome, p.preco, p.qtd_estoque, p.unidade_medida, c.descricao AS categoria FROM produtos AS p INNER JOIN categoria AS c ON p.id_categoria = c.id";
$res = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet" />
    <link href="../../css/style.css" rel="stylesheet" />

    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
</head>

<body>
    <div class="row" style="margin-top: 10rem; text-align: center;">
        <div class="col">
            <span class="font-relatorio">TEste</span>
        </div>
    </div>

</body>

</html>










<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js%22%3E</script>