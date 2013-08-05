<?php

//проверяем загрузку файла на наличие ошибок



    if ($_FILES['yml']['error'] > 0) {
        //в зависимости от номера ошибки выводим соответствующее сообщение
        //UPLOAD_MAX_FILE_SIZE - значение установленное в php.ini
        //MAX_FILE_SIZE значение указанное в html-форме загрузки файла
        switch ($_FILES['yml']['error']) {
            case 1: $response = 'Размер файла превышает допустимое значение UPLOAD_MAX_FILE_SIZE';
                break;
            case 2: $response = 'Размер файла превышает допустимое значение MAX_FILE_SIZE';
                break;
            case 3: $response = 'Не удалось загрузить часть файла';
                break;
            case 4: $response = 'Файл не был загружен';
                break;
            case 6: $response = 'Отсутствует временная папка.';
                break;
            case 7: $response = 'Не удалось записать файл на диск.';
                break;
            case 8: $response = 'PHP-расширение остановило загрузку файла.';
                break;
        }
        exit;
    }

//проверяем MIME-тип файла
    if ($_FILES['yml']['type'] != 'application/octet-stream') {
        $response = 'Вы пытаетесь загрузить не текстовый файл.';
        exit;
    }

//проверяем не является ли загружаемый файл php скриптом,
//при необходимости можете дописать нужные типы файлов
    $blacklist = array(".php", ".phtml", ".php3", ".php4");
    foreach ($blacklist as $item) {
        if (preg_match("/$item\$/i", $_FILES['yml']['name'])) {
            $response = "Нельзя загружать скрипты.";
            exit;
        }
    }

//папка для загрузки
    $uploaddir = 'uploads/';
//новое сгенерированное имя файла
    $newFileName = date('YmdHis') . rand(10, 100) . '.yml';
//путь к файлу (папка.файл)
    $uploadfile = $uploaddir . $newFileName;

//загружаем файл move_uploaded_file
    if (!move_uploaded_file($_FILES['yml']['tmp_name'], $uploadfile))
        $response = "Ошибка загрузки файла.\n";




/* Начинаем обработку yml прайса  */
$smpl_xml = simplexml_load_file($uploadfile);

$filecategory = fopen("category.txt", "w");

foreach ($smpl_xml->shop->categories->category as $category) {
    if ($category == 'Детские автокресла') {
        $response.="<option value='" . $category['id'] . "' selected >" . $category . "</option>";
    } else {

        $response.="<option value='" . $category['id'] . "'>" . $category . "</option>";
    }
}
//в родительском документе ищем элемент с айдишником image и вписываем в него результат действий нашего скрипта
fwrite($filecategory, $response);
fclose($$filecategory);
echo $response;
?>