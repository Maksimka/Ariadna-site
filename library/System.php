<?php

/**
 * Description of System
 *
 * @author maximax
 */
class System {

  public function System() {
    //@todo Автоматически сгенерированный конструктор
  }

  public static function getClubDbConnection() {
    if (self::$clubDbConnection == null) {
      self::$clubDbConnection =
              self::getConnection("localhost", "ariadna", "LRXTqBZptLEmH53Q", "club_basa");
    }
    return self::$clubDbConnection;
  }

  public static function getSaitDbConnection() {
    if (self::$saitDbConnection == null) {
      self::$saitDbConnection =
              self::getConnection("localhost", "ariadna", "LRXTqBZptLEmH53Q", "ariadna");
    }
    return self::$saitDbConnection;
  }

  private static function getConnection($db_hostname, $db_username, $db_password, $db_name) {
    try {
      $db = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
      if ($db == null) {
        throw new Exception("Не могу соединиться с базой .'$db_name'.!<br>");
      }
      mysqli_query($db, "set character_set_client='utf8'");
      mysqli_query($db, "set character_set_results='utf8'");
      mysqli_query($db, "set collation_connection='utf8_unicode_ci'");
    } catch (Exception $c) {
      echo "<div class = 'error'>" . $c->getMessage() . "</div>";
    }
    return $db;
  }

  private static $clubDbConnection;
  private static $saitDbConnection;

}