<?php

namespace Chuva\Php\WebScrapping;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Color;



class ExcelGenerator {

  function generate($data) : void {
    /*Data é um array que contém 2 dados: uma lista de objetos da classe Paper e um array já formatado em autor1 e instituicao 1, autor2... */
    $data = $data;
    $objectPapers = $data[0];
    $arrayPersons = $data[1];
      
    $filePath = __DIR__ . '/../../assets/resultadoWebscrappring.xlsx';
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
      /* Aqui é a construção do cabeçalho da planilha, ele pode ser alterado para a quantidade desejada de autores */
      $authorsAndInstitutionArray = [];
      $quantAuthor = 16;
      for ($i = 1; $i <= $quantAuthor; $i++) {
      $authorName = "Author $i";
      $authorInstituition = "Author $i Instituition";
      
      $authorsAndInstitutionArray[] = $authorName;
      $authorsAndInstitutionArray[] = $authorInstituition;
      }
      $headerSpreadsheet = ["ID", "Title", "Type"];
      return $rowHeaderSpreadsheet = array_merge($headerSpreadsheet, $authorsAndInstitutionArray);
    }
    
    
    
    
    function createRowPostsInfos($arrayPersons, $objectPapers, $writer ){
      /*Essa função alem de criar a linha da tabela por um array e ordenar o array de autores com a instituição em sequencia */
      $arrayPersonName = $arrayPersons;
      $arrayPersonInstituition =  $arrayPersons;
      
      /*O loop recebe o quantidade de posts atraves do array de persons */
      for ($i = 0; $i < count($arrayPersons); $i++) {
        $authorName = $arrayPersonName[$i]->names;
        $authorInstituition =  $arrayPersonInstituition[$i]->instituitions;
        $arrayAuthorsAndInstituition = [];

          /*Este loop recebe a quantidade de autores para realizar a ordem de autor e instituição */
          for($a = 0; $a < count($authorName); $a++){
          $arrayAuthorsAndInstituition[] = $authorName[$a];
          $arrayAuthorsAndInstituition[] = $authorInstituition[$a];
          };
         
        /*Para cada posição do loop, faremos a criação da linha da planilha formada com os dados em ordem */  
        $linhaPaper = get_object_vars($objectPapers[$i]);
        $linhaAuthors = $arrayAuthorsAndInstituition;
        $merged =  array_merge($linhaPaper, $linhaAuthors );
        $linha =  WriterEntityFactory::createRowFromArray($merged) ;
        $writer->addRow($linha); 
        
       
      };
    };
    
    $criaHeader = WriterEntityFactory::createRowFromArray(headerSpreadsheet(), createStyle()) ; 
    $writer->addRow($criaHeader);
    $arrayAuthorsAndInstituition = createRowPostsInfos($arrayPersons, $objectPapers, $writer);
    $writer->close(); 
    echo 'Vamos Chover!';
  }
}

