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

        $baseurl = 'http://www.qiushibaike.com/';
        $url = isset($request->url)?$request->url:$baseurl;

        $start =true;
        $num=0;
        $arr=array();
        while($start) {

            //获取网页内容
            //$contents = $this->getWebContent($baseurl);
            $contents = @file_get_contents($url);

            if (!empty($contents)) {

                //获取页面中合法url
                $result = $this->getUrlByRegex($contents);

                $url = $baseurl . $result['0'];

                $arr[] = $url;
            }else{
                $start=false;
            }

            $num ++;
            if($num>30){
                $start=false;
            }
        }

        echo json_encode($arr);


    }

    //获取内容中的url
    public function getUrlByRegex($content){

        preg_match('#[0-9a-z]+\/page\/[0-9]+\/\?s=[0-9]+#',$content,$result);

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

        curl_setopt($curl, CURLOPT_HTTPHEADER, array (
            "Content-Type: text/xml"
        ) );
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);

        return $data;

    }


}






?>