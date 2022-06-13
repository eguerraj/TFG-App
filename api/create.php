<?php
  //include '../db.php';
  $conn = new mysqli("localhost", "u267764797_fwLyY", "fKiBVKXVoD", "u267764797_V3OQl");
  $statement = $_POST["statement"];
  //$sql = "insert into demo_table (name, score) values ('$name', '$score')";
  $sql = $statement;
  $conn->query($sql);
  $conn->close();
?>