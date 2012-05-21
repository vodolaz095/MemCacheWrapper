<?php
require_once 'MEMCACHED.php';

//MEMCACHE::setDev(true);
MEMCACHE::setPrefix('dev');
echo MEMCACHE::set('key1','test 1',2).PHP_EOL;
echo MEMCACHE::set('key2',function(){return date('r');},10).PHP_EOL;

MEMCACHE::setPrefix('dev_test');
MEMCACHE::set('key1','prefix test',2).PHP_EOL;
echo MEMCACHE::get('key1').PHP_EOL;

MEMCACHE::setPrefix('dev');
echo MEMCACHE::get('key1');



MEMCACHE::flush();
