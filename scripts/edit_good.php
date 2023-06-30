<?php

session_start();
require 'project/config/connection.php';

$message = '';
$newFileName = 'no_photo.jpg';

if(isset($_POST['edit_good'])) {
    if (($_POST['edit_good_name']) != '' && ($_POST['edit_good_description']) != '' && ($_POST['edit_good_price']) != '') {
        $alias = transLit($_POST['edit_good_name']);
        if(checkGood($_POST['edit_good_id'],$_POST['old_good_name'],$_POST['edit_good_name'])===true){
            if(addGoodCheckCathegory($_POST['edit_good_select_cathegory'])===true){
                    if (isset($_FILES['edit_good_photo']) && $_FILES['edit_good_photo']['error'] === UPLOAD_ERR_OK) //Если во время загрузки файла была ошибка, эта переменная заполняется соответствующим
                        // сообщением об ошибке. В случае успешной загрузки файла она содержит значение 0, которое можно сравнить с помощью константы UPLOAD_ERR_OK
                    {
                        // get details of the uploaded file
                        $fileTmpPath = $_FILES['edit_good_photo']['tmp_name']; //Временный путь, в который загружается файл, сохраняется в этой переменной
                        $fileName = $_FILES['edit_good_photo']['name']; //Фактическое имя файла сохраняется в этой переменной
                        $fileSize = $_FILES['edit_good_photo']['size']; //Указывает размер загруженного файла в байтах
                        $fileType = $_FILES['edit_good_photo']['type']; //Содержит mime тип загруженного файла
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps)); //В приведенном выше коде мы также выяснили расширение загруженного файла и сохранили его в переменной $fileExtension

                        // sanitize file-name
                        $newFileName = md5(time() . $fileName) . '.' . $fileExtension; //Поскольку загруженный файл может содержать пробелы и другие специальные символы,
                        // лучше очистить имя файла, и это именно то, что мы сделали в следующем шаге с помощью функции хеширования, используя в качестве соли time()

                        // check if file has one of the following extensions
                        $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png'); //Создаем массив допустимых разрешений загружаемого файла

                        if (in_array($fileExtension, $allowedfileExtensions)) //если разрешение загружаемого файла соответствует
                        {
                            // directory in which the uploaded file will be moved
                            $uploadFileDir = 'img/goods/photos/'; //папка, куда загружается файл
                            $dest_path = $uploadFileDir . $newFileName; //путь загрузки вместе с новым именем загружаемого файла


                            if (move_uploaded_file($fileTmpPath, $dest_path)) //Функция move_uploaded_file принимает два аргумента. Первым аргументом является имя файла загруженного файла,
                                //(временный путь) а второй аргумент - путь назначения, в который вы хотите переместить файл
                            {
                                $message = '<p>Новая фотография успешно загружена';
                                getIcon($dest_path, $newFileName);
                                unlink($dest_path);
                                $query = "SELECT picture FROM catalog WHERE id='$_POST[edit_good_id]'";
                                $object_picture = mysqli_query($link,$query) or die(mysqli_error($link));
                                $picture = mysqli_fetch_assoc($object_picture);
                                if($picture['picture']!='no_photo.jpg'&&$picture['picture']!=''){
                                    unlink('img/goods/'.$picture['picture']);
                                }
                                $query = "UPDATE catalog SET good_name='$_POST[edit_good_name]', description='$_POST[edit_good_description]', price='$_POST[edit_good_price]',
                                    cathegory='$_POST[edit_good_select_cathegory]', material='$_POST[edit_good_material]', color='$_POST[edit_good_color]', good_name_translit='$alias', picture='$newFileName' WHERE id='$_POST[edit_good_id]'";
                                mysqli_query($link,$query) or die(mysqli_error($link));
                                if($message == ''){
                                    $message .= "<p>Изменена карточка товара <b>".$_POST['edit_good_name']."</b>";
                                }
                                else $message .= ", изменена карточка товара <b>".$_POST['edit_good_name']."</b>";

                            } else {
                                $message = '<p>Произошла какая-то ошибка при перемещении фотографии в каталог загрузки. Пожалуйста, убедитесь, что каталог загрузки доступен для записи веб-сервером';
                                $query = "UPDATE catalog SET good_name='$_POST[edit_good_name]', description='$_POST[edit_good_description]', price='$_POST[edit_good_price]',
                                    cathegory='$_POST[edit_good_select_cathegory]', material='$_POST[edit_good_material]', color='$_POST[edit_good_color]', good_name_translit='$alias' WHERE id='$_POST[edit_good_id]'";
                                mysqli_query($link,$query) or die(mysqli_error($link));
                                if($message == ''){
                                    $message .= "<p>Изменена карточка товара <b>".$_POST['edit_good_name']."</b>";
                                }
                                else $message .= ", изменена карточка товара <b>".$_POST['edit_good_name']."</b>";
                            }
                        } else {
                            $message = '<p>Не удалось загрузить фотографию. Разрешенные типы файлов: ' . implode(',', $allowedfileExtensions);
                            $query = "UPDATE catalog SET good_name='$_POST[edit_good_name]', description='$_POST[edit_good_description]', price='$_POST[edit_good_price]',
                                    cathegory='$_POST[edit_good_select_cathegory]', material='$_POST[edit_good_material]', color='$_POST[edit_good_color]', good_name_translit='$alias' WHERE id='$_POST[edit_good_id]'";
                            mysqli_query($link,$query) or die(mysqli_error($link));
                            if($message == ''){
                                $message .= "<p>Изменена карточка товара <b>".$_POST['edit_good_name']."</b>";
                            }
                            else $message .= ", изменена карточка товара <b>".$_POST['edit_good_name']."</b>";
                        }
                    }
                    else {
                        if($_FILES['edit_good_photo']['error']!==4) {
                            $message = '<p>При загрузке фотографии произошла ошибка. Пожалуйста, исправьте следующую ошибку.<br>';
                            $message .= 'Ошибка:' . $_FILES['edit_good_photo']['error'];
                        }
                        $query = "UPDATE catalog SET good_name='$_POST[edit_good_name]', description='$_POST[edit_good_description]', price='$_POST[edit_good_price]',
                                    cathegory='$_POST[edit_good_select_cathegory]', material='$_POST[edit_good_material]', color='$_POST[edit_good_color]', good_name_translit='$alias' WHERE id='$_POST[edit_good_id]'";
                        mysqli_query($link,$query) or die(mysqli_error($link));
                        if($message == ''){
                            $message .= "<p>Изменена карточка товара <b>".$_POST['edit_good_name']."</b>";
                        }
                        else $message .= ", изменена карточка товара <b>".$_POST['edit_good_name']."</b>";
                    }
            }
            else $message .= "<p>Товар <b>".$_POST['edit_good_name']."</b> не может быть изменен. Категория, в которую Вы добавляете товар, была удалена";
        }
        else $message .= "<p>Товар <b>".$_POST['edit_good_name']."</b> не может быть изменен. Либо товар с таким именем уже существует, либо пока Вы редактировали товар, он был удален другим пользователем";
    }
    else {$message .= "<p>Поля, отмеченные звездочками, обязательны для заполнения";}
    $message .= "</p>";
    $_SESSION['edit'] = $message;
    $path = '/admin/edit-good';
    header("Location: $path");
}

