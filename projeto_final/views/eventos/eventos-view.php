<?verifyPath();?>

<div class="wrap">
    <?
    //numero de posts por pagina
    //$modelo->post_por_pagina = 10;
    //lista projetos
    $lista = $modelo->listar_items();
    ?>
    <h1>Lista de Noticias</h1>
    <?foreach ($lista as $eventos):?>
        <h1>
            <a href="<? echo HOME_URI?>/evento/index/<?echo $eventos['idEvento']?>"><?echo $eventos['titulo']?></a>
        </h1>
        <?
        //verifica se estamos a visualizar um unico projeto
        if(is_numeric(chk_array($modelo->parametros,0))):?>
            <p>Titulo: <?echo $eventos['titulo'];?></p>
            <p>Evento: <?echo $eventos['evento'];?></p>
            <p>
                <img src="<?echo HOME_URI.'/views/_uploads/'.$eventos['imagem'];?>">
            </p>
            <?
            $this->prev_page = true;
            if($this->prev_page){
                ?>
                <a href="<?echo HOME_URI?>/evento/index/">Voltar</a>
            <?}?>
        <?endif;?>

    <? endforeach;?>
    <?$modelo->paginacao();?>
</div>