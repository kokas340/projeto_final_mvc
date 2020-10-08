<?if(!defined('ABSPATH')) exit;?>

<div class="wrap">
    <?
    //numero de posts por pagina
    //$modelo->post_por_pagina = 10;
    //lista projetos
    $lista = $modelo->listar_projetos();
    ?>
    <h1>Lista de Projetos</h1>
    <?foreach ($lista as $projeto):?>
        <h1>
            <a href="<? echo HOME_URI;?>/projetos/index/<?echo $projeto['idProjeto']?>"><?echo $projeto['descricao']?></a>
        </h1>
        <?
        //verifica se estamos a visualizar um unico projeto
        if(is_numeric(chk_array($modelo->parametros,0))):?>
        <?
        $this->prev_page = true;
        if($this->prev_page){
            ?>
            <a href="<?echo HOME_URI?>/projetos/index/">Voltar</a>
            <?}?>
            <p>
                <?echo $modelo->inverte_data($projeto['dataExec']);?>|<? echo $projeto['dataExec'];?>
            </p>
            <p>
                <img src="<?echo HOME_URI.'/views/_uploads/'.$projeto['imagem'];?>">
            </p>
        <?echo $projeto['link'];?>
        <?endif;?>

        <? endforeach;?>
        <?$modelo->paginacao();?>
</div>