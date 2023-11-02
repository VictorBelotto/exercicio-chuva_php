<?php

namespace Chuva\Php\WebScrapping;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Color;


class ExcelGenerator {

    /*Cria a estilização do cabeçalho */
    static function createStyleHeader(){
      $style = (new StyleBuilder())
      ->setFontBold()
      ->setFontSize(15)
      ->setBackgroundColor(Color::LIGHT_GREEN)
      ->build();
      return $style;
    }
  
    static function headerSpreadsheet(){
      /* Cria a construção do cabeçalho da planilha.O looping é para poupar a escrita repetitiva de autor e instituição, ainda define a quantidade */
      $authorsAndInstitutionArray = [];
      $quantAuthor = 16;
      for ($i = 1; $i <= $quantAuthor; $i++) {
      $authorName = "Author $i";
      $authorInstituition = "Author $i Instituition";
      
      $authorsAndInstitutionArray[] = $authorName;
      $authorsAndInstitutionArray[] = $authorInstituition;
      }
      $headerSpreadsheet = ["ID", "Title", "Type"];
      /*Retorna a linha do cabeçalho formatada */
      return $rowHeaderSpreadsheet = array_merge($headerSpreadsheet, $authorsAndInstitutionArray);
    }
  
 

  function generate($data) : void {
    /*Data é um array que contém 2 dados: Um array de objetos da classe Paper e um array que armazena Person */
    $data = $data;
   
    $filePath = __DIR__ . '/../../assets/resultadoWebscrappring.xlsx';
    $writer = WriterEntityFactory::createXLSXWriter();
    $writer->openToFile($filePath);
  
    $objectPapers = $data[0];
    $arrayPersons = $data[1];
    /*Essa função alem de criar as linhas da tabela por um array, também ordena o array de em sequecia de autor1 e instituição1 e assim por diante*/
    function createRowPostsInfos($arrayPersons, $objectPapers, $writer ){
      $arrayPersonName = $arrayPersons;
      $arrayPersonInstituition =  $arrayPersons;
      
      /*O loop recebe a quantidade de posts relativos do array de persons, pois cada indice de persons foi criado a partir de um post  */
      for ($i = 0; $i < count($arrayPersons); $i++) {
        $authorName = $arrayPersonName[$i]->names;
        $authorInstituition =  $arrayPersonInstituition[$i]->instituitions;
        $arrayAuthorsAndInstituition = [];

          /*Este loop recebe a quantidade de autores relativos a posição acima para realizar a ordem de autor 1 e instituição 1.... */
          for($a = 0; $a < count($authorName); $a++){
          $arrayAuthorsAndInstituition[] = $authorName[$a];
          $arrayAuthorsAndInstituition[] = $authorInstituition[$a];
          };
         
        /*Para cada posição do loop "arrayPersons", faremos a criação da linha da planilha formatada com os dados em ordem */  
        $linhaPaper = get_object_vars($objectPapers[$i]);
        $linhaAuthors = $arrayAuthorsAndInstituition;
        $merged =  array_merge($linhaPaper, $linhaAuthors );
        $linha =  WriterEntityFactory::createRowFromArray($merged) ;
        $writer->addRow($linha); 
      };
    };
    
    $criaHeader = WriterEntityFactory::createRowFromArray($this->headerSpreadsheet(), $this->createStyleHeader()) ; 
    $writer->addRow($criaHeader);
    createRowPostsInfos($arrayPersons, $objectPapers, $writer);
    $writer->close(); 
    echo 'Vamos Chover!';
  }
}

