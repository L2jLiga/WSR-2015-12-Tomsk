<?PHP 
require_once 'header.php';

// Выборка товара по переданному АйДишнику
if((isset($_GET['tovar'])) and (!empty($_GET['tovar']))) {
	$res = mysql_fetch_assoc(mysql_query("SELECT * FROM `Goods` WHERE `id` = '".$_GET['tovar']."'"));	
} else {
	header('location: /');
}
?>
		<h2><?PHP echo $res['name']?></h2>
		<div id="foto">
			<img src="<?PHP echo $res['foto']?>" alt="<?PHP echo $res['name']?>"/>
			<p><?PHP echo $res['cost']?></p>
		</div>
		<article id="description">
			<h3>Описание товара:</h3>
			<p><?PHP echo $res['description'] ?></p>
		</article>
<?php
	require_once 'footer.php';
?>