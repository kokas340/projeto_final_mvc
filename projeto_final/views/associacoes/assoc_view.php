<p>ola</p>
<?php
//if(!defined('ABSPATH')) exit;
/*$lista = $modelo->listar_assoc();
foreach ($lista as $assoc){
    echo $assoc['nome'].$assoc['telefone'];
}*/
?>



<?if(!defined('ABSPATH')) exit;

?>

<div class="wrap">
    <?
    //numero de posts por pagina
    //$modelo->post_por_pagina = 10;
    //lista projetos
    $lista = $modelo->listar_associacoes();
    ?>
    <h1>Lista de Associações</h1>
    <?foreach ($lista as $assoc):?>
        <h1>
            <a href="<? echo HOME_URI?>/associacoes/index/<?echo $assoc['idAssoc']?>"><?echo $assoc['nome']?></a>
        </h1>
        <?
        //verifica se estamos a visualizar um unico projeto
        if(is_numeric(chk_array($modelo->parametros,0))):?>
            <p>Nome: <?echo $assoc['nome'];?></p>
            <p>Morada: <?echo $assoc['morada'];?></p>
            <?
            $this->prev_page = true;
            if($this->prev_page){
                ?>
                <a href="<?echo HOME_URI?>/associacoes/index/">Voltar</a>
            <?}?>
        <?endif;?>

    <? endforeach;?>
    <?$modelo->paginacao();?>
</div>