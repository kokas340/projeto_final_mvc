<?if(!defined('ABSPATH')) exit;?>

<div class="wrap">
    <?
    //numero de posts por pagina
    //$modelo->post_por_pagina = 10;
    //lista projetos
    $lista = $modelo->listar_noticias();
    ?>
        <h1>Lista de Noticias</h1>
    <?foreach ($lista as $noticias):?>
        <h1>
            <a href="<? echo HOME_URI?>/noticias/index/<?echo $noticias['idNoticia']?>"><?echo $noticias['titulo']?></a>
        </h1>
        <?
        //verifica se estamos a visualizar um unico projeto
        if(is_numeric(chk_array($modelo->parametros,0))):?>
            <p>Noticia: <?echo $noticias['noticia'];?></p>
            <p>Imagem: <?echo $noticias['imagem'];?></p>
            <?
            $this->prev_page = true;
            if($this->prev_page){
                ?>
                <a href="<?echo HOME_URI?>/noticias/index/">Voltar</a>
            <?}?>
        <?endif;?>

    <? endforeach;?>
    <?$modelo->paginacao();?>
</div>