<?php
namespace App\Http\Controllers\Esearch;

use App\Http\Controllers\Controller;
use ClassPreloader\Config;
use Elasticsearch;


class EsController extends Controller{

    protected $Client;

    public function __construct(){
        $es  = Elasticsearch\ClientBuilder::create(Config('database.es.host'));
        $this->Client = $es->build();


    }
    //创建index
    public function index_test(){

        $data['index'] ="test";
        $data['type']="laravel";

        $arr =array(
            'title' =>'test for elasticsearch !!!!',
            'desc' => 'for search ,you know !!!',
            'detial' =>'Monitor Elasticsearch
            Marvel helps you keep a pulse on the state of your 
            Elasticsearch deployment. As a window into your cluster, 
            Marvel is a tool for optimizing your Elasticsearch performance 
            and diagnosing issues quickly.'
        );

        $data['body']  =$arr;

        $result =  $this->Client->index($data);

        echo json_encode($result);

    }

    //seach
    public function search(){

        $data['index']="crawler";
        $data['type'] = 'index';
        $data['body'] ='
        {
            "size":100,
            "query":{
                "match_all":{}
            }
        }';

        $list = $this->Client->search($data);

        echo json_encode($list);
    }

    public function index(array $para,$type='crawler'){

        $data['index'] ="crawler";
        $data['type']=$type;
        $data['id']=MD5(json_encode($para));

        //如果已经存在不在添加
        $reuslt = $this->Client->exists($data);
        if($reuslt){
            return false;
        }

        $data['body']  =$para;

        $result =  $this->Client->index($data);

        return true;

    }


}










?>