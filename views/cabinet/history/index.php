<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <h4>Список заказов</h4>

            <br/>

            <table class="table-bordered table-striped table">
                <tr>
                    <th>Номер заказа</th>
                    <th>Дата оформления</th>
                    <th>Сумма заказа</th>
                    <th>Статус</th>
                    <th>Посмотреть</th>
                </tr>
                <?php foreach ($ordList as $ord): ?>
                    <tr>
                        <td>
                            <a href="/cabinet/view/<?php echo $ord['id_ord']; ?>">
                                <?php echo $ord['name_ord']; ?>
                            </a>
                        </td>
                        <td><?php echo $ord['date_ord']; ?></td>
                        <td><?php echo $ord['total_ord']; ?></td>
                        <td>
                            <?php if($ord['ord_is_finish'] == 1): ?>
                                <span>Завершён</span>
                            <?php else: ?>
                                <span>Не завершён</span>
                            <?php endif; ?>
                        </td>    
                        <td><a href="/cabinet/view/<?php echo $order['id_ord']; ?>" title="Смотреть"><i class="fa fa-eye"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>
