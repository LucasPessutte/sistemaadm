<?php
include_once('../../conn/index.php');
$sql = "SELECT * FROM vendas";
$res = mysqli_query($conn, $sql);

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
                <button class="btn btn-primary btn-style" data-toggle="modal" data-target="#cadastroVenda">
                    <i class="fas fa-plus"></i>
                    <span>Cadastrar Vendas</span>

                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="dataTableVenda" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">ID Vendedor</th>
                            <th scope="col">ID Cliente</th>
                            <th scope="col">Data</th>
                            <th scope="col">Prazo de Pagamento</th>
                            <th scope="col">Condição de Pagamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($res)) { ?>

                            <tr>
                                <td><?= $row['id_vendedor'] ?></td>
                                <td><?= $row['id_cliente'] ?></td>
                                <td><?= $row['data'] ?></td>
                                <td><?= $row['prazo_pagto'] ?></td>
                                <td><?= $row['cond_pagto'] ?></td>
                                <td class="text-center">
                                    <!-- <a href="#" onclick="edit(<?= $row['numero'] ?>)"><i class="far fa-edit"></i></a> -->
                                    <a href="#" onclick="deleteVenda(<?= $row['numero'] ?>)" class="pl-2"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<!-- Modal -->

<!-- CADASTRO DE VENDA -->
<div class="modal fade" id="cadastroVenda" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="./php/vendas/cadastro.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Venda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-modal">
                        <div class="col-4">
                            <input type="text" name="id_vendedor" class="form-control" placeholder="ID Vendedor" required>
                        </div>
                        <div class="col-4">
                            <input type="text" id="" name="id_cliente" class="form-control" placeholder="ID Cliente" required>
                        </div>
                        <div class="col-4">
                            <input type="date" name="data" class="form-control" placeholder="DD/MM/AAAA">
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-4">
                            <input type="date" name="prazo_pagto" class="form-control" placeholder="Prazo de pagamento" required>
                        </div>
                        <div class="col-4">
                            <select id="cond_pagto" name="cond_pagto" class="form-control" placeholder="Cidade" required>
                                <option value="credito">Crédito</option>
                                <option value="debito">Débito</option>
                                <option value="cheque">Cheque</option>
                                <option value="trasferencia">Transferência bancária</option>
                                <option value="boleto">Boleto</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- EDITAR VENDA -->
<!-- <div class="modal fade" id="editarVenda" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="./php/vendas/edit_vendas.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edição de Venda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_venda_edit" id="id_venda_edit">
                    <div class="row row-modal">
                        <div class="col-4">
                            <input type="text" name="id_vendedor_edit" id="id_vendedor_edit" class="form-control" placeholder="ID vendedor" required>
                        </div>
                        <div class="col-4">
                            <input type="text" name="id_cliente_edit" id="id_cliente_edit" class="form-control" placeholder="ID Cliente" required>
                        </div>
                        <div class="col-4">
                            <input type="date" name="data_edit" id="data_edit" class="form-control" placeholder="DD/MM/AAAA">
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-4">
                            <input type="date" name="prazo_pagto_edit" id="prazo_pagto_edit" class="form-control" placeholder="Prazo de pagamento" required>
                        </div>
                        <div class="col-4">
                            <select type="text" name="cond_pagto_edit" id="cond_pagto_edit" class="form-control" placeholder="Condição de pagamento" required>
                                <option value="credito">Crédito</option>
                                <option value="debito">Débito</option>
                                <option value="cheque">Cheque</option>
                                <option value="trasferencia">Transferência bancária</option>
                                <option value="boleto">Boleto</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

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


<script>
    function edit(id_venda) {
        $.get('php/vendas/getVenda.php?id_venda=' + id_venda, function(data) {
            var json = JSON.parse(data);
            console.log(data)
            $('#id_venda_edit').val(id_venda);
            $('#id_vendedor_edit').val(json.id_vendedor);
            $('#id_cliente_edit').val(json.id_cliente);
            $('#data_edit').val(json.data);
            $('#prazo_pagto_edit').val(json.prazo_pagto);
            $('#cond_pagto_edit').val(json.cond_pagto);
        })

        $('#editarVenda').modal('show')
    }

    async function deleteVenda(id_venda) {
        await $.get('php/vendas/getVenda.php?id_venda=' + id_venda, function(data) {
            var json = JSON.parse(data);
            console.log(data)
            $('#id_venda_delete').val(id_venda);
        })

        $('#excluirVenda').modal('show')
    }
</script>