<?php
include_once('../../conn/index.php');
$sql = "SELECT * FROM vendedor";
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
            <h6 class="m-0 font-weight-bold text-primary text">Consultar <span class="text-complete">Vendedores</span></h6>
            <div class="nav-search-btn">
                <button class="btn btn-primary btn-style" data-toggle="modal" data-target="#cadastroVendedor">
                    <i class="fas fa-plus"></i>
                    <span>Cadastrar Vendedor</span>

                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="dataTableVendedor" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Porcentagem Venda</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($res)) { ?>

                            <tr>
                                <td><?= $row['nome'] ?></td>
                                <td><?= $row['cidade'] ?></td>
                                <td><?= $row['estado'] ?></td>
                                <td><?= $row['porc_comissao'] . '%' ?></td>
                                <td class="text-center">
                                    <a href="#" onclick="edit('<?= $row['cod'] ?>')"><i class="far fa-edit"></i></a>
                                    <a href="#" onclick="deleteCliente('<?= $row['cod'] ?>')" class="pl-2"><i class="fas fa-trash"></i></a>
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
<div class="modal fade" id="cadastroVendedor" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="./php/vendedores/cadastro.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Vendedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-modal">
                        <div class="col-12">
                            <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-6">
                            <input type="text" id="celular" name="celular" class="form-control" placeholder="(00) 00000-0000" required>
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="porcentagemVenda" onkeyup="casasDecimais(this)" class="form-control" placeholder="Porcentagem por venda">
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-4">
                            <input type="text" name="endereco" class="form-control" placeholder="Endereco" required>
                        </div>
                        <div class="col-4">
                            <input type="text" name="cidade" class="form-control" placeholder="Cidade" required>
                        </div>
                        <div class="col-4">
                            <select id="estado" name="estado" class="form-control" required>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                                <option value="EX">Estrangeiro</option>
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

<div class="modal fade" id="editarVendedor" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="./php/vendedores/edit_vendedor.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edição de Vendedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_vendedor_edit" id="id_vendedor_edit" value="<? $row['numero'] ?>">
                    <div class="row row-modal">
                        <div class="col-12">
                            <input type="text" name="nome_edit" id="nome_edit" class="form-control" placeholder="Nome" required>
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-6">
                            <input type="text" name="celular_edit" id="celular_edit" class="form-control" placeholder="(00) 00000-0000" required>
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="porcentagemVenda_edit" id="porcentagemVenda_edit" onkeyup="casasDecimais(this)" class="form-control" placeholder="Porcentagem por venda">
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-4">
                            <input type="text" name="endereco_edit" id="endereco_edit" class="form-control" placeholder="Endereco" required>
                        </div>
                        <div class="col-4">
                            <input type="text" name="cidade_edit" id="cidade_edit" class="form-control" placeholder="Cidade" required>
                        </div>
                        <div class="col-4">
                            <select id="estado_edit" name="estado_edit" class="form-control" required>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                                <option value="EX">Estrangeiro</option>
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


<div class="modal fade" id="excluirVendedor" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="./php/vendedores/delete_vendedor.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Exclusão de Vendedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_vendedor_delete" id="id_vendedor_delete">
                    <p>Você deseja realmente exluir o vendedor <span class="text-primary" id="nome_vendedor_delete"></span></p>
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
    $(document).ready(function() {
        $('#dataTableVendedor').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-PT.json"

            }
        })
        $('#celular').mask('(99) 9 9999-9999')
        $('#celular_edit').mask('(99) 9 9999-9999')

    })

    function casasDecimais(obj) {
        var value = obj.value.replace(/\./g, ''); // Remove ponto

        // Remove todos os zeros à esquerda
        while (1) {
            if (value[0] == '0')
                value = value.substr(1);
            else
                break;
        }

        // Se o número não tiver tamannho 3 insere zeros à esquerda
        while (1) {
            if (value.length < 3)
                value = '0' + value;
            else
                break;
        }

        var result = value.substr(0, value.length - 2);
        result += '.' + value.substr(value.length - 2);
        obj.value = result;
    }

    function edit(id_vendedor) {
        $.get('php/vendedores/getVendedor.php?id_vendedor=' + id_vendedor, function(data) {
            var json = JSON.parse(data);
            console.log(data)
            $('#id_vendedor_edit').val(id_vendedor);
            $('#nome_edit').val(json.nome);
            $('#email_edit').val(json.email);
            $('#endereco_edit').val(json.endereco);
            $('#cidade_edit').val(json.cidade);
            $('#estado_edit').val(json.estado);
            $('#celular_edit').val(json.celular);
            $('#porcentagemVenda_edit').val(json.porcentagemVenda);
        })

        $('#editarVendedor').modal('show')
    }

    async function deleteCliente(id_vendedor) {
        await $.get('php/vendedores/getVendedor.php?id_vendedor=' + id_vendedor, function(data) {
            var json = JSON.parse(data);
            console.log(data)
            $('#id_vendedor_delete').val(id_vendedor);
            $('#nome_vendedor_delete').html(json.nome);
        })

        $('#excluirVendedor').modal('show')
    }
</script>