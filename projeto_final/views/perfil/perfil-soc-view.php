<?php
verifyPath();
$id_soc = 0;
//print_r($this->parametros);
if(chk_array($this->parametros, 0))
    $id_soc = chk_array($this->parametros, 0);
else
    header('location: '.HOME_URI);
$socio = $modelo->get_soc_by_id($id_soc);
$adm_uri = HOME_URI.'/perfil/me/'.$id_soc.'/';
$pagamento_uri = $adm_uri.'pay/';
$modelo->pay($this->parametros);
?>
<p>
    <img src="<?echo HOME_URI.'/views/_uploads/login.png';?>" width="100" height="100">
</p>
<p>Nome: <? echo $socio['nome'];?></p>
<p>User Name: <? echo $socio['login'];?></p>
<p>Email: <? echo $socio['email'];?></p>
<p>Associação: <? echo $modelo->get_assoc_by_id($socio['idAssoc']); ?></p>

<div class="wrap">
    <?
    $lista = $modelo->getQuotas($id_soc);
    ?>
    <h1>Lista de quotas:</h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>Preço</th>
            <th>Data Comeco</th>
            <th>Data Termino</th>
            <th>Pagamentos de quotas</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $quotas): ?>
            <?if($quotas['pago'] == 0):?>
            <tr>
                <td><? echo $quotas['preco'];?></td>
                <td><? echo $quotas['dataComeco'];?></td>
                <td><? echo $quotas['dataTermino'];?></td>
                <td>
                    <a href="<? echo $pagamento_uri.$quotas['idQuota']?>" >Pagar:</a>
                </td>
            </tr>
            <? endif;?>
        <? endforeach;?>
        </tbody>
    </table>
</div>
