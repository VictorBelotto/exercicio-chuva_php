<?php
namespace excel;
require '../../vendor/autoload.php';



use  Chuva\Php\WebScrapping\Entity\Main;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Color;
use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

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

function rowData($arrayObject){
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








