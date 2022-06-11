<?php
include_once('../../conn/index.php');

$where = "";
if ($_GET['id_categoria'] != 0 && $_GET['id_categoria'] != null) {
    $where .= " WHERE p.id_categoria = " . $_GET['id_categoria'];
}

$sql = "SELECT p.*, c.descricao AS categoria FROM produtos AS p INNER JOIN categoria AS c ON p.id_categoria = c.id $where";
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

    <style>
        .table-responsive {
            box-sizing: border-box;
            padding: 2rem 0rem;
        }

        .font-relatorio {
            font-size: 2rem;
            color: black;
            font-weight: bold;
        }

        .sub {
            font-size: 1rem;
            color: black;
        }
    </style>
    <div id="conteudo-imp">
        <div class="row" style="margin-top: 5rem; text-align: center;">
            <div class="col">
                <span class="font-relatorio">Relatorio de produtos</span>
            </div>
        </div>
        <?php if ($_GET['id_categoria'] > 0 && $_GET['id_categoria'] !== null) {
            $sql = "SELECT * FROM categoria WHERE id = " . $_GET['id_categoria'];
            $row_cat = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        ?>
            <div class="row" style="margin-top: 0.5rem;text-align: center;">
                <div class="col"><span class="font-relatorio sub">Filtrado pela categoria: <?= $row_cat['descricao'] ?></span></div>
            </div>
        <?php } ?>
        <div class="teste">
            <div class="table-responsive">
                <table class="table" id="dataTableProduto" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Preço</th>
                            <th scope="col">QTD. Estoque</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($res)) { ?>
                            <tr>
                                <td scope="row"><?= $row['nome'] ?></td>
                                <td><?= $row['categoria'] ?></td>
                                <td>R$<?= $row['preco'] ?></td>
                                <td><?= $row['qtd_estoque'] . $row['unidade_medida'] ?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    var url = new URL(window.location.href);
    url.searchParams.delete("id_categoria");

    window.onload = function() {
        const invoice = document.getElementById("conteudo-imp");
        var opt = {
            margin: 1,
            filename: "Relatorio_produtos.pdf",
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            }
        };
        html2pdf().from(invoice).set(opt).save();

        setTimeout(() => {
            close();
        }, 1000);
    }
</script>