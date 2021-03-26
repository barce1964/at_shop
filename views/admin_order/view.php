<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/order">Управление заказами</a></li>
                    <li class="active">Просмотр заказа</li>
                </ol>
            </div>


            <h4>Просмотр заказа #<?php echo $order['name_ord']; ?></h4>
            <br/>
            <h5>Информация о заказе</h5>
            <table class="table-admin-small table-bordered table-striped table">
                <!-- <tr>
                    <td>Номер заказа</td>
                    <td><?php //echo $order['name_ord']; ?></td>
                </tr> -->
                <tr>
                    <td>Имя клиента</td>
                    <td><?php echo $order['name_user']; ?></td>
                </tr>
                <tr>
                    <td>Телефон клиента</td>
                    <td><?php echo $order['phone_user']; ?></td>
                </tr>
                
                <!-- <?php //if ($order['user_id'] != 0): ?>
                    <tr>
                        <td>ID клиента</td>
                        <td><?php //echo $order['user_id']; ?></td>
                    </tr>
                <?php //endif; ?> -->
                <tr>
                    <td><b>Статус заказа</b></td>
                    <td>
                        <?php if ($order['ord_is_finish'] == 1): ?>
                            Выполнен
                        <?php else: ?>
                            Не выполнен
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Дата заказа</b></td>
                    <td><?php echo $order['date_ord']; ?></td>
                </tr>
            </table>

            <h5>Товары в заказе</h5>

            <table class="table-admin-medium table-bordered table-striped table ">
                <tr>
                    <th>Артикул товара</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                </tr>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['prod_code']; ?></td>
                        <td><?php echo $product['prod_name']; ?></td>
                        <td><?php echo $product['prod_price']; ?> тг</td>
                        <td><?php echo $product['prod_quantity']; ?></td>
                        <td><?php echo $product['prod_sum']; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr><td colspan='4'>Общая стоимость:</td><td><?php echo $order['total_ord']; ?></td></tr>
            </table>

            <a href="/admin/order/" class="btn btn-default back"><i class="fa fa-arrow-left"></i> Назад</a>
        </div>


</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>