<?php
include_once('../../conn/index.php');
$sql = "SELECT * FROM categoria";
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
            <h6 class="m-0 font-weight-bold text-primary text">Consultar <span class="text-complete">Categorias</span></h6>
            <div class="nav-search-btn">
                <button class="btn btn-primary btn-style" data-toggle="modal" data-target="#cadastroCategoria">
                    <i class="fas fa-plus"></i>
                    <span>Cadastrar Categoria</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="dataTableCategoria" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($res)) { ?>

                            <tr>
                                <td><?= $row['descricao'] ?></td>
                                <td class="text-center">
                                    <a href="#" onclick="edit('<?= $row['id'] ?>')"><i class="far fa-edit"></i></a>
                                    <a href="#" onclick="deleteCategoria('<?= $row['id'] ?>')" class="pl-2"><i class="fas fa-trash"></i></a>
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
<div class="modal fade" id="cadastroCategoria" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="./php/categorias/cadastro.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Categorias</h5>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editarCategoria" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <form action="./php/categorias/edit_categoria.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edição de Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_categoria_edit" name="id_categoria_edit">
                    <div class="row row-modal">
                        <div class="col-12">
                            <input type="text" name="nome_edit" id="nome_edit" class="form-control" placeholder="Nome" required>
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


<div class="modal fade" id="excluirCategoria" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="./php/categorias/delete_categoria.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Exclusão de categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_categoria_delete" id="id_categoria_delete">
                    <p>Você deseja realmente exluir o cliente <span class="text-primary" id="nome_categoria_delete"></span></p>
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
        $('#dataTableCategoria').DataTable({
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

    function edit(id_categoria) {
        $.get('php/categorias/getCategorias.php?id_categoria=' + id_categoria, function(data) {
            var json = JSON.parse(data);
            $('#id_categoria_edit').val(id_categoria);
            $('#nome_edit').val(json.descricao);
        })

        $('#editarCategoria').modal('show')
    }

    async function deleteCategoria(id_categoria) {
        await $.get('php/categorias/getCategorias.php?id_categoria=' + id_categoria, function(data) {
            var json = JSON.parse(data);
            $('#id_categoria_delete').val(id_categoria);
            $('#nome_categoria_delete').html(json.descricao);
        })

        $('#excluirCategoria').modal('show')
    }
</script>