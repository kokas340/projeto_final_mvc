<?php
class AssociacoesAdmModel extends ItemsAbstract {
    function insere_form()
    {
        return 'insere_assoc';
    }

    function table_name()
    {
        return 'associacao';
    }

    function id_table()
    {
        return 'idAssoc';
    }

    function url_name()
    {
        return 'associacoes';
    }

    function haveImage()
    {
        return false;
    }
}
?>