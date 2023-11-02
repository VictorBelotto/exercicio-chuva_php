<?php

namespace Chuva\Php\WebScrapping;


class Main {
  public static function run(): void
    {
      $scrapper = new Scrapper();
      $data = $scrapper->scrap();

      $generator = new ExcelGenerator();
      $generator->generate($data);
    }

};
  