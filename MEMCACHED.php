<?php
class MEMCACHE
    {
        protected static $instance;
        private $m;
        private $dev=false;
        private $prefix='';

        public static function init()
            {
                if ( is_null(self::$instance) )
                    {
                        self::$instance = new MEMCACHE();
                    }
                return self::$instance;
            }

    /**
     * Set the development or production mode.
     * In development mode every cache output generates html code with data about cache storage
     * @static
     * @param boolean $true_or_false, default false;
     * @return bool
     *
     * @example
     * MEMCACHED::setDev(true);
     * MEMCACHED::setDev(false);
     */
        public static function setDev($true_or_false)
            {
                $c=MEMCACHE::init();
                $c->dev=$true_or_false ? true : false ;
                return true;
            }

        private function __construct()
            {
                $m = new Memcached();
                if($m->addServer('localhost', 11211))
                    {

                        $this->m=$m;
                    }
                else
                    trigger_error(__FILE__.'>>'.__METHOD__.' error connecting to memcached!');

            }


    /**
     * Sets the prefix for using memcache - usually we need prefixes, when we have few
     * servers working with the single memcached instance.
     * @static
     * @param $prefix
     * @return bool
     *
     * @example
     * MEMCACHED::setPrefix('project1_'); //and now every key generated by MEMCACHED will start with project1_
     * MEMCACHED::set('key1',100); //sets the key with name "project1_key1"
     * MEMCACHED::get('key1'); //gets the key with name "project1_key1"
     *
     */
        public static function setPrefix($prefix)
            {
                $c=MEMCACHE::init();
                $c->prefix=$prefix;
                return true;
            }

    /**
     * If key doesn't exists, sets the key into cache
     * If key exists, returns this key value
     * @static
     * @param string $string_hash_key- name of a cache keuy
     * @param $callback - anonimous function or scalar value to store in cache
     * @param int $duration
     * @return string
     * @example
     *
     * MEMCACHE set('counter',100,60); //set the key counter with value of 100 with expiration time 60 seconds
     * MEMCACHE set('counter',function(){ return Realy_Slow_Function($arg1,$arg2);},60); //set the key counter
     * //with value returned by Realy_Slow_Function($arg1,$arg2) with expiration time 60 seconds
     *
     */
        public static function set($string_hash_key,$closure,$duration=60)
            {
                if($duration<0)
                    {
                        trigger_error(__FILE__.'>>'.__METHOD__.' error setting duration!');
                    }

                $c=MEMCACHE::init();
                $a=$c->m->get($c->prefix.$string_hash_key);
                if($a)
                    {
                        if($c->dev) $a='<div style="border-style:solid;border-width:1px;border-color: #009900;" title="from cache with key *'.$string_hash_key.'* ">'.$a.'</div>';
                        return $a;
                    }
                else
                    {

                        if(is_scalar($closure))
                            $a=$closure;
                        else
                            $a=$closure();

                        $c->m->set($c->prefix.$string_hash_key,$a,$duration);
                        if($c->dev) $a='<div style="border-style:solid;border-width:1px;border-color: #f0bb0e;" title="created and stored in cache with key *'.$string_hash_key.'* ">'.$a.'</div>';
                        return $a;
                    }
            }

    /**
     * @static
     * @param $string_hash_key
     * @return bool|string
     */
        public static function get($string_hash_key)
            {
                $c=MEMCACHE::init();
                $a=$c->m->get($c->prefix.$string_hash_key);
                if($a)
                    {
                        if($c->dev) $a='<div style="border-style:solid;border-width:1px;border-color: #009900;" title="from cache with key *'.$string_hash_key.'* ">'.$a.'</div>';
                        return $a;
                    }
                else
                    {
                        return false;
                    }

            }

    /**
     * @static
     * @param $string_hash_key
     * @return mixed
     */
        public static function delete($string_hash_key)
            {
                $c=MEMCACHE::init();
                return $c->m->delete($c->prefix.$string_hash_key);
            }

    /**
     * @static
     * @return mixed
     */
        public static function flush()
            {
                $c=MEMCACHE::init();
                return $c->m->flush();
            }

    }