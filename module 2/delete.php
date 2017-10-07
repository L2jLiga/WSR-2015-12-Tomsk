<?PHP
/* настройки подключения к БД */
$db = mysql_connect('localhost','root','');
mysql_select_db('site', $db);
mysql_set_charset("UTF8", $db);

if(isset($_GET['delete']) & !empty($_GET['delete'])) {
	mysql_query("DELETE FROM `goods` WHERE `id` ='". $_GET['delete'] ."'");
}
header("location: /?admin");
?>