function getIcon($dest_path, $newFileName)
{
    $info = getimagesize($dest_path);
    $width = $info[0];
    $height = $info[1];
    $type = $info[2];

    switch ($type) {
        case 1:
            $img = imageCreateFromGif($dest_path);
            imageSaveAlpha($img, true);
            break;
        case 2:
            $img = imagecreatefromjpeg($dest_path);
            $exif = exif_read_data($dest_path);
            if ($img && $exif && isset($exif['Orientation'])) {//Исправляем перевернутое фото, если фотографировали на телефон
                $ort = $exif['Orientation'];

                if ($ort == 6 || $ort == 5) {
                    $img = imagerotate($img, 270, 0);
                    $width = $info[1];
                    $height = $info[0];
                }
                if ($ort == 3 || $ort == 4) {
                    $img = imagerotate($img, 180, 0);
                }
                if ($ort == 8 || $ort == 7) {
                    $img = imagerotate($img, 90, 0);
                    $width = $info[1];
                    $height = $info[0];
                }

                if ($ort == 5 || $ort == 4 || $ort == 7) {
                    imageflip($img, IMG_FLIP_HORIZONTAL);
                }
            }
            break;
        case 3:
            $img = imageCreateFromPng($dest_path);
            imageSaveAlpha($img, true);
            break;
    }

    // Размеры новой фотки.
    if ($height > $width) {
        $w = 800;
        $h = 0;
    } else {
        $w = 0;
        $h = 800;
    }

    if (empty($w)) {
        $w = ceil($h / ($height / $width));
    }
    if (empty($h)) {
        $h = ceil($w / ($width / $height));
    }

    $tmp = imageCreateTrueColor($w, $h);
    if ($type == 1 || $type == 3) {
        imagealphablending($tmp, true);
        imageSaveAlpha($tmp, true);
        $transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
        imagefill($tmp, 0, 0, $transparent);
        imagecolortransparent($tmp, $transparent);
    }

    $tw = ceil($h / ($height / $width));
    $th = ceil($w / ($width / $height));
    if ($tw < $w) {
        imageCopyResampled($tmp, $img, ceil(($w - $tw) / 2), 0, 0, 0, $tw, $h, $width, $height);
    } else {
        imageCopyResampled($tmp, $img, 0, ceil(($h - $th) / 2), 0, 0, $w, $th, $width, $height);
    }

    $img = $tmp;

    $src_temp = 'img/goods/temp/';

    switch ($type) {
        case 1:
            imageGif($img, $src_temp . $newFileName);
            break;
        case 2:
            imageJpeg($img, $src_temp . $newFileName, 100);
            break;
        case 3:
            imagePng($img, $src_temp . $newFileName);
            break;
    }

    imagedestroy($img);

    $info = getimagesize($src_temp . $newFileName);
    $width = $info[0];
    $height = $info[1];
    $type = $info[2];

    switch ($type) {
        case 1:
            $img = imageCreateFromGif($src_temp . $newFileName);
            imageSaveAlpha($img, true);
            break;
        case 2:
            $img = imagecreatefromjpeg($src_temp . $newFileName);
            break;
        case 3:
            $img = imageCreateFromPng($src_temp . $newFileName);
            imageSaveAlpha($img, true);
            break;
    }

    $w = 800;
    $h = 800;
    $x = '50%';
    $y = '50%';

    if (strpos($x, '%') !== false) {
        $x = intval($x);
        $x = ceil(($width * $x / 100) - ($w / 100 * $x));
    }
    if (strpos($y, '%') !== false) {
        $y = intval($y);
        $y = ceil(($height * $y / 100) - ($h / 100 * $y));
    }

    $tmp = imageCreateTrueColor($w, $h);
    if ($type == 1 || $type == 3) {
        imagealphablending($tmp, true);
        imageSaveAlpha($tmp, true);
        $transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
        imagefill($tmp, 0, 0, $transparent);
        imagecolortransparent($tmp, $transparent);
    }

    imageCopyResampled($tmp, $img, 0, 0, $x, $y, $width, $height, $width, $height);
    $img = $tmp;

    $src_output = 'img/goods/';

    switch ($type) {
        case 1:
            imageGif($img, $src_output . $newFileName);
            break;
        case 2:
            imageJpeg($img, $src_output . $newFileName, 100);
            break;
        case 3:
            imagePng($img, $src_output . $newFileName);
            break;
    }

    imagedestroy($img);
    unlink($src_temp . $newFileName);
}

