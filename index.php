<?php
include_once 'simple_html_dom.php';

$url = 'https://dantri.com.vn/giao-duc/vu-lo-de-thi-sinh-8-thi-sinh-duoc-mom-de-can-xu-ly-the-nao-20230620004656478.htm';

$html = file_get_html( $url );

$data = [];
foreach($html->find('.article-related .article-item') as $item) {
    $title = $item-> find('.article-title a' , 0)->innertext;
    $link = $item-> find('.article-title a' , 0)->href;
    $image = $item-> find('.article-thumb a img' , 0)->src;
    $description = $item-> find('.article-excerpt a' , 0)->innertext;
    $link_arr = explode('-',$link);
    $id = end($link_arr);
    $id = str_replace('.htm','', $id);
    $data[$id] = ['title'=> $title,'link'=> $link,'image'=> $image,'description'=> $description];
}
foreach($html->find('.article-lot .article-item') as $item) {
    $title = $item-> find('.article-title a' , 0)->innertext;
    $link = $item-> find('.article-title a' , 0)->href;
    $image = $item-> find('.article-thumb a img' , 0)->src;
    $link_arr = explode('-',$link);
    $id = end($link_arr);
    $id = str_replace('.htm','', $id);
    $data[$id] = ['title'=> $title,'link'=> $link,'image'=> $image];
}

$url = 'https://recommendation-api.dantri.com.vn/recommend/get-recommended-articles?userId=a6a6c469-4b76-40c6-b066-b65285a21f1d&articleId=20230620004656478&number=10&byUser=false&keepAuthor=false';
$result = file_get_contents($url);
$items = json_decode($result, true);
foreach($items as $item) {
    $data[$id] = [
        'title'=> $item['title'],
        'link'=> $item['localPath'],
        'image'=> $item['imagePath'],
        'description'=> $item['sapo'],
    ];
}


echo '<pre>';
    print_r($data);
echo '</pre>';