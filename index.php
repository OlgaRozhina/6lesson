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

function add_img($wayToFile){
    echo '<a href='.$wayToFile.'>'.'<img src='.$wayToFile.' width="100px" height="100px">'.'</a>';//  выводим картинку на экран в виде ссылки
   
}


?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Gallery</title>
        <meta charset="utf-8">
    </head>

    <body>
        <a href="img/pic1.png"> <img src="img/pic1.png" title="picture png" alt="picture png" width="100px" height="100px"></a>
        <br>
        <br>
        <a href="img/pic2.gif"> <img src="img/pic2.gif" title="picture gif" alt="picture gif" width="100px" height="100px"></a>
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
                    $wayToFile = 'img/'.$_FILES['myfile']['name'];// вводиv переменную в которой содержится путь к файлу
                    add_img($wayToFile);
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
<p> этот параграф чтобы понимать как работает $_FILES
        <?php
        
//            // этот кусок кода мне нужен чтобы понимать что откуда берется
//              if(isset($_FILES['myfile'])) {
//            echo $_FILES['myfile']['name']."<br>";// выводит имя файла
//            echo $_FILES['myfile']['type']."<br>";// выводит тип файла
//            echo $_FILES['myfile']['size']."<br>";// выводит размер файла
//            echo $_FILES['myfile']['tmp_name']."<br>";// выводит путь к временной директории
//            echo $_FILES['myfile']['error']."<br>";// выводит код ошибки. если ошибки нет то 0 
////            
            
//         ПОЧЕМУ НЕ ВЫПОЛНЯЕТСЯ ДАННЫЙ КУСОК КОДА ??????????
//                    if($_FILES["myfile"]["size"] >1024*2*1024 )//upload_max_filesize,  по умолчанию равно 2 Мбайт:
//                    {
//                        echo "Размер файла превышает 2 мегабайта";
////                        exit;
//                    }

        ?>
           </p>


    </body>

    </html>