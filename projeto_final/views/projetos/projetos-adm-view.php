<?if(!defined('ABSPATH')) exit;?>

<?
//configura as URLs
$adm_uri = HOME_URI.'/projetos/adm/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';

//carrega o metodo para obter projetos
$modelo->obter_projetos();
//carrega o metodo para inserir os projetos
$modelo->insere_projeto();
//carrega o metodo apagar projetos
$modelo->form_confirma = $modelo->apaga_projeto();

//remove o limite de valores da lista de projetos
$modelo->sem_limite = false;
//Número de posts por pagina
?>

<div class="wrap">
    <?
    //mensagem de configuracao caso user tente apagar algo
    echo $modelo->form_confirma;
    ?>
    <!-- 
    Formulario de edicao de projetos
    -->
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
                    Descricao: <br>
                    <input type="text" name="descricao" value="<? echo htmlentities(chk_array($modelo->form_data, 'descricao'));?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Imagem: <br>
                    <input type="file" name="imagem" value=""/>
                </td>
            </tr>
            <tr>
                <td>
                    Data: <br>
                    <input type="text" name="dataExec" value="<?
                    $data = chk_array($modelo->form_data, 'dataExec');
                    if($data && $data != '0000-00-00 00:00:00')
                        echo date('d-m-Y H:i:s', strtotime($data));
                    ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Link: <br>
                    <input type="text" name="link" value="<?
                    echo htmlentities(chk_array($modelo->form_data, 'link'));
                    ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?
                        echo $modelo->form_msg;
                    ?>        
                    <input type="submit" value="Save"/>
                    <a href="<?echo HOME_URI.'/projetos/adm';?>">New Project</a>
                </td>
            </tr>
        </table>
        <input type="hidden" name="insere_projeto" value="1"/>
    </form>
    
    <!-- Lista os projetos -->
    <?
    $lista = $modelo->listar_projetos();
    ?>
    <h1>Lista de Projetos</h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Desc</th>
                <th>Data</th>
                <th>Link</th>
                <th>Img</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($lista as $projeto): ?>
            <tr>
                <td><a href="<? echo HOME.URI.'/projetos/index/'.$projeto['idProjeto'];?>"><? echo $projeto['idProjeto'];?></a></td>
                <td><? echo $projeto['descricao'];?></td>
                <td><? echo $projeto['dataExec'];?></td>
                <td><? echo $projeto['link'];?></td>
                <td>
                    <p>
                        <img src="<? echo HOME_URI.'views/_uploads/'.$projeto['imagem'];?>" width="30px">
                    </p>
                </td>
                <td>
                    <a href="<? echo $edit_uri.$projeto['idProjeto'];?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$projeto['idProjeto'];?>" >Delete:</a>
                </td>
            </tr>
            <? endforeach;?>
        </tbody>
    </table>
    <? $modelo->paginacao(); ?>
</div>