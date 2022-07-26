<?php
include_once('../../conn/index.php');
$sql = "SELECT 
            v.*,
            vd.nome AS vendedor,
            c.nome AS cliente
        FROM vendas AS v
        INNER JOIN vendedor AS vd ON v.id_vendedor = vd.cod
        INNER JOIN cliente AS c ON v.id_cliente = c.codigo";
$res = mysqli_query($conn, $sql);

$sql_vendedor = "SELECT * FROM vendedor";
$res_vendedor = mysqli_query($conn, $sql_vendedor);

$sql_cliente = "SELECT * FROM cliente";
$res_cliente = mysqli_query($conn, $sql_cliente);

$sql_produtos = "SELECT * FROM produtos";
$res_produtos = mysqli_query($conn, $sql_produtos);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<div class="container-fluid">
    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>
    <div class="card shadow mb-4" style="height: 100%;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary text">Consultar <span class="text-complete">Vendas</span></h6>
            <div class="nav-search-btn">
                <div class="row">
                    <button class="btn btn-primary btn-style" data-toggle="modal" data-target="#cadastroVenda">
                        <i class="fas fa-plus"></i>
                        <span>Cadastrar Vendas</span>
                    </button>
                    <button class="btn btn-info btn-style" data-toggle="modal" data-target="#filtrosVenda">
                        <i class="fas fa-filter"></i>
                    </button>
                    <button id="remove_filtro" class="btn btn-info btn-style hide" onclick="filtro('remove')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" id="data1_pagina" value="">
            <input type="hidden" id="data2_pagina" value="">
            <div id="conteudoVendas">
                <div class="table-responsive">
                    <table class="table" id="dataTableVenda" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">Vendedor</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Data</th>
                                <th scope="col">Prazo de Pagamento</th>
                                <th scope="col">Condição de Pagamento</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($res)) { ?>
                                <tr>
                                    <td><?= $row['vendedor'] ?></td>
                                    <td><?= $row['cliente'] ?></td>
                                    <td><?= date('d/m/y', strtotime($row['data'])) ?></td>
                                    <td><?= date('d/m/y', strtotime($row['prazo_pagto'])) ?></td>
                                    <td><?= $row['cond_pagto'] ?></td>
                                    <td class="text-center">
                                        <a href="#" onclick="visualizarVenda(<?= $row['numero'] ?>)" class="pl-2"><i class="fas fa-eye"></i></a>
                                        <a href="#" onclick="deleteVenda(<?= $row['numero'] ?>)" class="pl-2"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <button class="btn btn-primary" onclick="gerar_pdf()">Gerar Relatório</button>
        </div>
    </div>
</div>


<!-- Modal -->

<!-- CADASTRO DE VENDA -->
<div class="modal fade" id="cadastroVenda" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="./php/vendas/cadastro.php" id="form-cadastro" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Venda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-modal">
                        <div class="col-4">
                            <label for="id_vendedor">Vendedor</label>
                            <select name="id_vendedor" id="id_vendedor" class="form-control" required>
                                <option value="">Selecione um vendedor</option>
                                <?php while ($row = mysqli_fetch_array($res_vendedor)) { ?>
                                    <option value="<?= $row['cod'] ?>"><?= $row['nome'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="id_cliente">Cliente</label>
                            <select name="id_cliente" id="id_cliente" class="form-control" required>
                                <option value="">Selecione um vendedor</option>
                                <?php while ($row = mysqli_fetch_array($res_cliente)) { ?>
                                    <option value="<?= $row['codigo'] ?>"><?= $row['nome'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="data">Data</label>
                            <input type="date" name="data" id="data" class="form-control" placeholder="DD/MM/AAAA">
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-6">
                            <label for="prazo_pagto">Prazo pagamento</label>
                            <input type="date" name="prazo_pagto" class="form-control" placeholder="Prazo de pagamento" required>
                        </div>
                        <div class="col-6">
                            <label for="cond_pagto">Forma pagamento</label>
                            <select id="cond_pagto" name="cond_pagto" class="form-control" placeholder="Cidade" required>
                                <option value="credito">Crédito</option>
                                <option value="debito">Débito</option>
                                <option value="cheque">Cheque</option>
                                <option value="trasferencia">Transferência bancária</option>
                                <option value="boleto">Boleto</option>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <h4>Produtos</h4>

                    <div class="row">
                        <div class="col-4">
                            <label for="">Produto</label>
                        </div>
                        <div class="col-2">
                            <label for="">Preço</label>
                        </div>
                        <div class="col-4">
                            <label for="">Qtd. Produtos</label>
                        </div>
                        <div class="col-2">
                            <label for="">Mais</label>
                        </div>
                    </div>
                    <input type="hidden" name="qtd_produtos" id="qtd_produtos" value="1">
                    <div id="div-produtos">
                        <div class="row produtos pb-3" id="produtos-1">
                            <div class="col-4">
                                <select name="id_produto_1" id="id_produto_1" onchange="selecionaProduto(this)" class="form-control" required>
                                    <option value="">Selecione um produto</option>
                                    <?php while ($row = mysqli_fetch_array($res_produtos)) { ?>
                                        <option value="<?= $row['cod'] ?>"><?= $row['nome'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-2">
                                <input id="preco_produto_1" type="text" disabled class="form-control">
                            </div>
                            <div class="col-4">
                                <input type="number" id="qtd_produto_1" name="qtd_produto_1" min="1" step="1" class="form-control" onchange="altera_valor_final()">
                            </div>
                            <div class="col-2">
                                <div class="btn btn-primary" id="button_plus" onclick="adicionaProduto(this)"><i class="fas fa-plus-circle"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="valor-final">Valor total</label>
                            <input type="number" class="form-control" step="0.01" id="valor-final" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="salvar_form" onclick="envia_formulario(this)" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Visualizar VENDA -->
<div class="modal fade" id="visualizarVenda" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Visualização Venda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="visualiza_venda">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- EXCLUIR VENDA -->
<div class="modal fade" id="excluirVenda" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="./php/vendas/delete_venda.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Exclusão de Venda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_venda_delete" id="id_venda_delete">
                    <p>Você deseja realmente exluir a venda? <span class="text-primary" id="venda_delete"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="msgVenda" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Limite de crédito insuficiente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>O cliente <span class="text-primary" id="cliente_limite"></span> não possui limite de crédito suficiente!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filtrosVenda" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filtros Venda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="data_1">De</label>
                        <input type="date" id="data_1" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="data_2">Até</label>
                        <input type="date" id="data_2" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" onclick="filtro()" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#dataTableVenda').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-PT.json"

            }
        })
    })

    function edit(id_venda) {
        console.log('Entrou')
        $.get('php/vendas/getVenda.php?id_venda=' + id_venda, function(data) {
            var json = JSON.parse(data);
            $('#id_venda_edit').val(id_venda);
            $('#id_vendedor').val(json.id_vendedor);
            $('#id_cliente_edit').val(json.id_cliente);
            $('#data_edit').val(json.data);
            $('#prazo_pagto_edit').val(json.prazo_pagto);
            $('#cond_pagto_edit').val(json.cond_pagto);
        })

        $('#editarVenda').modal('show')
    }

    function deleteVenda(id_venda) {
        $('#id_venda_delete').val(id_venda);
        $('#excluirVenda').modal('show')
    }

    function selecionaProduto(obj) {

        var numeroProduto = obj.id.split('_')[2];
        if (obj.value !== "") {
            $.get('php/produtos/getProdutos.php?id_produto=' + obj.value, function(data) {
                var json = JSON.parse(data);
                $('#preco_produto_' + numeroProduto).val(json.preco);
                $('#qtd_produto_' + numeroProduto).attr('max', json.qtd_estoque)
            })
        } else {
            $('#preco_produto_' + numeroProduto).val("");
            $('#qtd_produto_' + numeroProduto).val('')
            $('#qtd_produto_' + numeroProduto).removeAttr('max')
        }

        altera_valor_final()
    }


    async function adicionaProduto(obj) {
        var complemento = obj.id.split("_");

        if (complemento.includes('edit')) {
            complemento = '-edit'
        } else {
            complemento = ''
        }

        var prox_produto = parseInt($('#div-produtos' + ' .produtos').last()[0].id.split("-")[1]) + 1;
        var qtd_produtos = parseInt($('#qtd_produtos' + complemento).val())

        await $.get('php/vendas/novoProduto.php?prox_produto=' + prox_produto, function(data) {
            var div_insert = document.createElement('div')
            div_insert.setAttribute('class', 'produtos')
            div_insert.setAttribute('id', 'produtos-' + prox_produto + complemento)

            div_insert.innerHTML = data

            document.getElementById('div-produtos' + complemento).appendChild(div_insert)
        })

        qtd_produtos++
        var qtd_produtos = $('#qtd_produtos' + complemento).val(qtd_produtos)

        altera_valor_final(complemento)
    }

    function removeProduto(obj, id) {
        var complemento = obj.id.split("_")

        if (complemento.includes('edit')) {
            complemento = '-edit'
        } else {
            complemento = ''
        }

        var div_remover = document.getElementById('produtos-' + id + complemento)
        div_remover.parentNode.removeChild(div_remover)

        var qtd_produtos = parseInt($('#qtd_produtos').val())
        qtd_produtos--
        $('#qtd_produtos' + complemento).val(qtd_produtos)

        altera_valor_final(complemento)
    }

    function altera_valor_final(complemento = "") {
        var valor_final = 0;
        var qtd_produtos = parseInt($('#qtd_produtos' + complemento).val())
        var qtd_produtos_aux = qtd_produtos

        for (var i = 1; i <= qtd_produtos_aux; i++) {
            if ($('#id_produto_' + i).length) {
                if ($('#id_produto_' + i).val() !== "") {
                    valor_final += parseFloat($('#preco_produto_' + i + complemento).val()) * parseInt($('#qtd_produto_' + i + complemento).val())
                }
            } else {
                qtd_produtos_aux++
                console.log('entrou')
            }
        }

        $('#valor-final' + complemento).val(valor_final.toFixed(2))
    }

    async function visualizarVenda(id_venda) {
        console.log(id_venda);
        await $.get('php/vendas/getVenda.php?id_venda=' + id_venda, function(data) {
            $('#visualiza_venda').html(data)
        })
        $('#visualizarVenda').modal('show');
    }

    async function envia_formulario(obj) {

        var complemento = obj.id.split('_');

        if (complemento.includes('edit')) {
            complemento = "_edit"
        } else {
            complemento = ""
        }

        var validacaoForm = $('#form-cadastro')[0].reportValidity();
        if (validacaoForm) {
            var id_cliente = $('#id_cliente' + complemento).val()
            var valor_final = parseFloat($('#valor-final' + complemento).val());
            var infos = await $.get('php/clientes/getCliente.php?id_cliente=' + id_cliente, function(data) {
                return JSON.parse(data);

            })

            infos = JSON.parse(infos)

            console.log(valor_final)
            console.log(infos.limite_credito)
            if (valor_final <= parseFloat(infos.limite_credito)) {
                $('#form-cadastro').submit()
            } else {
                $("#cliente_limite").html(infos.nome)
                $("#msgVenda").modal('show')
            }

        }

    }

    async function filtro(op = "") {
        var data1 = $('#data_1').val();
        var data2 = $('#data_2').val();
        await $.get('php/vendas/getFiltroVenda.php?data1=' + data1 + "&data2=" + data2 + '&op=' + op, function(data) {
            $('#conteudoVendas').html(data)
        })

        if (op == 'remove') {
            $('#remove_filtro').removeClass('show').addClass('hide')
        } else {
            if (data1 !== "" || data2 !== "") {
                data1 !== "" ? $('#data1_pagina').val(data1) : $('#data2_pagina').val("")
                data2 !== "" ? $('#data2_pagina').val(data2) : $('#data2_pagina').val("")
                $('#remove_filtro').removeClass('hide').addClass('show')
            } else {
                $('#data1_pagina').val("")
                $('#data2_pagina').val("")
                $('#remove_filtro').removeClass('show').addClass('hide')
            }
            $('#filtrosVenda').modal('hide')
        }
    }

    function gerar_pdf(){
        var data1 = $('#data1_pagina').val();
        var data2 = $('#data2_pagina').val();
        window.open('./views/vendas/relatorio.php?data1=' + data1 + '&data2=' + data2)
    }
</script>