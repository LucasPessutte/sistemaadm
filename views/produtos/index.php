<?php
include_once('../../conn/index.php');
$sql = "SELECT p.cod, p.nome, p.preco, p.qtd_estoque, p.unidade_medida, c.descricao AS categoria FROM produtos AS p INNER JOIN categoria AS c ON p.id_categoria = c.id";
$res = mysqli_query($conn, $sql);
$sql = "SELECT * FROM categoria";
$res_categoria = mysqli_query($conn, $sql);
$res_categoria_edit = mysqli_query($conn, $sql);

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
            <h6 class="m-0 font-weight-bold text-primary text">Consultar <span class="text-complete">Produtos</span></h6>
            <div class="nav-search-btn">
                <button class="btn btn-primary btn-style" data-toggle="modal" data-target="#cadastroProduto">
                    <i class="fas fa-plus"></i>
                    <span>Cadastrar Produto</span>

                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="dataTableClient" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Preço</th>
                            <th scope="col">QTD. Estoque</th>
                            <th scope="col">Ações</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($res)) { ?>

                            <tr>
                                <td><?= $row['nome'] ?></td>
                                <td><?= $row['categoria'] ?></td>
                                <td>R$<?= $row['preco'] ?></td>
                                <td><?= $row['qtd_estoque'] . $row['unidade_medida'] ?></td>
                                <td class="text-center">
                                    <a href="#" onclick="edit('<?= $row['cod'] ?>')"><i class="far fa-edit"></i></a>
                                    <a href="#" onclick="deleteProduto('<?= $row['cod'] ?>')" class="pl-2"><i class="fas fa-trash"></i></a>
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
<div class="modal fade" id="cadastroProduto" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="./php/produtos/cadastro.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Produtos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-modal">
                        <div class="col-6">
                            <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" id="preco" name="preco" onkeyup="casasDecimais(this)" class="form-control" placeholder="R$ 0.00">
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-6">
                            <input type="number" name="qtd_estoque" class="form-control" step="1" placeholder="Quantidade no estoque" required>
                        </div>
                        <div class="col-6">
                            <select id="unidade_medida" name="unidade_medida" class="form-control" required>
                                <option value="">Selecione Alguma medida</option>
                                <option value="L">L</option>
                                <option value="ML">ML</option>
                                <option value="UN">UN</option>
                                <option value="MG">MG</option>
                            </select>
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-12">
                            <select id="id_categoria" name="id_categoria" class="form-control" required>
                                <option value="">Selecione uma categoria</option>
                                <?php
                                while ($row = mysqli_fetch_array($res_categoria)) {
                                ?>
                                <option value="<?= $row['id'] ?>"><?= $row['descricao'] ?></option>

                                <?php } ?>
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

<div class="modal fade" id="editarProduto" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="./php/clientes/edit_cliente.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edição de Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-modal">
                        <input type="hidden" name="id_produto_edit" id="id_produto_edit">
                        <div class="col-6">
                            <input type="text" name="nome_edit" id="nome_edit" class="form-control" placeholder="Nome" required>
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" id="preco_edit" name="preco_edit" onkeyup="casasDecimais(this)" class="form-control" placeholder="R$ 0.00">
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-6">
                            <input type="number" name="qtd_estoque_edit" id="qtd_estoque_edit" class="form-control" step="1" placeholder="Quantidade no estoque" required>
                        </div>
                        <div class="col-6">
                            <select id="unidade_medida_edit" name="unidade_medida_edit" class="form-control" required>
                                <option value="">Selecione Alguma medida</option>
                                <option value="L">L</option>
                                <option value="ML">ML</option>
                                <option value="UN">UN</option>
                                <option value="MG">MG</option>
                            </select>
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-12">
                            <select id="categoria_edit" name="categoria_edit" class="form-control" required>
                                <option value="">Selecione uma categoria</option>

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


<div class="modal fade" id="excluirCliente" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="./php/clientes/delete_cliente.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Exclusão de Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_cliente_delete" id="id_cliente_delete">
                    <p>Você deseja realmente exluir o cliente <span class="text-primary" id="nome_cliente_delete"></span></p>
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
        $('#dataTableClient').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-PT.json"

            }
        })
        $('input[name="celular]"').mask('(99) 9 9999-9999')
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

    function edit(id_produto) {
        $.get('php/produtos/getProdutos.php?id_produto=' + id_produto, function(data) {
            var json = JSON.parse(data);
            $('#id_produto_edit').val(id_produto);
            $('#nome_edit').val(json.nome);
            $('#preco_edit').val(json.preco);
            $('#qtd_estoque_edit').val(json.qtd_estoque);
            $('#unidade_medida_edit').val(json.unidade_medida);
            $('#categoria_edit').val(json.categoria);
        })

        $('#editarProduto').modal('show')
    }

    async function deleteProduto(id_cliente) {
        await $.get('php/clientes/getCliente.php?id_cliente=' + id_cliente, function(data) {
            var json = JSON.parse(data);
            console.log(data)
            $('#id_cliente_delete').val(id_cliente);
            $('#nome_cliente_delete').html(json.nome);
        })

        $('#excluirCliente').modal('show')
    }
</script>