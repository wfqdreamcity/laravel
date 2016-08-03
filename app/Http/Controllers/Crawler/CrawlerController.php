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
use Goutte\Client;
use App\Http\Controllers\Esearch;
use Mockery\Exception;
use Log;


class CrawlerController extends Controller{


    //爬虫 数据分析
    public function analyse(Request $request){

        $client = new Client();

        // Go to the symfony.com website
        $crawler = $client->request('GET','http://www.qiushibaike.com/');

        $status =true;
        $num = 0;
        while ($status){
            //分析数据
            $crawler->filter('div.article')->each(function ($node) {
                    try{
                        $data = array();
                        $str = $node->filter('h2')->text();
                        $data['user'] =$str;
//                        $link = $node->selectLink($str);
//                        $link->each(function ($link_node) {
//                            print $link_node->link()->geturi();
//                        });
                        $data['praiseNum'] = $node->filter('span.stats-vote > i')->text();
                        $data['commentNun'] = $node->filter('a > i.number')->text();
                        $data['content'] = $node->filter('div.content')->text();

                        $obj = new Esearch\EsController();
                        $obj->index($data);

                    }catch (\InvalidArgumentException $err){
                        Log::info('content empty !!!');
                        echo $err->getMessage();
                    }
            });

            $num++;

            //获取下一页链接
            $link = $crawler->selectLink('下一页');
           try{
                $link = $link->link();
               $crawler = $client->click($link);

           }catch (\InvalidArgumentException $err){
               Log::info('next page=>'.$num);
               sleep(10);
               $crawler = $client->request('GET','http://www.qiushibaike.com/');
           }

            if($num>15){
                $status=false;
            }
        }



    }


}






?>