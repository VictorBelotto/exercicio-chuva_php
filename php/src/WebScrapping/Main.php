<?php

namespace Chuva\Php\WebScrapping;
namespace Chuva\Php\WebScrapping\Entity;
use DOMDocument;
use DOMXPath;
require './php/vendor/autoload.php';
libxml_use_internal_errors(true);

class Main {
  public static function run() {

      $html = file_get_contents(__DIR__ . '/../../assets/origin.html');

      $dom = new DOMDocument();
      $dom->loadHTML($html);
      $xpath = new DOMXPath($dom);
      
      $cardPosts = $xpath->query("//a[@class='paper-card p-lg bd-gradient-left']");
    
      $postQuantity = count($cardPosts);
    
      $arrayClass = [];
      foreach ($cardPosts as $cardpost) {
        $postId = $xpath->query(".//div[@class='volume-info']", $cardpost)->item(0);
        $postTitle = $xpath->query(".//h4", $cardpost)->item(0);
        $postType = $xpath->query(".//div[@class='tags mr-sm']", $cardpost)->item(0);
        $postAuthors = $xpath->query(".//span", $cardpost);
        $authorsInstituitions = $xpath->query(".//div[@class='authors']/span/@title", $cardpost);
        
        $post = new Paper($postId,$postTitle,$postType,$postAuthors);
        $arrayClass[] = $post;
      };    
      return $arrayClass;
  }  
};
    
function buscaPostId() {
  $arrayId = func_get_args();
  $posts = Main::run();
  print_r( $arrayId);
  
  foreach ($posts as $post) {
    foreach ($arrayId as $idPost) {
      if ($post->id->textContent === $idPost) {
        print_r($post);
      }
    }
  }
}
/*     $data = (new Scrapper())->scrap($dom);

    // Write your logic to save the output file bellow.
    print_r($data);
  
 */


print_r(buscaPostId('137459', '137460'));