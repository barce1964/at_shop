<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

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

            <a href="/cabinet/history/" class="btn btn-default back"><i class="fa fa-arrow-left"></i> Назад</a>
        </div>


</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>