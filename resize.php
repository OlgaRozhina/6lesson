<?php 
function create_thumbnail($path, $save, $width, $height) {
	$info = getimagesize($path); //получаем размеры картинки и ее тип
	$size = array($info[0], $info[1]); //закидываем размеры в массив

        //В зависимости от расширения картинки вызываем соответствующую функцию
	if ($info['mime'] == 'image/png') {
		$src = imagecreatefrompng($path); //создаём новое изображение из файла
	} else if ($info['mime'] == 'image/jpeg') {
		$src = imagecreatefromjpeg($path);
	} else if ($info['mime'] == 'image/gif') {
 		$src = imagecreatefromgif($path);
	} else {
		return false;
	}

	$thumb = imagecreatetruecolor($width, $height); //возвращает идентификатор изображения, представляющий черное изображение заданного размера
	$src_aspect = $size[0] / $size[1]; //отношение ширины к высоте исходника
	$thumb_aspect = $width / $height; //отношение ширины к высоте аватарки

	if($src_aspect < $thumb_aspect) { 		//узкий вариант (фиксированная ширина) 		$scale = $width / $size[0]; 		$new_size = array($width, $width / $src_aspect); 		$src_pos = array(0, ($size[1] * $scale - $height) / $scale / 2); //Ищем расстояние по высоте от края картинки до начала картины после обрезки 	} else if ($src_aspect > $thumb_aspect) {
		//широкий вариант (фиксированная высота)
		$scale = $height / $size[1];
		$new_size = array($height * $src_aspect, $height);
		$src_pos = array(($size[0] * $scale - $width) / $scale / 2, 0); //Ищем расстояние по ширине от края картинки до начала картины после обрезки
	} else {
		//другое
		$new_size = array($width, $height);
		$src_pos = array(0,0);
	}

	$new_size[0] = max($new_size[0], 1);
	$new_size[1] = max($new_size[1], 1);

	imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);
	//Копирование и изменение размера изображения с ресемплированием

	if($save === false) {
		return imagepng($thumb); //Выводит JPEG/PNG/GIF изображение
	} else {
		return imagepng($thumb, $save);//Сохраняет JPEG/PNG/GIF изображение
	}

} ?>
<?php 

function upload($myfile){
            
        if(is_uploaded_file($myfile["tmp_name"])) // Проверяем загружен ли файл
             {
            // Если файл загружен успешно, перемещаем его из временной директории в конечную
             move_uploaded_file($myfile["tmp_name"], "img/".$myfile["name"]);
             echo 'Фаил успешно загружен'.'<br>';                 
                           }               
        else {
               echo("Ошибка загрузки файла");
                           }
}

function add_img($path, $save ){
    
    echo '<a href='.$path.'>'.'<img src='.$save.'>'.'</a>';//  выводим картинку на экран в виде ссылки
   
}


?>
 <!DOCTYPE html>
    <html>

    <head>
        <title>RESIZE</title>
        <meta charset="utf-8">
    </head>

    <body>
        <a href="img/pic1.png"> <img src="img/pic1.png" title="picture png" alt="picture png" width="50px" height="50px"></a>
        <br>
        <br>
        <a href="img/pic2.gif"> <img src="img/pic2.gif" title="picture gif" alt="picture gif" width="50px" height="50px"></a>
        <br>
        <br>


        <?php 
         
        
         
        if(isset($_FILES['myfile'])) {
            //  т.к. пока if($_FILES["myfile"]["size"] >1024*2*1024 ) данная проверка размера не работает воспользуемся $_FILES['myfile']['error']
            // делаем проверку размера файла
             $sizeError = $_FILES['myfile']['error'];
         
             if ($sizeError == 0){ //если ошибки нет то 
                            
         //Проверяем ТИП файла перед загрузкой на сервер            
           $type = $_FILES['myfile']['type'];
            echo "<br>";
            switch($type){
                case 'image/png':
                case 'image/gif':
                case 'image/jpeg':
               // если один из кейсов true , то загружаем фаил и выводи его в галерею в виде ссылки         
                         upload($_FILES['myfile']);
                          $fileName = $_FILES['myfile']['name'];//  имя файла   с расширением
                          $path = 'img/'.$fileName;//  путь к картинке, которую будем уменьшать
                          $width = 50; // ширина копии картинки
                          $height = 50;// высота копии картинки 
                          $save ="img/copy"."$fileName"; // путь, в котором будет лежать копия картинки
                          
                          create_thumbnail($path, $save, $width, $height);
                          add_img($path, $save );
                    break;
                default:
                    echo "Некорректный тип файла";
                    break;
            }
         } else { echo "Размер файла превышает 2 мегабайта";}

        }
        else {
         
            echo "Выберите файл для загрузки!";
            
        } 
          
        ?>
        
        
         <br><br>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="myfile" />
                <input type="submit" value="Загрузить фаил!">
            </form>


    </body>

    </html>