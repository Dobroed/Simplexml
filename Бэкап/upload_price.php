<?php

//папка для загрузки

class UploadPrice {

    public $smpl_xml;
    private $uploaddir;
    private $FileName;
    private $url = 'http://www.apishops.com/websiteAction?action=getPrice&id=4590';
    public $str_price;
    

    public function __construct($uploaddir='', $FileName='shop.yml') {
        $this->uploaddir = $uploaddir;
        $this->FileName = $FileName;
        $this->check_price();
    }

    private function check_price() {

//новое сгенерированное имя файла
        $FileName = $this->uploaddir . $this->FileName;


        if (!file_exists($FileName)) {
          $this->get_http_price();
        } else {
            $today = getdate();
            $date_day = date("d", filemtime($FileName));
            if ($today[mday] != (int)$date_day) {
                $this->get_http_price();
            } else
                $this->get_local_price();
        }
    }

    private function get_local_price() {
     
        $this->smpl_xml = simplexml_load_file($this->FileName);
    }

    private function get_http_price() {

//проверяем загрузку файла на наличие ошибок
        $sourceFileName =file_get_contents($this->url);
           
        file_put_contents($this->FileName, $sourceFileName);
        
        $this->smpl_xml = simplexml_load_file($this->FileName);


       
    }

    public function get_xml() {
        return $this->smpl_xml;
    }

 
}

?>