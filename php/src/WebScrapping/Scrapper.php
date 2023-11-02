<?php

namespace Chuva\Php\WebScrapping;
use DOMDocument;
use DOMXPath;
use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;
libxml_use_internal_errors(true);

class Scrapper {
/*Função principal onde é feito toda a raspagem dos dados da origem.html */
  
  public function scrap($dom): array {
   
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
    
  /*ambos os foreachs guardam o text content dentro de um array e assim separa entre os 62 posts (62 indices no array), sendo cada indice todos os autores e instituições de um post */
      
  $postAuthorsArray = [];
  foreach ($postAuthors as $author) {
    $postAuthorsArray[] = $author->textContent;
  }
  $postInstituitionsArray = [];
  foreach ($authorsInstituitions as $institution) {
    $postInstituitionsArray[] = $institution->textContent;
  }

  /*a estrutura da classe Person foi modificada para receber um array de autores e outro de instituiçoes, pois ja tinha criado um metodo que iria trabalhar com a ordem deles */
  $papers = new Paper($postId,$postTitle,$postType);
  $persons = new Person($postAuthorsArray, $postInstituitionsArray);
  $arrayPapers[] = $papers;
  $arrayPersons[] = $persons;
  };    
    /*aqui é onde retorna os dados para tratar dentro do excel generator */
  return [$arrayPapers, $arrayPersons];
}

}