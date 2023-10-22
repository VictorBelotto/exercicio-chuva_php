<?php

namespace Chuva\Php\WebScrapping;


class Main {
  public static function run(): void
    {
        $scrapper = new Scrapper();
        $data = $scrapper->getPosts();
        
        $scrapper->scrap($data);

    }

};
  