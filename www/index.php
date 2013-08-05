<html>
    <head>
        <script type='text/javascript' src='jquery.js'></script>   
        <script src="jquery.form.js"></script> 

        <script> 
            $(document).ready(function()
            {
                var options = { 
                    beforeSend: function() 
                    {
                        $("#progress").show();
                        //clear everything
                        $("#bar").width('0%');
                        $("#message").html("");
                        $("#percent").html("0%");
                    },
                    uploadProgress: function(event, position, total, percentComplete) 
                    {
                        $("#bar").width(percentComplete+'%');
                        $("#percent").html(percentComplete+'%');
                    },
                    success: function() 
                    {
                        $("#bar").width('100%');
                        $("#percent").html('100%');

                    },
                    complete: function(response) 
                    {
                        $("#cat").html(response.responseText);
                    },
                    error: function()
                    {
                        $("#cat").html("<font color='red'> ERROR: unable to upload files</font>");

                    }
     
                }; 

                $("#upload").ajaxForm(options);

            });




        </script> 

    </head> 
    <body>   

        <form enctype="multipart/form-data"  action="upload.php" method="post" id="upload"> 
            <input type="hidden" name="MAX_FILE_SIZE" value="500000">
            Загрузить файл: <input name="yml" type="file"> 
            <input type="submit" value="Отправить" > 
        </form>

        <div id="progress">
            <div id="bar"></div>
            <div id="percent">0%</div >
        </div>
        <p></p>

        <form id="global_search" action="#" method="post">
            <label>Цена товара больше </label><input type="text" name="minprice" value="<?php echo $_POST[minprice]; ?>"><p></p>
            <label>Цена товара меньше </label><input type="text"  name="maxprice" value="<?php echo $_POST[maxprice]; ?>"><p></p>
            <label>Категория </label>
            <p>

                <select size="1" style="width:200px;"  name="cat[]" id="cat">
                    <option></option>
                    <?php
                    $filename = "category.txt";
                    if (file_exists($filename)) {
                        $f = fopen($filename, 'r');
                        echo fpassthru($f);
                    }
                    ?>
                </select> 
            </p>

            <p>
                <label><input type="checkbox" name="available" value="1" <?php echo ($_POST[available]) ? "checked" : " "; ?>> Есть в наличии</label>
            </p>
            <p>
                <label><input type="checkbox" name="task" value="1" <?php echo ($_POST[task]) ? "checked" : " "; ?>> Создать задания</label>
            </p>
            <input type="submit" value="Найти">
        </form>


        <table>
            <th>Id товара</th>
            <th>Название товара</th>
            <th>Цена товара</th>
            <th>Наличие</th>
            <?php
            //$uploadfile = fopen('http://www.apishops.com/websiteAction?action=getPrice&id=4590', 'r') or die($php_errormsg);
            //$data=file_get_contents('http://www.apishops.com/websiteAction?action=getPrice&id=4590');
            //var_dump($data);

            require 'upload_price.php';
            require 'PrintPrice.php';



            $minprice = $_POST[minprice];
            $maxprice = $_POST[maxprice];
            $select_cat = $_POST[cat];
            $available = $_POST[available];
            $task = $_POST[task];

            $price = new UploadPrice();
            $smpl_xml = $price->get_xml();
            $printPrice = new PrintPrice($minprice, $maxprice, $select_cat, $available, $smpl_xml);
           
            //$array=array('name'=>'http://yandex.ru');
           // $printPrice->createTask($array, 20,300);


           // if (!empty($task)) {
           //     $printPrice->createTasks();
           // }
            echo $printPrice->getTable();
            ?>
        </table>
    </body>
</html>

