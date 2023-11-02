<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * Represents personal information of a paper author.
 */
class Person {
  /**
   * Author names.
   *
   * @var array
   */
  public $name;

  /**
   * Author institutions.
   *
   * @var array
   */
  public $institution;

  /**
   * Builder.
   */
  public function __construct($names, $institutions) {
    $this->name = $names;
    $this->institution = $institutions;
  }

}
