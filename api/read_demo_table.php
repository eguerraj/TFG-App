<?php
  //include '../db.php';
  $conn = new mysqli("localhost", "u267764797_fwLyY", "fKiBVKXVoD", "u267764797_V3OQl");
  $sql = "select * from demo_table";
  $result = $conn->query($sql);
  echo "<tbody>";
  echo "<tr>";
      echo "<th>name</th>";
      echo "<th>score</th>";
  echo "</tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['score'] . "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  $conn->close();
?>