<?php

namespace Chuva\Php\WebScrapping;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Color;



class ExcelGenerator {

  function generate($data) : void {
    $data = $data;
    $objectPapers = $data[0];
    $arrayPersons = $data[1];
      
    $filePath = 'resultadoWebscrappring.xlsx';
    $writer = WriterEntityFactory::createXLSXWriter();
    $writer->openToFile($filePath);
  

    function createStyle(){
      $style = (new StyleBuilder())
    ->setFontBold()
    ->setFontSize(15)
    ->setBackgroundColor(Color::LIGHT_GREEN)
    ->build();
    return $style;
    }
    function headerSpreadsheet(){
      $authorsAndInstitutionArray = [];
    
      for ($i = 1; $i <= 19; $i++) {
      $authorName = "Author $i";
      $authorInstituition = "Author $i Instituition";
      
      $authorsAndInstitutionArray[] = $authorName;
      $authorsAndInstitutionArray[] = $authorInstituition;
      }
      
      $headerSpreadsheet = ["ID", "Title", "Type"];
    
      return $rowHeaderSpreadsheet = array_merge($headerSpreadsheet, $authorsAndInstitutionArray);
    }
    
    
    
    
    function createRowPostsInfos($arrayPersons, $writer, $objectPapers){
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
    
    $criaHeader = WriterEntityFactory::createRowFromArray(headerSpreadsheet(), createStyle()) ; 
    $writer->addRow($criaHeader);
    
    $arrayAuthorsAndInstituition = createRowPostsInfos($arrayPersons, $writer, $objectPapers);
    $writer->close(); 
    echo 'Vamos Chover!';
  }
}

