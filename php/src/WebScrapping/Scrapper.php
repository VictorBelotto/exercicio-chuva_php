<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {

  /**
   * Loads paper information from the HTML and returns the array with the data.
   */
  public function scrap($dom): array {
    $xpath = new \DOMXPath($dom);
    $cardPosts = $xpath->query("//a[@class='paper-card p-lg bd-gradient-left']");
    $arrayPapers = [];

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

      $authors = new Person($postAuthorsArray, $postInstituitionsArray);
      $papers = new Paper($postId, $postTitle, $postType, $authors);
      $arrayPapers[] = $papers;
    }
    return $arrayPapers;
  }
  
}
