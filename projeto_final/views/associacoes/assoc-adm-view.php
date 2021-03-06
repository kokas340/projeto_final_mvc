<?verifyPath();?>

<?
//configura as URLs
$adm_uri = HOME_URI.'/associacoes/adm/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
$admin_assoc_uri = HOME_URI.'/associacoes/admassoc/';
$admin_images_uri = HOME_URI.'/associacoes/admimages/';
$admin_assoc_eventos = HOME_URI.'/associacoes/eventosassoc/';
?>

<div class="wrap">
    <?
    //mensagem de configuracao caso user tente apagar algo
    echo $modelo->form_confirma;
    $modelo->insere_items();
    $modelo->obter_items();
    $modelo->delete_items();
    ?>
    <!--
    Formulario de edicao de projetos
    -->
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
                    Nome: <br>
                    <input type="text" name="nome" value="<? echo htmlentities(chk_array($modelo->form_data, 'nome'));?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Morada: <br>
                    <input type="text" name="morada" value="<? echo htmlentities(chk_array($modelo->form_data, 'morada'));?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Numero de contribuinte: <br>
                    <input type="text" name="numContribuinte" value="<? echo htmlentities(chk_array($modelo->form_data, 'numContribuinte'));?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Telefone: <br>
                    <input type="text" name="telefone" value="<?
                    echo htmlentities(chk_array($modelo->form_data, 'telefone'));
                    ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?
                    echo $modelo->form_msg;
                    ?>
                    <input type="submit" value="Save"/>
                </td>
            </tr>
        </table>
        <input type="hidden" name="insere_assoc" value="1"/>
    </form>


    <!-- Lista os projetos -->
    <?
    $lista = $modelo->listar_items();
    ?>
    <h1>Lista de Associações</h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Morada</th>
            <th>Numero Contribuinte</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $assoc): ?>
            <tr>
                <td><? echo $assoc['idAssoc'];?></td>
                <td><? echo $assoc['nome'];?></td>
                <td><? echo $assoc['telefone'];?></td>
                <td><? echo $assoc['morada'];?></td>
                <td><? echo $assoc['numContribuinte'];?></td>
                <td>
                    <a href="<? echo $edit_uri.$assoc['idAssoc'];?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$assoc['idAssoc'];?>" >Delete:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $admin_assoc_uri.$assoc['idAssoc'];?>" >Administrar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $admin_images_uri.$assoc['idAssoc'];?>" >Adicionar imagem:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $admin_assoc_eventos.$assoc['idAssoc'];?>" >Eventos:</a>
                </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>