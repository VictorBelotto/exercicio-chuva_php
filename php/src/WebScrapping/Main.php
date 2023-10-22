<?php
namespace Chuva\Php\WebScrapping;
namespace Chuva\Php\WebScrapping\Entity;
use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use DOMDocument;
use DOMXPath;
use excel;

require '../../vendor/autoload.php';

libxml_use_internal_errors(true);

class Main {
  public static function run() {

      $html = file_get_contents(__DIR__ . '/../../assets/origin.html');

      $dom = new DOMDocument();
      $dom->loadHTML($html);
      $xpath = new DOMXPath($dom);
      
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
    
        $postInstitutionsArray = [];
        foreach ($authorsInstituitions as $institution) {
            $postInstitutionsArray[] = $institution->textContent;
        }

        $papers = new Paper($postId,$postTitle,$postType);
        $persons = new Person($postAuthorsArray, $postInstitutionsArray);
        $arrayPapers[] = $papers;
        $arrayPersons[] = $persons;
        
      };    
      return [$arrayPapers, $arrayPersons];
  }  
};
    
function arrayOrdenadoAutorEInstituicao($authors, $institutions){
  $authorsAndInstitutionArray = [];

  for ($i = 0; $i < count($authors); $i++) {
      $authorName = $authors[$i];
      $authorInstitution =  $institutions[$i];
      
      $authorsAndInstitutionArray[] = $authorName;
      $authorsAndInstitutionArray[] = $authorInstitution;
  }
  return $authorsAndInstitutionArray;
};

$arrays = Main::run();
$arrayPapers = $arrays[0];
$arrayPersons = $arrays[1];

$arrayPersonName = $arrayPersons[0]->names;
$arrayPersonInstituition =  $arrayPersons[0]->institutions;

$authorsAndInstitutionArray = arrayOrdenadoAutorEInstituicao($arrayPersonName,$arrayPersonInstituition);
print_r($arrayPapers[0]);
print_r($authorsAndInstitutionArray);


