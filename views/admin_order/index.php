<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>
                        
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li class="active">Управление заказами</li>
                </ol>
            </div>

            <h4>Список заказов</h4>

            <br/>

            <table class="table-bordered table-striped table">
                <tr>
                    <th>Номер заказа</th>
                    <th>Имя покупателя</th>
                    <th>Телефон покупателя</th>
                    <th>Дата оформления</th>
                    <th>Обработан</th>
                    <th>Посмотреть</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                <?php foreach ($ordersList as $order): ?>
                    <tr>
                        <td>
                            <a href="/admin/order/view/<?php echo $order['id_ord']; ?>">
                                <?php echo $order['name_ord']; ?>
                            </a>
                        </td>
                        <td><?php echo $order['name_user']; ?></td>
                        <td><?php echo $order['phone_user']; ?></td>
                        <td><?php echo $order['date_ord']; ?></td>
                        <td>
                            <?php if($order['ord_is_finish'] == 1): ?>
                                <input type="checkbox" checked disabled/>
                            <?php else: ?>
                                <input type="checkbox" disabled/>
                            <?php endif; ?>
                        </td>    
                        <td><a href="/admin/order/view/<?php echo $order['id_ord']; ?>" title="Смотреть"><i class="fa fa-eye"></i></a></td>
                        <td><a href="/admin/order/update/<?php echo $order['id_ord']; ?>" title="Редактировать"><i class="fa fa-pencil-square-o"></i></a></td>
                        <td><a href="/admin/order/delete/<?php echo $order['id_ord']; ?>" title="Удалить"><i class="fa fa-times"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
