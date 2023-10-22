<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * Paper Author personal information.
 */
class Person {
  public  $names;
  public  $instituitions;

 
  public function __construct($name= [], $instituitions = []) {
    $this->names = $name;
    $this->instituitions = $instituitions;
  }

}
