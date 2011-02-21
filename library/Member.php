<?php

/**
 * Член клуба Ариадна.
 *
 * @author maximax
 */
class Member extends User {

  public function Member($lastName, $firstName, $middleName, $alias = null) {
    parent::User($lastName, $firstName, $middleName);
    $this->setAlias(($alias == '') ? null : $alias);
  }

  /**
   * Выбирает из БД Member по ид.
   * 
   * @param int $id
   */
  public static function fetchById($memberId) {
    $db = System::getClubDbConnection();
    $query = "SELECT * FROM member WHERE member_id = $memberId ;";
    $res = mysqli_query($db, $query);
    $row = mysqli_fetch_array($res);
    $member = new Member($row['lastname'], $row['firstname'], $row['middlename']);
    $member->setId((int) $row['member_id']);
    if ($row['sex'] == 1) {
      $member->setSex(Member::MALE);
    } else {
      $member->setSex(Member::FAMELE);
    }
    $member->setBirthDate(new DateTime($row['birthday']));
    $member->setAlias(($row['alias'] == '') ? null : $row['alias']);
    $member->setRanks(Rank::fetchByMemberId($memberId));
    return $member;
  }

  /**
   * Устанавливает пол.
   *
   * @param string $sex пол
   */
  public function setSex($sex) {
    $this->sex = $sex;
  }

  public function getSex() {
    return $sex;
  }

  public function setAlias($alias) {
    $this->alias = $alias;
  }

  public function getAlias() {
    return $alias;
  }

  private function setRanks(array $ranks) {
    $this->ranks = $ranks;
  }

  public function getRanks() {
    return $ranks;
  }

  /**
   * Кличка.
   * @var string
   */
  private $alias;

  const FAMELE = 'жен.';

  const MALE = 'муж.';

  /**
   * Пол.
   * true - муж., false - жен.
   * @var boolean
   */
  private $sex;
  private $ranks;

}