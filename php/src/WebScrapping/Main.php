<?php

namespace Chuva\Php\WebScrapping;
use DOMDocument;
libxml_use_internal_errors(true);
class Main {
  public static function run() {
  $html = file_get_contents(__DIR__ . '/../../assets/origin.html');
  $dom = new \DOMDocument();
  $dom->loadHTML($html);

  $scrapper = new Scrapper();
  $data = $scrapper->scrap($dom);

  $generator = new ExcelGenerator();
  $generator->generate($data);
  }

};
 
