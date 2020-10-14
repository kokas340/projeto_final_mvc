<?php
verifyPath();
$id_assoc = 0;
if(chk_array($this->parametros, 0))
    $id_assoc = chk_array($this->parametros, 0);
$adm_uri = HOME_URI.'/associacoes/assocquotas/'.$id_assoc.'/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
$modelo->inserir_quotas();
?>
<form method="post" action="" enctype="multipart/form-data">
    <table class="form-table">
        <tr>
            <td>
                Preco: <br>
                <input type="text" name="preco" value="<? echo htmlentities(chk_array($modelo->form_data, 'preco'));?>" />
            </td>
        </tr>
        <tr>
            <td>
                Data Comeco: <br>
                <input name="dataComeco" type="text" value="<? echo htmlentities(chk_array($modelo->form_data, 'dataComeco')); ?>">
            </td>
        </tr>
        <tr>
            <td>
                Data Termino: <br>
                <input name="dataTermino" type="text" value="<? echo htmlentities(chk_array($modelo->form_data, 'dataTermino')); ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="idSocio">Escolhe o socio:</label>
                <select name="idSocio" id="idSocio">
                    <?
                    $list_assoc = $modelo->getAll('socios');
                    foreach ($list_assoc as $item):
                        ?>
                        <option name ="idSocio" value="<? echo htmlentities($item['idSocio']); ?>"><? echo htmlentities($item['nome']); ?></option>
                    <? endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?
                echo $modelo->form_msg;
                ?>
                <input type="submit" value="Save"/>
                <a href="<?echo HOME_URI.'/associacoes/assocquotas/'.$id_assoc;?>">New Quota</a>
            </td>
        </tr>
    </table>
    <input type="hidden" name="insere_quota" value="1"/>
</form>

<div class="wrap">
    <?
    $lista = $modelo->getSociosAssoc($id_assoc);
    ?>
    <h1>Lista de quotas da associação: <? echo $modelo->get_assoc_by_id($id_assoc) ?></h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Quota</th>
            <th>Data Comeco</th>
            <th>Data Termino</th>
            <th>Edit Quotas</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $socio): ?>
            <tr>
                <td><? echo $socio['nome'];?></td>
                <td><? echo $socio['email'];?></td>
                <td><? echo $modelo->obterQuotasById($socio['idSocio'], 'preco');?></td>
                <td><? echo $modelo->obterQuotasById($socio['idSocio'], 'dataComeco');?></td>
                <td><? echo $modelo->obterQuotasById($socio['idSocio'], 'dataTermino');?></td>
                <td>
                    <a href="<? echo $edit_uri.$socio['idSocio'].'/soc';?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$socio['idSocio'].'/soc';?>" >Delete:</a>
                </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>


