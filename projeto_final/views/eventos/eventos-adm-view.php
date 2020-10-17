<?verifyPath();?>

<?
//configura as URLs
$adm_uri = HOME_URI.'/evento/adm/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
?>

<div class="wrap">
    <?
    //mensagem de configuracao caso user tente apagar algo
    echo $modelo->form_confirma;
    $modelo->insere_items();
    $modelo->obter_items();
    $modelo->delete_items();
    ?>
    <!--
    Formulario de edicao de projetos
    -->
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
                    Titulo: <br>
                    <input type="text" name="titulo" value="<? echo htmlentities(chk_array($modelo->form_data, 'titulo'));?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Evento: <br>
                    <input type="text" name="evento" value="<? echo htmlentities(chk_array($modelo->form_data, 'evento'));?>" />
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
                </td>
            </tr>
        </table>
        <input type="hidden" name="insere_evento" value="1"/>
    </form>


    <!-- Lista os projetos -->
    <?
    $lista = $modelo->listar_items();
    ?>
    <h1>Lista de Projetos</h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Evento</th>
            <th>Imagem</th>
            <th>Edicao</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $evento): ?>
            <tr>
                <td><a href="<? echo HOME_URI.'/assoc/index/'.$evento['idEvento'];?>"><? echo $evento['idEvento'];?></a></td>
                <td><? echo $evento['titulo'];?></td>
                <td><? echo $evento['evento'];?></td>
                <td>
                    <p>
                        <img src="<?echo HOME_URI.'/views/_uploads/'.$evento['imagem'];?>" width="30px">
                    </p>
                </td>
                <td>
                    <a href="<? echo $edit_uri.$evento['idEvento'];?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$evento['idEvento'];?>" >Delete:</a>
                </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>
