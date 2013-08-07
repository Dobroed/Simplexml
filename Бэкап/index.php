<!DOCTYPE HTML>
<!-- saved from url=(0023)http://www.denso.com/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="ru"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="ru"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="ru"> <![endif]-->
<!--[if gt IE 8]> <html itemscope itemtype="http://schema.org/WebPage" xmlns:og="http://ogp.me/ns#" style="padding:0px; margin:0px;" class="no-js" lang="ru"> <!--<![endif]-->
<html lang="ru">
    <head>
        <!--[if lt IE 9]>
         <script src="js/html5.js"></script>
       <![endif]-->
        <script type='text/javascript' src='js/jquery.js'></script>   
        <script src="js/jquery.form.js"  type='text/javascript'></script> 
        <script src="js/modernizr-2.5.3.min.js"  type='text/javascript'></script>
        <script src="js/home.js"  type='text/javascript'></script>

        <!--  <link rel="stylesheet" href="css/normalize.css"> -->
        <meta charset="utf-8">

        <!--[if IE]>
                <meta http-equiv="X-UA-Compatible" content="IE=edge" >
        <![endif]-->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">





    </head> 
    <body>  
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span1"></div>
                <div class="span11">

                    <!--<form enctype="multipart/form-data"  action="upload.php" method="post" id="upload"> 
                        <input type="hidden" name="MAX_FILE_SIZE" value="500000">
                        Загрузить файл: <input name="yml" type="file"> 
                        <input type="submit" value="Отправить" > 
                    </form>
    
                    <div id="progress">
                        <div id="bar"></div>
                        <div id="percent">0%</div >
                    </div>-->
                    <p></p>

                    <form id="global_search" action="#" method="post" class="form-horizontal">
                        <div class="control-group">

                            <label  class="control-label" for="minprice">Цена товара больше </label>
                            <div class="controls">
                                <input type="text" name="minprice" id="minprice" value="<?php echo $_POST[minprice]; ?>" >
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="maxprice">Цена товара меньше </label>
                            <div class="controls">
                                <input type="text"  name="maxprice"  id="maxprice" value="<?php echo $_POST[maxprice]; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="cat">Категория </label>
                            <div class="controls">
                                <select size="1"  name="cat[]" id="cat">
                                    <option></option>
                                    <?php
                                    $filename = "category.txt";
                                    if (file_exists($filename)) {
                                        $f = fopen($filename, 'r');
                                        echo fpassthru($f);
                                    }
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="available">Наличие</label>
                            <div class="controls">
                                <select size="1"  name="available[]" id="available">
                                    <option selected>Любое</option>    
                                    <option>Есть в наличии</option>
                                    <option>Нет в наличии</option>

                                </select> 
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls"> 
                                <label  class="checkbox" ><input type="checkbox" name="task" value="1" <?php echo ($_POST[task]) ? "checked" : " "; ?>> Создать задания</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label  class="control-label" for="offset">Разбить задания по </label>
                            <div class="controls">
                                <input type="text" name="offset"  id="offset" value="<?php echo $_POST[offset]; ?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls"> <input type="submit" class="btn" value="Найти"></div>
                        </div>
                        <input type="hidden" name="sent_form" value="1">
                    </form>


                    <table class="table table-striped table-hover">
                        <th>Id товара</th>
                        <th>Название товара</th>
                        <th>Цена товара</th>
                        <th>Наличие</th>
                        <?php
                        require 'upload_price.php';
                        require 'PrintPrice.php';
                        $minprice = $_POST[minprice];
                        $maxprice = $_POST[maxprice];
                        $select_cat = $_POST[cat];
                        $available = $_POST[available];
                        $task = $_POST[task];
                        $sent_form = $_POST[sent_form];
                        $offset = $_POST[offset];
                        $price = new UploadPrice();
                        $smpl_xml = $price->get_xml();
                        $printPrice = new PrintPrice($minprice, $maxprice, $select_cat, $available, $smpl_xml);



                        if (!is_null($sent_form) && empty($task)) {
                            $printPrice->getTable();
                        } elseif (!is_null($sent_form) && !empty($task)) {
                            $printPrice->getTable($task = 'true', $offset);
                        }
                        ?>
                    </table>

                </div>

            </div>
        </div>
    </body>
</html>

