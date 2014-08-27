php-rest
========

A rest client to make consuming rest services easier in PHP. This library will automatically decode json response to php array where response content type is `application/json`. JSON serialization is used in most modern rest services. So you can focus on your application code without worrying about decoding your self.

This library depends on *php5 curl* library. You can install it using `sudo apt-get install php5-curl` or `yum install php5-curl`

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
     
  $client = new RestClient('https://api.example.com/v1');
  
  $apiversion = $client->doGet('/version'); //text
  
  $data = $client->doPost('/sum', array('x'=>1, 'y'=>2)); //json
  $result1 = $data['result'];
    
  $data = $client->doPut('/multiply', array('x'=>5, 'y'=>3));
  $result2 = $data['result'];
?>
```

Or as

```php
<?php
  include '../lib/santoshsahoo/phprest/restclient.class.php';

  use santoshsahoo\phprest\RestClient;
     
  $client = new RestClient();
  $user = array('email'=>'jdoe@gmail.com', 'name'=>'John Doe', 'age'=>25);
  $data = $client->doPut('http://api.example.com/v2/user', $user); //json
  $uid = $data['uid'];
?>
```

### running unittest
`phpunit.phar restclienttest.php`

This test depends on Flask webapp included in the /test directory
