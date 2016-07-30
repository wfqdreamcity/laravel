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
    public function index(){

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

        $data['index']="test";
        $data['type'] = 'laravel';
        $data['body'] ='
        {
            "query":{
                "match_all":{}
            }
        }';

        $list = $this->Client->search($data);

        echo json_encode($list);
    }


}










?>