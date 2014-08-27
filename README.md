php-rest
========

Yet another rest client library for PHP

##Api
```php
//constructor
new RestClient($baseURL="", $debugMode=false)

//methods
public function doGet($url, $params=array())
public function doPost($url, $params)
public function doPut($url, $params)
public function doDelete($url, $params=array())
```

##Examples

```php
<?php
  include '../lib/santoshsahoo/phprest/restclient.class.php';

  use santoshsahoo\phprest\RestClient;
  use santoshsahoo\phprest\RestException;
     
  $client = new RestClient('http://127.0.0.1:5000'); //json
  $data = $client->doPost('/sum', array('x'=>1, 'y'=>2));
  $result = $data['result'];
?>
```

### running unittest
`phpunit.phar restclienttest.php`

This test depends on Flask webapp included in the /test directory