<?php

namespace Chuva\Php\WebScrapping;

libxml_use_internal_errors(TRUE);

/**
 * Runner for the Webscrapping exercice.
 */
class Main {

  /**
   * Main runner, instantiates a Scrapper and runs.
   */
  public static function run() {
    $html = file_get_contents(__DIR__ . '/../../assets/origin.html');
    $dom = new \DOMDocument();
    $dom->loadHTML($html);

    $scrapper = new Scrapper();
    $data = $scrapper->scrap($dom);

    $generator = new ExcelGenerator();
    $generator->generate($data);
  }

}
