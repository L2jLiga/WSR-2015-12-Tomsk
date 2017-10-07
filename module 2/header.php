<?PHP
/* настройки подключения к БД */
$db = mysql_connect('localhost','root','');
mysql_select_db('site', $db);
mysql_set_charset("UTF8", $db);
error_reporting(0);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Сырный Сомелье</title>
	<link rel="stylesheet" type="text/css" href="res/style.css" />
	<link rel="stylesheet" type="text/css" href="res/main.css" />
</head>
<body>
<div id="background"></div>
<!-- Логотип -->
<header id="header">
	<div id="logotype"><a href="/<?PHP if (isset($_GET['admin'])) echo '?admin';?>"><img src="res/logotip.png" alt="Сырный сомелье" /></a></div>
	<div id="modes"><?PHP
	/* Переход к режиму администратора и обратно */
	if (isset($_GET['admin'])) {
		echo '<a href="/?cat='.$_GET['cat'].'">Перейти в режим пользователя</a>';
	} else {
		echo '<a href="/?admin&cat='.$_GET['cat'].'">Перейти в режим администратора</a>';
	}?></div>
</header>

<!-- Середина -->
<div id="main">
	<!-- Левое меню -->
	<div id="left">
		<nav>
		<?PHP
		// Варианты меню для пользователя и адмигистратора
		if (isset($_GET['admin'])) {
			echo '<a href="/?admin&cat=1"><div>Твердые сыры</div></a>
			<a href="/?admin&cat=2"><div>Полутвердые сыры</div></a>
			<a href="/?admin&cat=3"><div>Мягкие сыры</div></a>';
		} else {
			echo '<a href="/?cat=1"><div>Твердые сыры</div></a>
			<a href="/?cat=2"><div>Полутвердые сыры</div></a>
			<a href="/?cat=3"><div>Мягкие сыры</div></a>';
		}?>
			
		</nav>
	</div>


	<!-- Каталог -->
	<div id="catalog">