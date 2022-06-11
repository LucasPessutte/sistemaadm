<?php
include_once('../../conn/index.php');
$data1 = $_GET['data1'];
$data2 = $_GET['data2'];

$periodo = "";
$where = "";

if (!empty($data1)) {
    $where .= "WHERE v.data >= '$data1'";

    $periodo .= "Desde " . date("d/m/Y", strtotime($data1));

    if (!empty($data2)) {
        $where .= "AND v.data <= '$data2'";
        $periodo .=  " até " . date("d/m/Y", strtotime($data2));
    }
} else if (!empty($data2)) {
    $where .= "WHERE v.data <= '$data2'";
    $periodo .=  "Até " . date("d/m/Y", strtotime($data2));
} else {
    $periodo .=  "Todo";
}

$sql = "SELECT 
                v.*, 
                c.nome AS cliente, 
                vd.nome AS vendedor 
            FROM vendas v 
            INNER JOIN cliente AS c ON v.id_cliente = c.codigo 
            INNER JOIN vendedor AS vd ON v.id_vendedor = vd.cod $where";
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
                <span class="font-relatorio">Relatorio de vendas</span>
            </div>
        </div>
        <?php if ($periodo !== "") {
        ?>
            <div class="row" style="margin-top: 0.5rem;text-align: center;">
                <div class="col"><span class="font-relatorio sub">Filtrado por: <?= $periodo ?></span></div>
            </div>
        <?php } ?>

        <?php while ($row = mysqli_fetch_array($res)) {
        ?>

            <div class="venda m-4">
                <div class="row">
                    <div class="col-12">
                        <span>Venda número: <?= $row['numero'] ?></span>
                    </div>
                </div>
                <div class="row" style="text-align:center;">
                    <div class="col"><?= $row['vendedor'] ?></div>
                    <div class="col"><?= $row['cliente'] ?></div>
                    <div class="col"><?= date('d/m/y', strtotime($row['data'])) ?></div>
                    <div class="col"><?= date('d/m/y', strtotime($row['prazo_pagto'])) ?></div>
                    <div class="col"><?= $row['cond_pagto'] ?></div>
                </div>

                <?php
                $sql_produtos = "SELECT 
                                        i.id, 
                                        i.quant_vendida, 
                                        p.nome, 
                                        p.preco 
                                    FROM intens_vendas AS i 
                                    INNER JOIN produtos AS p 
                                    ON i.id_produto = p.cod 
                                    WHERE i.id_venda = " . $row['numero'];
                $res_produtos = mysqli_query($conn, $sql_produtos);

                while ($row_produtos = mysqli_fetch_array($res_produtos)) {
                ?>

                    <div class="row m-4">
                        <div class="col-12"><span>Item de código: <?= $row_produtos['id'] ?></span></div>
                        <div class="col">
                            <?= $row_produtos['nome'] ?>
                        </div>
                        <div class="col">
                            <?= $row_produtos['preco'] ?>
                        </div>
                        <div class="col">
                            <?= $row_produtos['quant_vendida'] ?>
                        </div>
                    </div>
                <?php } ?>

            </div>
        <?php } ?>

    </div>

</body>

</html>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    var url = new URL(window.location.href);
    url.searchParams.delete("categoria_id");

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