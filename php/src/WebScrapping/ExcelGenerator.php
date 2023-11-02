<?php

namespace Chuva\Php\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Color;

class ExcelGenerator
{

    static function createStyleHeader()
    {
        $style = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(15)
            ->setBackgroundColor(Color::LIGHT_GREEN)
            ->build();
        return $style;
    }

    static function headerSpreadsheet()
    {
        $authorsAndInstitutionArray = [];
        $quantAuthor = 16;
        for ($i = 1; $i <= $quantAuthor; $i++) {
            $authorName = "Author $i";
            $authorInstitution = "Author $i Institution";

            $authorsAndInstitutionArray[] = $authorName;
            $authorsAndInstitutionArray[] = $authorInstitution;
        }
        $headerSpreadsheet = ["ID", "Title", "Type"];
        $rowHeaderSpreadsheet = array_merge($headerSpreadsheet, $authorsAndInstitutionArray);
        return $rowHeaderSpreadsheet;
    }

    function generate($data) : void
    {
        $data = $data;
        $filePath = __DIR__ . '/../../assets/resultadoWebscraping.xlsx';
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToFile($filePath);

        function createRowPostsInfos($data, $writer)
        {
            for ($i = 0; $i < count($data); $i++){
                $id = $data[$i]->id;
                $title = $data[$i]->title;
                $type = $data[$i]->type;
                $arrayRow = [$id, $title, $type];

                $authorName = $data[$i]->authors->name;
                $authorInstitution = $data[$i]->authors->institution;
                $arrayAuthorsAndInstitution = [];
          
                for($a = 0; $a < count($authorName); $a++){
                    $arrayAuthorsAndInstitution[] = $authorName[$a];
                    $arrayAuthorsAndInstitution[] = $authorInstitution[$a];
                }

                $linhaAuthors = $arrayAuthorsAndInstitution;
                $merged = array_merge($arrayRow, $linhaAuthors);
                $linha = WriterEntityFactory::createRowFromArray($merged);
                $writer->addRow($linha); 
            }
        }

        $criaHeader = WriterEntityFactory::createRowFromArray($this->headerSpreadsheet(), $this::createStyleHeader());
        $writer->addRow($criaHeader);
        createRowPostsInfos($data, $writer);
        $writer->close(); 
        echo 'Vamos Chover!';
    }
}
