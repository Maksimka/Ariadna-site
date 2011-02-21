<?php

/**
 * Вид спорта в которых присуждаются спортивные разряды.
 *
 * @author maximax
 */
class Sport {

  /**
   * @param string $name название спорта
   */
  public function Sport($name, $id = null) {
    $this->id = $id;
    $this->name = $name;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  private $id;
  private $name;

}