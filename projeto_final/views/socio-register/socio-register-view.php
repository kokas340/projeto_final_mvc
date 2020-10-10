<?php if(!defined('ABSPATH')) exit; ?>

<div class="wrap">

    <?php
    //Carrega todos os métodos do modelo
    $modelo->validate_register_form();
    $modelo->get_register_form(chk_array($parametros, 1));
    $modelo->del_user($parametros);
    ?>

    <form method="post" action="">
        <table class="form-table">
        <tr>
            <td>Nome: </td>
            <td><input type="text" name="nome" value="<?php echo htmlentities(chk_array($modelo->form_data,'nome')); ?>"/></td>
        </tr>
        <tr>
            <td>Email: </td>
            <td><input type="text" name="email" value="<?php echo htmlentities(chk_array($modelo->form_data,'email')); ?>"/></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type="password" name="password" value="<?php echo htmlentities(chk_array($modelo->form_data, 'password')); ?>"/></td>
        </tr>
        <tr>
            <td>Login user name: </td>
            <td><input type="text" name="login" value="<?php echo htmlentities(chk_array($modelo->form_data, 'login')); ?>"/></td>
        </tr>
        <tr>
            <td>Permissions<br><small>(Separate Permissions using commas</small>:</td>
            <td><input type="text" name="socio_permissions" value="<?php echo htmlentities(chk_array($modelo->form_data, 'socio_permissions')); ?>"/></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo $modelo->form_msg;?>
                <input type="submit" value="Save"/>
                <a href="<?php echo HOME_URI . '/socio-register';?>"New User</a>
            </td>
        </tr>
        </table>
    </form>

    <?php
        //Lista os users
        $lista = $modelo->get_user_list(); 
    ?>
    <h1>Lista de Socios</h1>
    <table class="list-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Permissões</th>
                <th>Edição</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista as $fetch_userdata): ?>
            <tr>
                <td><?php echo $fetch_userdata['idSocio']?></td>
                <td><?php echo $fetch_userdata['login'] ?></td>
                <td><?php echo $fetch_userdata['nome'] ?></td>
                <td><?php echo $fetch_userdata['email'] ?></td>
                <td><?php echo implode(',' , unserialize($fetch_userdata['socio_permissions'])) ?></td>
                <td>
                    <a href="<?php echo HOME_URI?>/socio-register/index/edit/<?php echo $fetch_userdata['idSocio']?>">Edit</a>
                    <a href="<?php echo HOME_URI?>/socio-register/index/del/<?php echo $fetch_userdata['idSocio']?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>