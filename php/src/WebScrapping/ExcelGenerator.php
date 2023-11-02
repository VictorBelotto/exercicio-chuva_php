<?php

namespace Chuva\Php\WebScrapping;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Color;

class ExcelGenerator {

    /* Cria a estilização do cabeçalho */
    static function createStyleHeader() {
        $style = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(15)
            ->setBackgroundColor(Color::LIGHT_GREEN)
            ->build();
        return $style;
    }

    static function headerSpreadsheet() {
        /* Cria a construção do cabeçalho da planilha. O looping é para poupar a escrita repetitiva de autor e instituição, ainda define a quantidade */
        $authorsAndInstitutionArray = [];
        $quantAuthor = 16;
        for ($i = 1; $i <= $quantAuthor; $i++) {
            $authorName = "Author $i";
            $authorInstituition = "Author $i Instituition";

            $authorsAndInstitutionArray[] = $authorName;
            $authorsAndInstitutionArray[] = $authorInstituition;
        }
        $headerSpreadsheet = ["ID", "Title", "Type"];
        /* Retorna a linha do cabeçalho formatada */
        return $rowHeaderSpreadsheet = array_merge($headerSpreadsheet, $authorsAndInstitutionArray);
    }

    function generate($data) : void {
        /* Data é um array que contém 2 dados: Um array de objetos da classe Paper e um array que armazena Person */
        $data = $data;
        $filePath = __DIR__ . '/../../assets/resultadoWebscrappring.xlsx';
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToFile($filePath);
        /* Essa função alem de criar as linhas da tabela por um array, também ordena o array de em sequência de autor1 e instituição1 e assim por diante */
        function createRowPostsInfos($data, $writer) {

          for ($i = 0; $i < count($data); $i++){
            $id = $data[$i]->id;
            $title = $data[$i]->title;
            $type = $data[$i]->type;
            $arrayRow = [$id, $title, $type];


                $authorName = $data[$i]->authors->name;
                $authorInstituition =  $data[$i]->authors->institution;
                $arrayAuthorsAndInstituition = [];
                /* Este loop recebe a quantidade de autores relativos à posição acima para realizar a ordem de autor 1 e instituição 1.... */
                for($a = 0; $a < count($authorName); $a++){
                    $arrayAuthorsAndInstituition[] = $authorName[$a];
                    $arrayAuthorsAndInstituition[] = $authorInstituition[$a];
                }
                /* Para cada posição do loop "objectPersons", faremos a criação da linha da planilha formatada com os dados em ordem */  
                
                $linhaAuthors = $arrayAuthorsAndInstituition;
                $merged =  array_merge($arrayRow, $linhaAuthors );
                $linha =  WriterEntityFactory::createRowFromArray($merged) ;
                $writer->addRow($linha); 
          }

            
        }
  
        $criaHeader = WriterEntityFactory::createRowFromArray($this->headerSpreadsheet(), $this->createStyleHeader()) ; 
        $writer->addRow($criaHeader);
        createRowPostsInfos($data, $writer);
        $writer->close(); 
        echo 'Vamos Chover!';
    }
}
