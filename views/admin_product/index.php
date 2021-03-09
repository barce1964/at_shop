<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li class="active">Управление товарами</li>
                </ol>
            </div>
            
            <form action="#" method="post" id="cat">
                <div class="seladm">
                    <label class="active">Категории товаров:</label>
                    <select id="catselect" name="selcat" class="selcat" size='1'">
                        <?php foreach ($categories as $category): ?>
                            <option value = "<?php echo $category['id_cat']; ?>"
                                <?php if ($idCat == $category['id_cat']): ?>
                                    selected
                                <?php endif; ?> >
                                <?php echo $category['name_cat']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- <input type="submit" name="submit" class="btn btn-default" value="Отправить" /> -->
                </div>
            </form>
            
            <a href="/admin/product/create" class="btn btn-default back"><i class="fa fa-plus"></i> Добавить товар</a>
            
            <h4>Список товаров</h4>

            <br/>

            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID товара</th>
                    <th>Артикул</th>
                    <th>Название товара</th>
                    <th>Цена, тг</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($productsList as $product): ?>
                    <tr>
                        <td><?php echo $product['id_prod']; ?></td>
                        <td><?php echo $product['code_prod']; ?></td>
                        <td><?php echo $product['name_prod']; ?></td>
                        <td><?php echo $product['price_prod']; ?></td>  
                        <td><a href="/admin/product/update/<?php echo $product['id_prod']; ?>" title="Редактировать"><i class="fa fa-pencil-square-o"></i></a></td>
                        <td><a href="/admin/product/delete/<?php echo $product['id_prod']; ?>" title="Удалить"><i class="fa fa-times"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
