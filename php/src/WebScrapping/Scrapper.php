<?php

namespace Chuva\Php\WebScrapping;
use DOMDocument;
use DOMXPath;
use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;


libxml_use_internal_errors(true);



/**
 * Does the scrapping of a webpage.
 */

 class Scrapper {

  public  function getPosts()  {
    $html = file_get_contents(__DIR__ . '/../../assets/origin.html');
    $dom = new \DOMDocument();
    $dom->loadHTML($html);
    $xpath = new \DOMXPath($dom);
    
    $cardPosts = $xpath->query("//a[@class='paper-card p-lg bd-gradient-left']");
    $arrayPapers = [];
    $arrayPersons = [];

    foreach ($cardPosts as $cardpost) {
      $postId = $xpath->query(".//div[@class='volume-info']", $cardpost)->item(0)->textContent;
      $postTitle = $xpath->query(".//h4", $cardpost)->item(0)->textContent;
      $postType = $xpath->query(".//div[@class='tags mr-sm']", $cardpost)->item(0)->textContent;
      $postAuthors = $xpath->query(".//span", $cardpost);
      $authorsInstituitions = $xpath->query(".//div[@class='authors']/span/@title", $cardpost);
      
      $postAuthorsArray = [];
      foreach ($postAuthors as $author) {
          $postAuthorsArray[] = $author->textContent;
      }
  
      $postInstituitionsArray = [];
      foreach ($authorsInstituitions as $institution) {
          $postInstituitionsArray[] = $institution->textContent;
      }

      $papers = new Paper($postId,$postTitle,$postType);
      $persons = new Person($postAuthorsArray, $postInstituitionsArray);
      $arrayPapers[] = $papers;
      $arrayPersons[] = $persons;
      
    };    
    return [$arrayPapers, $arrayPersons];
}   

  public function scrap($data) {
    $generator = new ExcelGenerator();
   return $generator->generate($data);
  }

 }