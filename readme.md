MemCacheWrapper
=======
Singleton styled wrapper for MemCached with ability to use closures


#Requires - php>5.3, memcache instanse, php_memcached extension to be installed!


## Features
1) Singleton assembly of class - single object from all scopes of view
2) Simplest api
3) "It works from box" configuration

### Functions
There is only 5 functions

####MEMCACHE::setPrefix($prefix);
Set the prefix for keynames - usable, when we have few projects working on single MemCached instance.
When prefix is set, every key created is prepended by prefix.
For example
```php
 MEMCACHED::setPrefix('project1_'); //and now every key generated by MEMCACHED will start with project1_
 MEMCACHED::set('key1',100); //sets the key with name "project1_key1"
 MEMCACHED::get('key1'); //gets the key with name "project1_key1"
```


####MEMCACHE::set($string_hash_key,$callback,$expiration_time_in_seconds);
Set the key $string_hash_key with value $callback to be stored for $expiration_time_in_seconds.

 For example, store a scalar value
```php
MEMCACHE set('counter',100,60); //set the key counter with value of 100 with expiration time 60 seconds
```

Store a result of function execution (works only in PHP>5.3 !!!)
```php
MEMCACHE set('counter',function(){ return Realy_Slow_Function($arg1,$arg2);},60); //set the key counter with value returned by Realy_Slow_Function($arg1,$arg2) with expiration time 60 seconds
```

####MEMCACHE::get($string_hash_key);
Get the value from cache. If value doen't exists return false;

####MEMCACHE::delete($string_hash_key);
Delete value in cache.

####MEMCACHE::flush();
Invalidates all cache.



## About

Copyright &copy; 2003-2012 [Anatoly Ostroumov](http://teksi.ru/webdev)

## License

Licensed under the [ISC License](http://www.opensource.org/licenses/ISC).

Copyright (c) 2003-2012 Anatoly Ostroumov <info@fotobase.org>

Permission to use, copy, modify, and/or distribute this software for any purpose with or without fee is hereby granted, provided that the above copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.