<?if(!defined('ABSPATH')) exit;?>

<?
//configura as URLs
$adm_uri = HOME_URI.'/associacoes/adm/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
?>

<div class="wrap">
    <!-- Lista os projetos -->
    <?
    $lista = $modelo->listar_assoc();
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
                <td><a href="<? echo HOME.URI.'/assoc/index/'.$assoc['idAssoc'];?>"><? echo $assoc['idAssoc'];?></a></td>
                <td><? echo $assoc['nome'];?></td>
                <td><? echo $assoc['telefone'];?></td>
                <td><? echo $assoc['morada'];?></td>
                <td><? echo $assoc['numContribuinte'];?></td>
                <td>
                    <a href="<? echo $edit_uri.$projeto['idProjeto'];?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$projeto['idProjeto'];?>" >Delete:</a>
                </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>