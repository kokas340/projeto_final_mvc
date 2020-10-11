<?if(!defined('ABSPATH')) exit;?>

<?
//configura as URLs
$adm_uri = HOME_URI.'/noticias/adm/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
?>

<div class="wrap">
    <?
    //mensagem de configuracao caso user tente apagar algo
    echo $modelo->form_confirma;
    $modelo->insere_noticias();
    $modelo->obter_noticas();
    $modelo->delete_noticias();
    ?>
    <!--
    Formulario de edicao de projetos
    -->
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
                    Título: <br>
                    <input type="text" name="titulo" value="<? echo htmlentities(chk_array($modelo->form_data, 'titulo'));?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Notícia: <br>
                    <input type="text" name="noticia" value="<? echo htmlentities(chk_array($modelo->form_data, 'noticia'));?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Imagem: <br>
                    <input type="file" name="imagem" value=""/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?
                    echo $modelo->form_msg;
                    ?>
                    <input type="submit" value="Save"/>
                    <a href="<?echo HOME_URI.'/noticias/adm';?>">New Noticias</a>
                </td>
            </tr>
        </table>
        <input type="hidden" name="insere_noticia" value="1"/>
    </form>


    <!-- Lista os projetos -->
    <?
    $lista = $modelo->listar_noticias();
    ?>
    <h1>Lista de Noticias</h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Noticia</th>
            <th>Imagem</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $noticias): ?>
            <tr>
                <td><a href="<? echo HOME_URI.'/noticias/index/'.$noticias['idNoticia'];?>"><? echo $noticias['idNoticia'];?></a></td>
                <td><? echo $noticias['titulo'];?></td>
                <td><? echo $noticias['noticia'];?></td>
                <td>
                    <p>
                        <img src="<? echo HOME_URI.'views/_uploads/'.$noticias['imagem'];?>" width="30px">
                    </p>
                </td>
                <td>
                    <a href="<? echo $edit_uri.$noticias['idNoticia'];?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$noticias['idNoticia'];?>" >Delete:</a>
                </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>