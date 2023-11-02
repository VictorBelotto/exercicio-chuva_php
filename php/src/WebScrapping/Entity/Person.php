<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * Paper Author personal information.
 */
class Person {
  public  $name;
  public  $institution;

 
  public function __construct($names, $institutions ) {
    $this->name = $names;
    $this->institution = $institutions;
  }

}
