<?php

namespace Chuva\Php\WebScrapping\Entity;

class Paper {
  /**
   * Paper Id.
   *
   * @var int
   */
  public $id;
  /**
   * Paper Title.
   *
   * @var string
   */
  public $title;
  /**
   * The paper type (e.g. Poster, Nobel Prize, etc).
   *
   * @var string
   */
  public  $type;

  
  public function __construct($id, $title, $type ) {
    $this->id = $id;
    $this->title = $title;
    $this->type = $type;

  }
}
