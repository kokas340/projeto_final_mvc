<?
verifyPath();
$assoc = $modelo->getAll('associacao');
?>

<div class="wrap">
    <? foreach ($assoc as $name):?>
        <p>Imagem por: <? echo $name['nome'];?></p>
        <?$lista = $modelo->get_images_by_id($name['idAssoc']);?>
        <? foreach ($lista as $img):?>
            <img src="<?echo HOME_URI.'/views/_uploads/'.$img['titulo'];?>" width="300" height="300">
        <? endforeach;?>
    <? endforeach;?>
</div>