<?php
verifyPath();
$id_assoc = 0;
if(chk_array($this->parametros, 0))
    $id_assoc = chk_array($this->parametros, 0);
$adm_uri = HOME_URI.'/associacoes/admassoc/'.$id_assoc.'/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
echo $modelo->form_confirma;
$modelo->insere_items();
$modelo->obter_items();
$modelo->delete_items();
?>
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
                Email: <br>
                <input type="text" name="email" value="<? echo htmlentities(chk_array($modelo->form_data, 'email'));?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?
                echo $modelo->form_msg;
                ?>
                <input type="submit" value="Save"/>
                <a href="<?echo HOME_URI.'/associacoes/adm';?>">New Socio</a>
            </td>
        </tr>
    </table>
    <input type="hidden" name="insere_soc" value="1"/>
</form>
<a href="http://localhost/projeto_final/noticias/adm">New noticia</a>
<a href='http://localhost/projeto_final/associacoes/assocquotas/<? echo $id_assoc; ?>'>Quotas ADM</a>
<div class="wrap">
    <?
    $lista = $modelo->getSociosAssoc($id_assoc);
    ?>
    <h1>Lista de socios da associação: <? echo $modelo->get_assoc_by_id($id_assoc) ?></h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $assoc): ?>
            <tr>
                <td><? echo $assoc['nome'];?></td>
                <td><? echo $assoc['email'];?></td>
                <td>
                    <a href="<? echo $edit_uri.$assoc['idSocio'].'/soc';?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$assoc['idSocio'].'/soc';?>" >Delete:</a>
                </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>
