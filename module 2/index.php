<?PHP
require_once 'header.php';
/* В режиме администратора отразит нам форму добавления товара */
if (isset($_GET['admin'])) {
		echo '<form action="upload.php" method="POST" enctype="multipart/form-data">
		<div id="item">
			Название товара<br/>
			<input type="text" name="name" pattern="[A-Za-zА-Яа-я ]{6,64}" required placeholder="Введите название товара" /><br/>
			Стоимость<br/>
			<input type="text" name="cost" pattern="[0-9]{1,10}" required placeholder="Введите стоимость товара в рублях" />
		</div>
		<div id="item">
			Категория<br/>
			<select name="category" required>
				<option></option>
				<option value="1">Твердые сыры</option>
				<option value="2">Полутвердые сыры</option>
				<option value="3">Мягкие сыры</option>
			</select><br/>
			Загрузить файл<br/>
			<input type="file" name="file" required accept="image/png, image/jpeg, image/jpg" />
		</div>
		<div id="item">
			Описание<br/>
			<textarea name="descript" rows="3" required></textarea><br/>
			<input type="submit" id="submit" name="submit" value="Добавить"/>
		</div>
		</form>';}?>
		<?PHP
			// Узнаем выбран ли у нас раздел?
			if ((isset($_GET['cat']) & !empty($_GET['cat']))) {
				$cat = "WHERE `category` = '".$_GET['cat']."'"; // Выбран - узнаем какой
			} else {
				$cat =""; // Не выбран - будем выводить все
			}
			$result = mysql_query("select * from `goods` ".$cat." ORDER BY `name`", $db); // Получаем элементы из DB
			// Вывод товаров в каталог
			while($result2 = mysql_fetch_assoc($result)) {
				
			ECHO '<div id="item">';
			if (isset($_GET['admin'])) {
				echo '<p id="delete"><a href="/delete.php?delete='.$result2['id'].'"><img src="res/delete.png" alt="Удалить товар" /></a></p>';
			}
			echo '<p>'. $result2['cost'] .'</p>
			<a href="info.php?tovar='.$result2['id'].'" target="_black"><img src="'. $result2['mini-foto'] .'" alt=""/></a>
			'. $result2['name'].'</div>';
			}
			?>

<?PHP require_once 'footer.php';?>