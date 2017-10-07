<?PHP
require_once 'header.php';

// В случае если у мы ничего не отправляли
$ok=1;
if (isset($_POST['submit'])) {

$errName=array();
// Проверка имени товара
$name = htmlspecialchars($_POST['name']);
if(!isset($name)) {
	$ok=0;
	$errName[]='Не введедено имя';
} else {
	if (!preg_match('/[A-Z-a-zА-Яа-я]+$/', $name)) {
	/* Неверные символы в имени*/
	$ok=0;
	$errName[]='используются недопустимые символы';
	} elseif ((strlen($name) > 100) or (strlen($name) < 6)) {
		/* Длина у нас за рамками */
	$errName[]='Длина товара большая';
	$ok=0;
	}
};



// Проверка стоимости
$cost = htmlspecialchars($_POST['cost']);
$errCost= array();
if(!isset($cost)) {
	// Пустое поле
	$errCost[]='Цена не введена';
	$ok=0;
} else {
	if(!preg_match('/[0-9]+$/', $cost)) {
	/* Цена неправильная */
	$errCost[]='Цена может содержать только цифры от 0 до 9';
	$ok=0;
}
if (strlen($cost) > 10) {
	/* Цена слишком большая */
	$errCost[]='Цена слишком большая';
	$ok=0;
}
};


// Категория товара
$category = htmlspecialchars($_POST['category']);
if(!isset($category)) {
	$ok=0;
	$errCat = 'Не выбрана категория';
};



// Описание товара
$description = htmlspecialchars($_POST['descript']);
if(!isset($description)) {
	$ok=0;
	$errDesc = 'описание не указано';
};

// Файл
$file = $_FILES['file'];
if(!isset($file)) {
	$ok=0;
} else {
	if ($file['type'] == 'image/png'){
		$src_img = imagecreatefrompng($file['tmp_name']);
	} elseif (($file['type'] == 'image/jpeg') || ($file['type'] == 'image/jpg')) {
		$src_img = imagecreatefromjpeg($file['tmp_name']);
	} else {
		// Неправильное расширение
		$ok=0;
	}

	$WxH = @getimagesize($file['tmp_name']);
	if ($WxH[0] !== $WxH[1]) {
	// У нас не квадратик
	$ok=0;
	}

	if ($WxH[0] > 1024) {
	// Слишком большое разрешение
	$ok=0;
	}

	if($file['size'] > 2*1024*1024) {
	// Размер файла больше 2мб
	$ok=0;
	}
};

if ($ok == 0) {header('location: /?admin');die;}

$dst_img =  imagecreatetruecolor(200, 200);
imagecopyresized($dst_img,$src_img,0,0,0,0,200,200,$WxH[0],$WxH[0]);
$dst_dir_min = "res/tovar/mini_".rand(1,10000).$category.$cost.".png";
imagepng($dst_img, $dst_dir_min);

$dst_dir = "res/tovar/".rand(1,10000).$category.$cost.".png";
/* Переместить оригинал */
move_uploaded_file($file['tmp_name'], $dst_dir);
mysql_query("INSERT INTO `goods`(`name`, `description`, `mini-foto`, `foto`, `category`, `cost`) VALUES ('$name','$description','$dst_dir_min','$dst_dir','$category','$cost')") or $errName[]='такое имя занято';
}

?><form action="upload.php" method="POST" enctype="multipart/form-data">
		<div id="item">
			Название товара<br/>
			<?PHP foreach ($errName AS $err) {
				echo "<fb>$err</fb><br/>";
			}
			?>
			<input type="text" name="name" pattern="[A-Za-zА-Яа-я ]{6,64}" required placeholder="Введите название товара" value="<?PHP echo $_POST['name'];?>"/><br/>
			Стоимость<br/>
			<?PHP foreach ($errCost AS $err) {
				echo "<fb>$err</fb><br/>";
			}
			?>
			<input type="text" name="cost" pattern="[0-9]{1,10}" required placeholder="Введите стоимость товара в рублях" value="<?PHP echo $_POST['cost'];?>" />
		</div>
		<div id="item">
			Категория<br/>
			<?PHP echo $errCat."<br/>"; ?>
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
			<?PHP echo $errDesc."<br/>"; ?>
			<textarea name="descript" rows="3" required><?PHP echo $_POST['descript'];?></textarea><br/>
			<input type="submit" id="submit" name="submit" value="Добавить"/>
		</div>
	</form><?PHP
	
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

require_once 'footer.php';?>
