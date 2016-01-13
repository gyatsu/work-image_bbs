<?php

  define('DSN', 'mysql:host=localhost;dbname=image_post;charset=utf8');
//  define('USER', 'testuser1@localhost');
//  @localhostは入力するとエラーになる
  define('USER', 'testuser1');
  define('PASSWORD', 'test');

  error_reporting(E_ALL & ~E_NOTICE);