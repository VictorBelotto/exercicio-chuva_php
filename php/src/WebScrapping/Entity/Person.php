<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * Paper Author personal information.
 */
class Person {
  public  $name;
  public  $institution;

 
  public function __construct($name, $institutions ) {
    $this->name = $name;
    $this->institution = $institutions;
  }

}
