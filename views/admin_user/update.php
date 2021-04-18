<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/user">Управление пользователями</a></li>
                    <li class="active">Добавить пользователя</li>
                </ol>
            </div>


            <h4>Добавить нового пользователя</h4>

            <br/>

            <?php if (isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li id="blink1"> - <?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post">

                        <p>Имя пользователя</p>
                        <input type="text" name="name" value="<?php echo $name; ?>" disabled>

                        <p>E-mail</p>
                        <input type="text" name="email" value="<?php echo $email; ?>" disabled>

                        <p>Телефон</p>
                        <input type="text" name="phone" value="<?php echo $phone; ?>" disabled>

                        <p>Пароль</p>
                        <input type="password" name="pwd" value="<?php echo $password; ?>">

                        <p>Роли</p>
                        <hr>
                        <table class="table-striped table">
                            <?php $i = 0; ?>
                            <?php foreach ($roles as $role): ?>
                                <?php $i++; ?>
                                <tr>
                                    <td><?php echo $role['name_role']; ?></td>
                                    <td align="right">
                                        <input type="checkbox" name="roles_html[<?php echo $i; ?>]" value="<?php echo $role['id_role']; ?>" 
                                            <?php foreach($roles_user as $urole):
                                                if($role['id_role'] == $urole['id_role']): ?>
                                                    checked
                                                <?php endif;
                                            endforeach; ?>>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        
                        <br><br>

                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                    </form>
                </div>
            </div>


        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
