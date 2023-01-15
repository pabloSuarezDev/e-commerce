<?php
  class DB {
    public static function connect() {
      $conn = new mysqli("localhost", "root", "", "tienda_master");
      $conn->set_charset('utf8mb4');

      return $conn;
    }
  }
?>