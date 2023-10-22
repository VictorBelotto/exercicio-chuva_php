<?php

namespace Chuva\Php\WebScrapping;
require'../../vendor/autoload.php';


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


function arrayOrdenadoAutorEInstituicao($arrayPersons, $writer, $objectPapers){
  $arrayPersonName = $arrayPersons;
  $arrayPersonInstituition =  $arrayPersons;
  


  for ($i = 0; $i < count($arrayPersons); $i++) {
    $authorName = $arrayPersonName[$i]->names;
    $authorInstituition =  $arrayPersonInstituition[$i]->instituitions;
    $arrayAuthorsAndInstituition = [];
    for($a = 0; $a < count($authorName); $a++){
    
    $arrayAuthorsAndInstituition[] = $authorName[$a];
    $arrayAuthorsAndInstituition[] = $authorInstituition[$a];

    
    };
    $linhaPaper = get_object_vars($objectPapers[$i]);
    $linhaAuthors = $arrayAuthorsAndInstituition;
    $merged =  array_merge($linhaPaper, $linhaAuthors );
    $linha =  WriterEntityFactory::createRowFromArray($merged) ;
    $writer->addRow($linha); 
    
   
  };
};

$Scrapper = new Scrapper();
$arrays = $Scrapper->getPosts();
$objectPapers = $arrays[0];
$arrayPersons = $arrays[1];



print_r($objectPapers[0]);
$arrayAuthorsAndInstituition = arrayOrdenadoAutorEInstituicao($arrayPersons, $writer, $objectPapers);

$writer->close();