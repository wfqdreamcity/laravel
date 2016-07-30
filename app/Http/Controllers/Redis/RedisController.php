<?php
namespace App\Http\Controllers\Redis;

use App\Http\Controllers\Controller;
use Redis;



class RedisController extends Controller{

    public function set(){

        $result =Redis::set('fooo','this is a test centent!');

        $this->__success($result);
    }

    public function get(){

        $result = Redis::get('fooo');

        $this->__success($result);

    }


    public function hset(){

        $result = Redis::hset();
    }

}










?>