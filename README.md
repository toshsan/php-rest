php-rest
========

A rest client for PHP to make consuming rest api easier. This library will automatically decode response to json where response content type is `application/json`. JSON is used by most modern rest services for serialization. So you can focus on your application code without worrying for decoding.

This library depends on php5_curl library. You can install it using `sudo apt-get install php5-curl` or `yum install php5-curl`

The constructor takes an optional base url, this makes consuming api from a single source much easier.

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
     
  $client = new RestClient('http://api.example.com/v1');
  $data = $client->doPost('/sum', array('x'=>1, 'y'=>2)); //json
  $result = $data['result'];
?>
```

Or as

```php
<?php
  include '../lib/santoshsahoo/phprest/restclient.class.php';

  use santoshsahoo\phprest\RestClient;
     
  $client = new RestClient();
  $data = $client->doPut('http://api.example.com/v2/update-user', array('x'=>1, 'y'=>2)); //json
  $result = $data['result'];
?>
```

### running unittest
`phpunit.phar restclienttest.php`

This test depends on Flask webapp included in the /test directory
