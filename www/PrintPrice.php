<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class PrintPrice {

    private $minprice;
    private $maxprice;
    private $select_cat;
    private $available;
    private $xml;
    private $directory = "tasks/";


    public function __construct($minprice, $maxprice, $select_cat, $available, $xml) {

        $this->xml = $xml;
        $this->minprice = $minprice;
        $this->maxprice = $maxprice;
        $this->select_cat = $select_cat;
        $this->available = $available;
    }

    public function createTask($task, $size,$offset) {



        $start = 1;
        while ($start <= $size) {
            if ($start+$offset > $size) {
                $end = $start+($size - $start);
            } else {
                $end = $start + $offset;
            }
            $dir = $this->directory . $start . "-" . $end . "/";

            if (!is_dir($dir)) {
                mkdir($dir, 0, true);
            }

            for ($i = $start; $i <= $end && $i >= $start-1; $i++) {
              // var_dump("i=".$i,"start=".$start,"end=".$end);
                $f = fopen($dir . $start . "-" . $end . ".txt", "a+");
                $result = PHP_EOL . "$i) " . $task[$i-1][name] . PHP_EOL . "URL: " . $task[$i-1][url] . PHP_EOL . PHP_EOL;
                fwrite($f, $result);
                fclose($f);
            }
            $start+=1+$offset;
        }
    }

    public function getTable($task='false',$offset=20) {


        if (!empty($this->minprice) && !empty($this->maxprice)) {
            if ($this->available[0] == "Есть в наличии") {
                $i = 0;
                $tasks = array();

                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->price >= $this->minprice && $offer->price <= $this->maxprice && $offer->categoryId == $this->select_cat[0] && $offer['available'] == 'true') {

                        echo "<tr class='success' id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'><a href='".$offer->url."'>" . $offer->name . "</a></a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;

                        $i++;
                    }
                }
                echo "Всего товаров=" . $i;
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                }
            } elseif ($this->available[0] == "Нет в наличии") {
                $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->price > $this->minprice && $offer->price < $this->maxprice && $offer->categoryId == $this->select_cat[0] && $offer['available'] == 'false') {
                        echo "<tr class='error' id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'>" . $offer->name . "</a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";

                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                echo "Всего товаров=" . $i;
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                }
            } else {
                $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->price > $this->minprice && $offer->price < $this->maxprice && $offer->categoryId == $this->select_cat[0]) {
                        $class=($offer['available']=='true')?"success":"error";
                        echo "<tr class='".$class."' id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'><a href='".$offer->url."'>" . $offer->name . "</a></a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";

                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                echo "Всего товаров=" . $i;
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
            }
                
        }        
        } elseif (!empty($this->minprice)) {

            if ($this->available[0] == "Есть в наличии") {
                $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->price > $this->minprice && $offer->categoryId == $this->select_cat[0] && $offer['available'] == 'true') {
                        echo "<tr  class='success' id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'>" . $offer->name . "</a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                echo "Всего товаров=" . $i;
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                }
            } elseif ($this->available[0] == "Нет в наличии") {
                $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->price > $this->minprice && $offer->categoryId == $this->select_cat[0] && $offer['available'] == 'false') {
                        echo "<tr class='error' id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'>" . $offer->name . "</a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                }
                echo "Всего товаров=" . $i;
            } else {
                $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->price > $this->minprice && $offer->categoryId == $this->select_cat[0]) {
                        $class=($offer['available']=='true')?"success":"error";
                        echo "<tr class='".$class."' id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'>" . $offer->name . "</a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                }
                echo "Всего товаров=" . $i;
            }
        } elseif (!empty($this->maxprice)) {
            if ($this->available[0] ==  "Есть в наличии") {
                $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->price < $this->maxprice && $offer->categoryId == $this->select_cat[0] && $offer['available'] == 'true') {
                        echo "<tr  class='success' id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'>" . $offer->name . "</a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                }
                echo "Всего товаров=" . $i;
            } elseif ($this->available[0] == "Нет в наличии") {
                $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->price < $this->maxprice && $offer->categoryId == $this->select_cat[0] && $offer['available'] == 'false') {
                        echo "<tr class='error'  id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'>" . $offer->name . "</a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                }
                echo "Всего товаров=" . $i;
            } else {
                $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->price < $this->maxprice && $offer->categoryId == $this->select_cat[0]) {
                        $class=($offer['available']=='true')?"success":"error";
                        echo "<tr class='".$class."'  id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'>" . $offer->name . "</a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                }
                echo "Всего товаров=" . $i;
            }
        } else {
            if ($this->available[0] == "Есть в наличии") {
                $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->categoryId == $this->select_cat[0] && $offer['available'] == 'true') {
                        echo "<tr class='success'  id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'>" . $offer->name . "</a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                }
                echo "Всего товаров=" . $i;
            } elseif ($this->available[0] == "Нет в наличии") {
                $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->categoryId == $this->select_cat[0] && $offer['available'] == 'false') {
                        echo "<tr class='error'  id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'>" . $offer->name . "</a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                } 
                echo "Всего товаров=" . $i;
            }  else {
            
                 $i = 0;
                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->categoryId == $this->select_cat[0] ) {
                        $class=($offer['available']=='true')?"success":"error";
                        echo "<tr class='".$class."'  id='" . $i . "'><td>" . $offer['id'] . "</td><td><a href='".$offer->url."'>" . $offer->name . "</a></td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
                        $tasks[$i]['name'] = (string) $offer->name;
                        $tasks[$i]['url'] = (string) $offer->url;
                        $i++;
                    }
                }
                if ($task == 'true') {
                    $this->createTask($tasks, count($tasks),$offset);
                } 
                echo "Всего товаров=" . $i;
            
            }
        }
    }

}

?>