function transLit($str)
{
    return strtolower(strtr($str,[
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'yo',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'y',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'ts',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'sch',
        'ъ' => '',
        'ы' => 'y',
        'ь' => '',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',
        'А' => 'a',
        'Б' => 'b',
        'В' => 'v',
        'Г' => 'g',
        'Д' => 'd',
        'Е' => 'e',
        'Ё' => 'yo',
        'Ж' => 'zh',
        'З' => 'z',
        'И' => 'i',
        'Й' => 'y',
        'К' => 'k',
        'Л' => 'l',
        'М' => 'm',
        'Н' => 'n',
        'О' => 'o',
        'П' => 'p',
        'Р' => 'r',
        'С' => 's',
        'Т' => 't',
        'У' => 'u',
        'Ф' => 'f',
        'Х' => 'h',
        'Ц' => 'ts',
        'Ч' => 'ch',
        'Ш' => 'sh',
        'Щ' => 'sch',
        'Ъ' => '',
        'Ы' => 'y',
        'Ь' => '',
        'Э' => 'e',
        'Ю' => 'yu',
        'Я' => 'ya',
        ' ' => '-',
        ',' => '',
        '.' => '',
        ':' => '',
        '!' => '',
        '&' => '',
        '?' => '',
        '\\\\' => '',
        '/' => '',
        '"' => '',
        "'" => '',
        '|' => '',
        '<' => '',
        '>' => '',
        '(' => '',
        ')' => '',
        '#' => '',
        '~' => '',
        '`' => '',
        "@" => '',
        '№' => '',
        '$' => '',
        '%' => '',
        '^' => '',
        '*' => '',
        '+' => '',
        '=' => '',
    ]));

}

function checkGood($good_id,$good_name,$new_good_name){
    require 'project/config/connection.php';
    $query = "SELECT id FROM catalog WHERE id='$good_id'";
    $object_good_id = mysqli_query($link,$query) or die(mysqli_error($link));
    $good_id = mysqli_fetch_assoc($object_good_id);
    if(!empty($good_id)){
        if($good_name != $new_good_name){
            $result = true;
            $query = "SELECT * FROM catalog WHERE good_name='$new_good_name'";
            $good = mysqli_query($link,$query) or die(mysqli_error($link));
            $data = mysqli_fetch_assoc($good);
            if(!empty($data)){
                $result = false;
            }
            $good_name_translit = transLit($new_good_name);
            $query = "SELECT * FROM catalog WHERE good_name_translit='$good_name_translit'";
            $good_alias = mysqli_query($link,$query) or die(mysqli_error($link));
            $data2 = mysqli_fetch_assoc($good_alias);
            if(!empty($data2)){
                $result = false;
            }
        }
        else $result = true;
    }
    else $result = false;
    return $result;
}

function addGoodCheckCathegory($cathegory){
    require "project/config/connection.php";
    $query = "SELECT id FROM cathegories WHERE id='$cathegory'";
    $result = mysqli_query($link,$query) or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($result);
    if(!empty($data)){
        return true;
    }
    else return false;
}