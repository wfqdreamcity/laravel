<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __success($data=array(),$msg='ok',$code='2000'){

        $result['code']=$code;
        $result['msg']=$msg;
        $result['data']=$data;

        echo json_encode($result);

        exit;

    }

    public function __fail($msg='fail',$code='4000'){

        $result['code']=$code;
        $result['msg']=$msg;
        $result['data']=array();

        echo json_encode($result);

        exit;

    }
}
