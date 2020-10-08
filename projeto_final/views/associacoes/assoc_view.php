<p>ola</p>
<?php
if(!defined('ABSPATH')) exit;
$lista = $modelo->listar_assoc();
foreach ($lista as $assoc){
    echo $assoc['nome'].$assoc['telefone'];
}
?>



