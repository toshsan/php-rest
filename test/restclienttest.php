<?php
include '../lib/santoshsahoo/phprest/restclient.class.php';

use santoshsahoo\phprest\RestClient;
use santoshsahoo\phprest\RestException;

class RestClientTest extends PHPUnit_Framework_TestCase{
    private static function _anystr($minlen=0, $maxlen=10){
      $len = rand($minlen, $maxlen);
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $randstring = '';
      for ($i = 0; $i < $len; $i++) {
        $randstring .= $characters[rand(0, strlen($characters)-1)];
      }
      return $randstring;
    }
      
    public function testDoGet(){
      $client = new RestClient('http://127.0.0.1:5000', TRUE);
      $root = $client->doGet('/');
      $this->assertEquals($root, "Hello World!");
    }
          
    public function testDoPost(){
      $client = new RestClient('', TRUE);
      $data = $client->doPost('http://127.0.0.1:5000', array('name'=>'Santosh Sahoo'));
      $this->assertEquals($data, "Hello " . 'Santosh Sahoo');
    }
    
    public function testDoGetJson(){
      $x=rand(1, 100);
      $y=rand(-200, 100);
      
      $client = new RestClient('http://127.0.0.1:5000', TRUE);
      $data = $client->doGet('/sum', array('x'=>$x, 'y'=>$y));
      $this->assertEquals($data['result'], $x+$y);
    }
          
    public function testDoPostJson(){
      $x=rand(1, 100);
      $y=rand(-200, 100);
      
      $client = new RestClient('http://127.0.0.1:5000', TRUE);
      $data = $client->doPost('/sum', array('x'=>$x, 'y'=>$y));
      $this->assertEquals($data['result'], $x+$y);
    }
    
     public function testDoPutJson(){
      $x=rand(1, 100);
      $y=rand(-200, 100);
      
      $client = new RestClient('http://127.0.0.1:5000', TRUE);
      $data = $client->doPut('/sum', array('x'=>$x, 'y'=>$y));
      $this->assertEquals($data['result'], $x+$y);
    }
    
    public function testDoDeleteJson(){
      $x=rand(1, 100);
      $y=rand(-200, 100);
      
      $client = new RestClient('http://127.0.0.1:5000', TRUE);
      $data = $client->doPost('/sum', array('x'=>$x, 'y'=>$y));
      $this->assertEquals($data['result'], $x+$y);
    }
    
    public function testDoHandleError(){
      $x=self::_anystr(1);
      $client = new RestClient('http://127.0.0.1:5000', TRUE);
      $code = 0;
      try{
        $data = $client->doGet("/$x");
      }
      catch(RestException $ex){  
        $code = $ex->getCode();
      }
      
      $this->assertEquals($code, 404);
    }
    
}
?>