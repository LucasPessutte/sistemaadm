<?php
include_once('../../conn/index.php');
$sql = "SELECT * FROM cliente";
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
            <h6 class="m-0 font-weight-bold text-primary text">Consultar <span class="text-complete">Clientes</span></h6>
            <div class="nav-search-btn">
                <div class="row">
                    <button class="btn btn-primary btn-style" data-toggle="modal" data-target="#cadastroCliente">
                        <i class="fas fa-plus"></i>
                        <span>Cadastrar Cliente</span>
                    </button>
                    <button class="btn btn-info btn-style" data-toggle="modal" data-target="#filtrosCliente">
                        <i class="fas fa-filter"></i>
                    </button>
                    <button id="remove_filtro" class="btn btn-info btn-style hide" onclick="filtro('remove')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div id="conteudoClientes">
                <div class="table-responsive">
                    <table class="table" id="dataTableClient" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">CPF</th>
                                <th scope="col">Nome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Cidade</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($res)) { ?>
                                <tr>
                                    <td><?= $row['cpf'] ?></td>
                                    <td><?= $row['nome'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['cidade'] ?></td>
                                    <td><?= $row['estado'] ?></td>
                                    <td class="text-center">
                                        <a href="#" onclick="edit('<?= $row['codigo'] ?>')"><i class="far fa-edit"></i></a>
                                        <a href="#" onclick="deleteCliente('<?= $row['codigo'] ?>')" class="pl-2"><i class="fas fa-trash"></i></a>
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
</div>


<!-- Modal -->
<div class="modal fade" id="cadastroCliente" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="./php/clientes/cadastro.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-modal">
                        <div class="col-6">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome" required>
                        </div>
                        <div class="col-6">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00" required>
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-4">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="exemplo@exemplo.com" required>
                        </div>
                        <div class="col-4">
                            <label for="celular">Celular</label>
                            <input type="text" id="celular" name="celular" class="form-control" placeholder="(00) 00000-0000" required>
                        </div>
                        <div class="col-4">
                            <label for="limiteCredito">Limite Crédito</label>
                            <input type="number" step="0.01" id="limiteCredito" name="limiteCredito" onkeyup="casasDecimais(this)" class="form-control" placeholder="R$ 0.00">
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-4">
                            <label for="endereco">Endereço</label>
                            <input type="text" name="endereco" id="endereco" class="form-control" placeholder="Endereco" required>
                        </div>
                        <div class="col-4">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="cidade" name="cidade" class="form-control" placeholder="Cidade" required>
                        </div>
                        <div class="col-4">
                            <label for="estado">Estado</label>
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

<div class="modal fade" id="editarCliente" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
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
                    <input type="hidden" name="id_cliente_edit" id="id_cliente_edit">
                    <div class="row row-modal">
                        <div class="col-6">
                            <label for="nome_edit">Nome</label>
                            <input type="text" name="nome_edit" id="nome_edit" class="form-control" placeholder="Nome" required>
                        </div>
                        <div class="col-6">
                            <label for="cpf_edit">CPF</label>
                            <input type="text" name="cpf_edit" id="cpf_edit" class="form-control" placeholder="000.000.000-00" required>
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-4">
                            <label for="email_edit">Email</label>
                            <input type="text" name="email_edit" id="email_edit" class="form-control" placeholder="exemplo@exemplo.com" required>
                        </div>
                        <div class="col-4">
                            <label for="celular_edit">Celular</label>
                            <input type="text" name="celular_edit" id="celular_edit" class="form-control" placeholder="(00) 00000-0000" required>
                        </div>
                        <div class="col-4">
                            <label for="email_edit">Limite Crédito</label>
                            <input type="number" step="0.01" name="limiteCredito_edit" id="limiteCredito_edit" onkeyup="casasDecimais(this)" class="form-control" placeholder="R$ 0.00">
                        </div>
                    </div>
                    <div class="row row-modal">
                        <div class="col-4">
                            <label for="endereco_edit">Endereço</label>
                            <input type="text" name="endereco_edit" id="endereco_edit" class="form-control" placeholder="Endereco" required>
                        </div>
                        <div class="col-4">
                            <label for="cidade_edit">Cidade</label>
                            <input type="text" name="cidade_edit" id="cidade_edit" class="form-control" placeholder="Cidade" required>
                        </div>
                        <div class="col-4">
                            <label for="estado_edit">Estado</label>
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

<div class="modal fade" id="filtrosCliente" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filtros por cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label for="nome_filtro">Nome</label>
                        <input type="text" id="nome_filtro" name="nome_filtro" class="form-control">
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
        $('#dataTableClient').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-PT.json"

            }
        })
        $('#cpf').mask('999.999.999-99')
        $('#celular').mask('(99) 9 9999-9999')

        $('#cpf_edit').mask('999.999.999-99')
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

    function edit(id_cliente) {
        $.get('php/clientes/getCliente.php?id_cliente=' + id_cliente, function(data) {
            var json = JSON.parse(data);
            console.log(data)
            $('#id_cliente_edit').val(id_cliente);
            $('#nome_edit').val(json.nome);
            $('#cpf_edit').val(json.cpf);
            $('#email_edit').val(json.email);
            $('#celular_edit').val(json.celular);
            $('#limiteCredito_edit').val(json.limite_credito);
            $('#cidade_edit').val(json.cidade);
            $('#estado_edit').val(json.estado);
            $('#endereco_edit').val(json.endereco);
        })

        $('#editarCliente').modal('show')
    }

    async function deleteCliente(id_cliente) {
        await $.get('php/clientes/getCliente.php?id_cliente=' + id_cliente, function(data) {
            var json = JSON.parse(data);
            console.log(data)
            $('#id_cliente_delete').val(id_cliente);
            $('#nome_cliente_delete').html(json.nome);
        })

        $('#excluirCliente').modal('show')
    }

    async function filtro(op = "") {
        var nome_cliente = $('#nome_filtro').val()
        await $.get('php/clientes/getFiltroCliente.php?nome_cliente=' + nome_cliente + '&op=' + op, function(data) {
            $('#conteudoClientes').html(data)
        })

        if (op == 'remove') {
            $('#remove_filtro').removeClass('show').addClass('hide')
        } else {
            if (nome_cliente !== "") {
                $('#remove_filtro').removeClass('hide').addClass('show')
            } else {
                $('#remove_sfiltro').removeClass('show').addClass('hide')
            }
            $('#filtrosCliente').modal('hide')
        }

    }
</script>