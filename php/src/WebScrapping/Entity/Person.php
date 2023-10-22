<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * Paper Author personal information.
 */
class Person {
  public  $names;
  public  $institutions;

 
  public function __construct($name= [], $institution = []) {
    $this->names = $name;
    $this->institutions = $institution;
  }

}
