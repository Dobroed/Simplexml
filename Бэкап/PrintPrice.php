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



        $start = 0;
        while ($start <= $size) {
            if ($start > $size) {
                $end = $size - $start;
            } else {
                $end = $start + $offset;
            }
            $dir = $this->directory . $start . "-" . $end . "/";

            if (!is_dir($dir)) {
                mkdir($dir, 0, true);
            }

            for ($i = $start; $i <= $end && $i >= $start; $i++) {
                $f = fopen($dir . $start . "-" . $end . ".txt", "a+");
                $result = PHP_EOL . "$i) " . $task[$i][name] . PHP_EOL . "URL: " . $task[$i][url] . PHP_EOL . PHP_EOL;
                fwrite($f, $result);
                fclose($f);
            }
            $start+=$offset;
        }
    }

    public function getTable($task='false',$offset=20) {


        if (!empty($this->minprice) && !empty($this->maxprice)) {
            if ($this->available[0] == "Есть в наличии") {
                $i = 0;
                $tasks = array();

                foreach ($this->xml->shop->offers->offer as $offer) {

                    if ($offer->price >= $this->minprice && $offer->price <= $this->maxprice && $offer->categoryId == $this->select_cat[0] && $offer['available'] == 'true') {

                        echo "<tr class='success' id='" . $i . "'><td>" . $offer['id'] . "</td><td>" . $offer->name . "</td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
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

                    if ($offer->price > $this->minprice && $offer->price < $this->maxprice && $offer->categoryId == $this->select_cat[0] && $offer['available'] == 'false') {
                        echo "<tr class='error' id='" . $i . "'><td>" . $offer['id'] . "</td><td>" . $offer->name . "</td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";

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
                        echo "<tr  class='success' id='" . $i . "'><td>" . $offer['id'] . "</td><td>" . $offer->name . "</td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
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

                    if ($offer->price > $this->minprice && $offer->categoryId == $this->select_cat[0] && $offer['available'] == 'false') {
                        echo "<tr class='error' id='" . $i . "'><td>" . $offer['id'] . "</td><td>" . $offer->name . "</td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
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
                        echo "<tr  class='success' id='" . $i . "'><td>" . $offer['id'] . "</td><td>" . $offer->name . "</td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
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

                    if ($offer->price < $this->maxprice && $offer->categoryId == $this->select_cat[0] && $offer['available'] == 'false') {
                        echo "<tr class='error'  id='" . $i . "'><td>" . $offer['id'] . "</td><td>" . $offer->name . "</td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
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
                        echo "<tr class='success'  id='" . $i . "'><td>" . $offer['id'] . "</td><td>" . $offer->name . "</td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
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

                    if ($offer->categoryId == $this->select_cat[0] && $offer['available'] == 'false') {
                        echo "<tr class='error'  id='" . $i . "'><td>" . $offer['id'] . "</td><td>" . $offer->name . "</td><td>" . $offer->price . "</td><td>" . $offer['available'] . "</td></tr>";
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
