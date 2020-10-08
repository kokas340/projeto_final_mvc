<?
function chk_array($array, $key){
    //Verifica se a chave existe no array
    if(isset($array[$key]) && !empty($array[$key])) //isset existe empty vazio
        return $array[$key];
    return null;
}

function __autoload($class_name){
    $file = ABSPATH.'/classes/class-'.$class_name.'.php';
    if(!file_exists($file)){
        require_once ABSPATH.'/includes/404.php';                            
        return;
    }
    require_once $file;
}


//require se houver erros fatais na app nao crasha
//include se houver erros fatais na app crasha
?>