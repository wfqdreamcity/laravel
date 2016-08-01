<?php
/*
 * crawler model
 *
 * @author Fangqi wU
 *
 * @create 2016-08-01
 *
 * @last update 2016-08-1
 *
 */
namespace App\Http\Controllers\Crawler;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;


class CrawlerController extends Controller{


    //爬虫 数据分析
    public function analyse(Request $request){



    }


    //爬虫 url抓取
    public function getUrl(Request $request){

        $url = 'http://www.qiushibaike.com/';
        $baseurl = isset($request->url)?$request->url:$url;

        $start =true;
        //while($start){

            //获取网页内容
            $contents = $this->getWebContent($baseurl);
            echo json_encode($contents);
            //获取页面中合法url
            $result = $this->getUrlByRegex($contents);

            echo json_encode($result);
        //}


    }

    //获取内容中的url
    public function getUrlByRegex($content){

        preg_match_all('/http:\/\/[0-9a-z\.\/\-]+\/[0-9a-z\.\/\-]+\.([0-9a-z\.\/\-]+)/',$content,$result);
        foreach ($result['0'] as $key =>$url){
            $extend =$result['1'][$key];
        }

        return $result;

    }

    //获取网页内容
    public function getWebContent($url){

        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        $post_data = array(
            "username" => "coder",
            "password" => "12345"
        );
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);

        return $data;

    }


}






?>