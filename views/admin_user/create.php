<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/order">Управление пользователями</a></li>
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
                        <input type="text" name="name" placeholder="" value="">

                        <p>E-mail</p>
                        <input type="text" name="email" placeholder="" value="">

                        <p>Телефон</p>
                        <input type="text" name="phone" placeholder="" value="">

                        <p>Пароль</p>
                        <input type="text" name="pwd" placeholder="" value="">

                        <p>Роли</p>
                        <hr>
                        <table class="table-striped table">
                            <?php foreach ($roles as $role): ?>
                                <tr>
                                    <td><?php echo $role['name_role']; ?></td><td align="right"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
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
