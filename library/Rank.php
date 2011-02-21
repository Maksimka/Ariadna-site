<?php

/**
 * Разряды единой всероссийской спортивной классификации.
 *
 * @author maximax
 */
class Rank {

  /**
   * @param string $rank разряды
   */
  public function Rank($rank, Sport $sport, $memberId) {
    $this->rank = $rank;
    $this->memberId = $memberId;
    $this->sport = $sport;
  }

  /**
   * Выбирает из БД Rank по ид.
   *
   * @param int $id
   * @return array Rank
   */
  public static function fetchByMemberId($memberId) {
    $db = System::getClubDbConnection();
    $query =
            'SELECT r.rank, s.sport_id, s.name '
            . 'FROM rank r '
            . 'INNER JOIN sport s ON s.sport_id = r.sport_id '
            . 'WHERE r.member_id = ' . $memberId . ' ;';
    $res = mysqli_query($db, $query);
    $ranks = array();
    $i = 0;
    while ($row = mysqli_fetch_array($res)) {
      $sport = new Sport($row['name'], (int) $row['sport_id']);
      $rank = new Rank($row['rank'], $sport, $memberId);
      $ranks[$i] = $rank;
      $i++;
    }
    mysqli_free_result($res);
    return $ranks;
  }

  public function __toString() {
    return $this->sport->getName() . ': ' . $rank;
  }

  const FIRST_RANK = "1";

  const SECOND_RANK = "2";

  const THERD_RANK = "3";

  const ICON_RANK = "значёк";

  private $rank;
  private $memberId;
  private $sport;

}