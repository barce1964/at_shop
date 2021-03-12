<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/product">Управление товарами</a></li>
                    <li class="active">Редактировать товар</li>
                </ol>
            </div>


            <h4>Редактировать товар #<?php echo $id; ?></h4>

            <br/>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">

                        <p>Название товара</p>
                        <input type="text" name="name" placeholder="" value="<?php echo $product[0]['name_prod']; ?>">

                        <p>Артикул</p>
                        <input type="text" name="code" placeholder="" value="<?php echo $product[0]['code_prod']; ?>">

                        <p>Стоимость, тг</p>
                        <input type="text" name="price" placeholder="" value="<?php echo $product[0]['price_prod']; ?>">

                        <p>Категория</p>
                        <select name="category_id">
                            <?php if (is_array($categoriesList)): ?>
                                <?php foreach ($categoriesList as $category): ?>
                                    <option value="<?php echo $category['id_cat']; ?>" 
                                        <?php if ($product[0]['id_cat'] == $category['id_cat']) echo ' selected="selected"'; ?>>
                                        <?php echo $category['name_cat']; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        
                        <br/><br/>

                        <p>Производитель</p>
                        <input type="text" name="brand" placeholder="" value="<?php echo $product[0]['brand_prod']; ?>">

                        <p>Изображение товара</p>
                        <img src="<?php echo Product::getImage($product[0]['id_prod']); ?>" width="200" alt="" />
                        <input type="file" name="image" placeholder="" value="<?php echo $product[0]['image_prod']; ?>">

                        <p>Детальное описание</p>
                        <textarea name="description"><?php echo $product[0]['descr_prod']; ?></textarea>
                        
                        <br/><br/>

                        <p>Наличие на складе</p>
                        <select name="availability">
                            <option value="1" <?php if ($product[0]['availability'] == 1) echo ' selected="selected"'; ?>>Да</option>
                            <option value="0" <?php if ($product[0]['availability'] == 0) echo ' selected="selected"'; ?>>Нет</option>
                        </select>
                        
                        <br/><br/>
                        
                        <p>Новинка</p>
                        <select name="is_new">
                            <option value="1" <?php if ($product[0]['is_new'] == 1) echo ' selected="selected"'; ?>>Да</option>
                            <option value="0" <?php if ($product[0]['is_new'] == 0) echo ' selected="selected"'; ?>>Нет</option>
                        </select>
                        
                        <br/><br/>

                        <p>Рекомендуемые</p>
                        <select name="is_recommended">
                            <option value="1" <?php if ($product[0]['is_rec'] == 1) echo ' selected="selected"'; ?>>Да</option>
                            <option value="0" <?php if ($product[0]['is_rec'] == 0) echo ' selected="selected"'; ?>>Нет</option>
                        </select>
                        
                        <br/><br/>

                        <p>Статус</p>
                        <select name="status">
                            <option value="1" <?php if ($product[0]['status_prod'] == 1) echo ' selected="selected"'; ?>>Отображается</option>
                            <option value="0" <?php if ($product[0]['status_prod'] == 0) echo ' selected="selected"'; ?>>Скрыт</option>
                        </select>
                        
                        <br/><br/>
                        
                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                        
                        <br/><br/>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
