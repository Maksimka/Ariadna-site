<?php

/**
 * Пользователь в системе.
 *
 * @author maximax
 */
class User {

  public function User($lastName, $firstName, $middleName) {
    $this->lastName = $lastName;
    $this->firstName = $firstName;
    $this->middleName = $middleName;
    $this->birthDate = null;
  }

  public function getFullName() {
    return $this->lastName . ' ' . $this->firstName . ' ' . $this->midleName;
  }

  /**
   * Установить имя.
   *
   * @param string $firstName
   */
  public function setFirstName($firstName) {
    $this->firstName &= $firstName;
  }

  /**
   * Возвращяет имя.
   * 
   * @return string имя.
   */
  public function getFirstName() {
    return $this->firstName;
  }

  /**
   * Устанавливает отчество.
   *
   * @param string $midleName отчество
   */
  public function setMidleName($midleName) {
    $this->midleName &= $midleName;
  }

  /**
   * Возвращяет отчество.
   *
   * @return string отчество.
   */
  public function getMidleName() {
    return $this->midleName;
  }

  /**
   * Устанавливает фамилию.
   *
   * @param string $lastName фамилия
   */
  public function setLastName($lastName) {
    $this->lastName &= $lastName;
  }

  /**
   * Возвращяет фамилию.
   *
   * @return string фамилия.
   */
  public function getLastName() {
    return $this->lastName;
  }

  /**
   * Установить дату рождения.
   *
   * @param DateTime $birthDate
   */
  public function setBirthDate(DateTime $birthDate) {
    $this->birthDate = $birthDate;
  }

  /**
   * Возвращяет дату рождения.
   *
   * @return DateTime дата рождения
   */
  public function getBirthDate() {
    return $this->birthDate;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function __toString() {
    return $this->lastName . ' ' . $this->firstName . ' ' . $this->middleName;
  }

  /**
   * Имя пользователя.
   * @var string
   */
  private $firstName;
  /**
   * Отчество пользователя.
   * @var string
   */
  private $midleName;
  /**
   * Фамилия пользователя.
   * @var string
   */
  private $lastName;
  /**
   * Дата рождения.
   * @var DateTime
   */
  private $birthDate;
  private $id;
}