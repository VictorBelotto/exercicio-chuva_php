<?php

namespace Chuva\Php\WebScrapping;
require './php/vendor/autoload.php';


use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {


/*   public function scrap(\DOMDocument $dom): array {
    
  } */

}






$filePath = 'dados.xlsx';

$writer = WriterEntityFactory::createXLSXWriter();
$writer->openToFile($filePath);


$authorsAndInstitutionArray = [];

for ($i = 1; $i <= 19; $i++) {
    $authorName = "Author $i";
    $authorInstitution = "Author $i Institution";
    
    $authorsAndInstitutionArray[] = $authorName;
    $authorsAndInstitutionArray[] = $authorInstitution;
}

$TitleSpreadsheet = ["ID", "Title", "Type"];

$rowTitleSpreadsheet = array_merge($TitleSpreadsheet, $authorsAndInstitutionArray );

 $criaRow = WriterEntityFactory::createRowFromArray($rowTitleSpreadsheet, $style) ; 

$writer->addRow($criaRow);

$writer->close();

echo 'Ok';