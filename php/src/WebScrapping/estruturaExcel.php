<?php

namespace Chuva\Php\WebScrapping\estruturaExcel;
require'../../vendor/autoload.php';

use Chuva\Php\WebScrapping\Main;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Color;


$style = (new StyleBuilder())
->setFontBold()
->setFontSize(15)
->setBackgroundColor(Color::LIGHT_GREEN)
->build();

function headerSpreadsheet(){
  $authorsAndInstitutionArray = [];

  for ($i = 1; $i <= 19; $i++) {
  $authorName = "Author $i";
  $authorInstitution = "Author $i Institution";
  
  $authorsAndInstitutionArray[] = $authorName;
  $authorsAndInstitutionArray[] = $authorInstitution;
  }
  
  $headerSpreadsheet = ["ID", "Title", "Type"];

  return $rowHeaderSpreadsheet = array_merge($headerSpreadsheet, $authorsAndInstitutionArray );
}

function arrayOrdenadoAutorEInstituicao($arrayPersons){
  $arrayPersonName = $arrayPersons;
  $arrayPersonInstituition =  $arrayPersons;
  $arrayAuthorsAndInstitution = [];

  for ($i = 0; $i < count($arrayPersonName); $i++) {
      $authorName = $arrayPersonName[$i]->names;
      $authorInstitution =  $arrayPersonInstituition[$i]->institutions;
      
      $authorsAndInstitutionArray[] = $authorName;
      $authorsAndInstitutionArray[] = $authorInstitution;
  }
  return $arrayAuthorsAndInstitution;
};

$main = new Main();
$arrays = $main->run();
$objectPapers = $arrays[0];
$arrayPersons = $arrays[1];
$arrayAuthorsAndInstitution = arrayOrdenadoAutorEInstituicao($arrayPersons);
$arrayPaper = [];

for($i = 0; $i < count($objectPapers); $i++){
  $arrayPapers[] = get_object_vars($objectPapers[$i]);
};


print_r($arrayPapers);



/* function rowData($arrayPaper, $arrayPerson){
  $filePath = 'dados.xlsx';
  $writer = WriterEntityFactory::createXLSXWriter();
  $writer->openToFile($filePath);
  $criaHeader = WriterEntityFactory::createRowFromArray(headerSpreadsheet()) ; 
  
  
  $writer->addRow($criaHeader);
  foreach($arrayObject as $array){
    $datas = WriterEntityFactory::createRowFromArray($array) ;
    $writer->addRow($datas);
  }
  $writer->close();

}
 */
