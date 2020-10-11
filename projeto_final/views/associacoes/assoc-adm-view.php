<?if(!defined('ABSPATH')) exit;?>

<?
//configura as URLs
$adm_uri = HOME_URI.'/associacoes/adm/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
?>

<div class="wrap">
    <?
    //mensagem de configuracao caso user tente apagar algo
    echo $modelo->form_confirma;
    $modelo->insere_assoc();
    $modelo->obter_assoc();
    $modelo->delete_assoc();
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
                    <a href="<?echo HOME_URI.'/associacoes/adm';?>">New Assoc</a>
                </td>
            </tr>
        </table>
        <input type="hidden" name="insere_assoc" value="1"/>
    </form>


    <!-- Lista os projetos -->
    <?
    $lista = $modelo->listar_associacoes();
    ?>
    <h1>Lista de Projetos</h1>
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
                <td><a href="<? echo HOME_URI.'/assoc/index/'.$assoc['idAssoc'];?>"><? echo $assoc['idAssoc'];?></a></td>
                <td><? echo $assoc['nome'];?></td>
                <td><? echo $assoc['telefone'];?></td>
                <td><? echo $assoc['morada'];?></td>
                <td><? echo $assoc['numContribuinte'];?></td>
                <td>
                    <a href="<? echo $edit_uri.$assoc['idAssoc'];?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$assoc['idAssoc'];?>" >Delete:</a>
                </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>