<?php
class EventosAdmModel extends ItemsAbstract{

    function insere_form()
    {
        return 'insere_evento';
    }

    function table_name()
    {
        return 'eventos';
    }

    function id_table()
    {
        return 'idEvento';
    }

    function url_name()
    {
        return 'evento';
    }

    function haveImage()
    {
        return true;
    }
}
