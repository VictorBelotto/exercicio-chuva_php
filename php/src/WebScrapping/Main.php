<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;
use DOMDocument;
use DOMXPath;


require '../../vendor/autoload.php';

libxml_use_internal_errors(true);

class Main {
  public static function run()
    {
        $scrapper = new Scrapper();
        $data = $scrapper->getPosts();
        
        $scrapper->scrap($data);

    }

};
    

$main = new Main();
$main::run();