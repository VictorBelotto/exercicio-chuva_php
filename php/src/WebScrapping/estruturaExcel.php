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

$filePath = 'dados.xlsx';
$writer = WriterEntityFactory::createXLSXWriter();
$writer->openToFile($filePath);



function headerSpreadsheet(){
  $authorsAndInstitutionArray = [];

  for ($i = 1; $i <= 19; $i++) {
  $authorName = "Author $i";
  $authorInstituition = "Author $i Instituition";
  
  $authorsAndInstitutionArray[] = $authorName;
  $authorsAndInstitutionArray[] = $authorInstituition;
  }
  
  $headerSpreadsheet = ["ID", "Title", "Type"];

  return $rowHeaderSpreadsheet = array_merge($headerSpreadsheet, $authorsAndInstitutionArray );
}


$criaHeader = WriterEntityFactory::createRowFromArray(headerSpreadsheet()) ; 
$writer->addRow($criaHeader);


function arrayOrdenadoAutorEInstituicao($arrayPersons, $writer){
  $arrayPersonName = $arrayPersons;
  $arrayPersonInstituition =  $arrayPersons;
  $arrayAuthorsAndInstituition = [];


  for ($i = 0; $i < count($arrayPersonName[0]->names); $i++) {
    $authorName = $arrayPersonName[$i]->names;
    $authorInstituition =  $arrayPersonInstituition[$i]->instituitions;
    for($a = 0; $a < count($authorName); $a++){
    $arrayAuthorsAndInstituition[] = $authorName[$a];
    $arrayAuthorsAndInstituition[] = $authorInstituition[$a];

    
    };
    
  };
  return $arrayAuthorsAndInstituition;
  
};




$main = new Main();
$arrays = $main->run();
$objectPapers = $arrays[0];
$arrayPersons = $arrays[1];
$arrayAuthorsAndInstituition = arrayOrdenadoAutorEInstituicao($arrayPersons, $writer);
$arrayToSpreadsheet = array_merge();

$datas = WriterEntityFactory::createRowFromArray($arrayAuthorsAndInstituition[0]) ;
$writer->addRow($datas);  
$writer->close();



