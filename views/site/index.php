<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Каталог</h2>
                    <div class="panel-group category-products">
                        <?php foreach ($categories as $categoryItem): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="/category/<?php echo $categoryItem['id_cat'];?>">
                                            <?php echo $categoryItem['name_cat'];?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Последние товары</h2>
                    
                    <?php foreach ($latestProducts as $product): ?>
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <a href="/product/<?php echo $product['id_prod'];?>">
                                            <img src=<?php echo '../..' . $product['image_prod'] ?> alt="" />
                                        </a>
                                        <h2><?php echo $product['price_prod'];?>тг</h2>
                                        <p>
                                            <a href="/product/<?php echo $product['id_prod'];?>">
                                                <?php echo $product['name_prod'];?>
                                            </a>
                                        </p>
                                        <a href="/cart/add/<?php echo $product['id_prod']; ?>" class="btn btn-default add-to-cart"
											data-id="<?php echo $product['id_prod']; ?>"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                    </div>
                                    <?php if ($product['is_new']): ?>
                                        <img src="../../images/home/new.png" class="new" alt="" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div><!--features_items-->

                <div class="recommended_items"><!--recommended_items-->
                    <h2 class="title text-center">Рекомендуемые товары</h2>
                    
                    <div class="cycle-slideshow" 
                        data-cycle-fx=carousel
                        data-cycle-timeout=3000
                        data-cycle-carousel-visible=3
                        data-cycle-carousel-fluid=true
                        data-cycle-slides="div.item"
                        data-cycle-prev="#prev"
                        data-cycle-next="#next">
                        
                        <?php foreach ($sliderProducts as $sliderItem): ?>
                            <div class="item">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="../../<?php echo $sliderItem['image_prod']; ?>" alt="" />
                                            <h2><?php echo $sliderItem['price_prod']; ?>тг</h2>
                                            <a href="/product/<?php echo $sliderItem['id_prod']; ?>">
                                                <?php echo $sliderItem['name_prod']; ?>
                                            </a>
                                            <br/><br/>
                                            <a href="#" class="btn btn-default add-to-cart" data-id="<?php echo $sliderItem['id_prod']; ?>"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                        </div>
                                        <?php if ($sliderItem['is_new']): ?>
                                            <img src="../../images/home/new.png" class="new" alt="" />
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div><!--/recommended_items-->

            </div>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>