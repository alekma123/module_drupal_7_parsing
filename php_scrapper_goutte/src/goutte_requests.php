

<?php
# scraping books to scrape:https://yandex.ru/maps/org/

function getReviewsYandexMap($URL) {
  require (dirname(__FILE__) . '/../vendor/autoload.php');

  $arrayNode = [];
  $arrayIndex = 0;
  $pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";


  $httpClient = new \Goutte\Client();
  $response = $httpClient->request('GET', $URL);

 $response->filter('div.business-review-view__info')->each(function($node) use (&$arrayNode, &$arrayIndex, &$pattern) {
        
    $node->filter('a.business-review-view__user-icon div.user-icon-view__icon')->each(function($node1) use (&$arrayNode, &$arrayIndex, &$pattern){
      
      $style = $node1->attr('style');
      preg_match($pattern, $style, $matches);
      
      if (isset($matches[0])) {
        $arrayNode[$arrayIndex]['imgSrc'] = $matches[0];
      } else {
        $arrayNode[$arrayIndex]['imgSrc'] = null;
      }

    });

    $node->filter('div.business-review-view__author a')->each(function($node1) use (&$arrayNode, &$arrayIndex) {

      $arrayNode[$arrayIndex]['title'] = $node1->text();
      $arrayNode[$arrayIndex]['link'] = $node1->attr('href');
    
    }); 

    $node->filter('div.business-review-view__header')->each(function($node1) use (&$arrayNode, &$arrayIndex) {

      $node1->filter('span.business-review-view__date')->each(function($node2) use (&$arrayNode, &$arrayIndex) {
        $arrayNode[$arrayIndex]['date'] = $node2->text();
      });

      $rating = $node1->filter('div.business-review-view__rating span.business-rating-badge-view__star._empty');

      $arrayNode[$arrayIndex]['rating'] = 5 - count($rating);

    });

    $node->filter('div.business-review-view__body')->each(function($node1) use (&$arrayNode, &$arrayIndex) {
      $arrayNode[$arrayIndex]['text'] = $node1->text();
    });
 
 
 $arrayIndex++;

});

$arr = [];
$arr [] = $arrayNode[0];
$arr [] = $arrayNode[1];

return $arr;

}

// $output = var_dump(getReviewsYandexMap("https://yandex.ru/maps/org/forvard_avto_lada_ofitsialny_diler/1112596902/reviews/?from=tabbar&ll=73.420619%2C61.265078&source=serp_navig&z=8"));
// echo $output;


?>

