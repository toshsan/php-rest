<?php
 /**
     * Copyright 2012 Santosh Sahoo (me@santoshsahoo.com)
     *
     * Licensed under the Apache License, Version 2.0 (the "License"); you may
     * not use this file except in compliance with the License. You may obtain
     * a copy of the License at
     *
     *     http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software
     * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
     * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
     * License for the specific language governing permissions and limitations
     * under the License.
     */
     
namespace santoshsahoo\phprest;
/**
 *
 * @package phprest
 * @author Santosh Sahoo
 **/
  class RestClient {
      const CONT_JSON = "application/json";
      const USER_AGENT = "phpcurl/RestClient-0.1";

      const GET = "GET";
      const POST = "POST";
      const PUT = "PUT";
      const DELETE = "DELETE";

      private $debugMode;
      private $baseURL;

      public function __construct($baseURL="", $debugMode=false){
        $this->debugMode = $debugMode;
        $this->baseURL = $baseURL;
      }

      private function debugLog($str){
        if ($this->debugMode){
            print_r("\n");
            print_r($str);
        }
      }

      private function debugDump($obj){
        if ($this->debugMode){
            print_r("\n");
            var_dump($obj);
        }
      }

      public function doRequest($method, $path, $params=array()){
        $url = implode(array($this->baseURL, $path));
        $this->debugLog($url);
        $this->debugDump($params);

        if ($method == self::GET && $params != null){
            $params_array = array();
            foreach ($params as $key => $value) {
                $params_array[] = $key ."=". $value;
            }
            $params_string = "?" . implode("&",$params_array);
            unset($params_array);
            $url = $url.$params_string;
            $this->debugLog("params string".$params_string);
        }

        $this->debugLog("fetching url : ".$url);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($method == self::POST){
            $this->debugLog("Method: POST");
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
        }

        if ($method == self::PUT){
            $this->debugLog("Method: PUT");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, self::PUT);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        if ($method == self::DELETE){
            $this->debugLog("Method: DELETE");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, self::DELETE);
        }

        $result = curl_exec($ch);

        if ($result == false){
            throw new RestException('Failed to: '. $method. $url, 400);
        }

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->debugLog("http code is: ".$http_status);

        if ($http_status != 200) {
            switch ($http_status) {
                case 404:
                    throw new RestException("Not found", $http_status);
                break;
                case 401:
                    throw new RestException("Unauthorized", $http_status);
                break;
                case 503:
                    throw new RestException("Service not available", $http_status);
                break;
                default:
                    throw new RestException("Http Error: ".$http_status, $http_status);
                break;
            }
        }

        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);
        
        $this->debugLog("content type is: " . $contentType);
        
        if(stripos($contentType, self::CONT_JSON) !== FALSE){        
            $this->debugLog("Decoding json");
            $result_obj = json_decode($result, true);
        } else {
            $result_obj = utf8_decode($result);
        }

        return $result_obj;
      }

      public function doGet($url, $params=array()){
          return $this->doRequest(self::GET, $url, $params);
      }

      public function doPost($url, $params){
          return $this->doRequest(self::POST, $url, $params);
      }

      public function doPut($url, $params){
          return $this->doRequest(self::PUT, $url, $params);
      }

      public function doDelete($url, $params=array()){
          return $this->doRequest(self::DELETE, $url, $params);
      }
  }

  class RestException extends \Exception{}
?>