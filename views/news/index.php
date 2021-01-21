<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>AT Shop</title>
    <link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <link href="../../css/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
	<div id="menu-wrapper">
		<div id="menu">
			<ul>
				<li class="current_page_item"><a href="#">Гланая</a></li>
				<li><a href="#">Блог</a></li>
				<li><a href="#">Галерея</a></li>
				<li><a href="#">О нас...</a></li>
				<li><a href="#">Ссылки</a></li>
				<li><a href="#">Контакты</a></li>
			</ul>
		</div>
		<!-- end #menu -->
	</div>

<div id="wrapper">
	<div id="header-wrapper">
		<div id="header">
			<div id="logo">
				<h1><a href="#">AT Shop</a></h1>
				<p>Шаблоны для сайта <a href="http://www.ftemplate.ru/">СКАЧАТЬ</a></p>
			</div>
		</div>
	</div>
	<!-- end #header -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content">
					<?php foreach ($newsList as $newsItem):?>
					<div class="post">
						<h2 class="title"><a href='/news/n/<?php echo $newsItem['id_news'] ;?>'><?php echo $newsItem['title'].' # '.$newsItem['id_news'];?></a></h2>
						<p class="meta">Posted by <a href="#"><?php echo $newsItem['author_name'];?></a> on <?php echo $newsItem['date'];?>
							&nbsp;&bull;&nbsp; <a href='/news/n/<?php echo $newsItem['id_news'] ;?>' class="permalink">Полностью...</a></p>
						<div class="entry">
							<p><img src="../../images/pic01.jpg" width="800" height="300" alt="" /></p>
							<p><?php echo $newsItem['short_content'];?></p>
						</div>
					</div>
				    <?php endforeach;?>
				    <div style="clear: both;">&nbsp;</div>
				</div>
				<!-- end #content -->
				<div id="sidebar">
					<ul>
						<li>
							<h2>Занять некоторое время</h2>
							<p>Mauris vitae nisl placerat perdiet, как и страх перед этим. Нам протеин всегда является водородным бюро.</p>
						</li>
						<li>
							<h2>Категории</h2>
							<ul>
								<li><a href="#">Занять некоторое время</a></li>
								<li><a href="#">Исследования хранения водорода</a></li>
								<li><a href="#">Опасения за некоторых детей</a></li>
								<li><a href="#">Маурис по авторскому праву</a></li>
								<li><a href="#">Урнанет не Особые</a></li>
								<li><a href="#">Микроволновая печь для беременных</a></li>
							</ul>
						</li>
						<li>
							<h2>Блогролл</h2>
							<ul>
                                <li><a href="#">Занять некоторое время</a></li>
								<li><a href="#">Исследования хранения водорода</a></li>
								<li><a href="#">Опасения за некоторых детей</a></li>
								<li><a href="#">Маурис по авторскому праву</a></li>
								<li><a href="#">Урнанет не Особые</a></li>
								<li><a href="#">Микроволновая печь для беременных</a></li>
							</ul>
						</li>
						<li>
							<h2>Архив</h2>
							<ul>
                                <li><a href="#">Занять некоторое время</a></li>
								<li><a href="#">Исследования хранения водорода</a></li>
								<li><a href="#">Опасения за некоторых детей</a></li>
								<li><a href="#">Маурис по авторскому праву</a></li>
								<li><a href="#">Урнанет не Особые</a></li>
								<li><a href="#">Микроволновая печь для беременных</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<!-- end #sidebar -->
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
	<!-- end #page -->
</div>
<div id="footer">
	<p>Copyright (c) 2021 at-shop.com. All rights reserved. Design by Alexandr Tarayev. Photos by Alexandr Tarayev.</p>
</div>
<!-- end #footer -->
</body>
</html>
