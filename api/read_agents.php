<?php
  //include '../db.php';
  $conn = new mysqli("localhost", "u267764797_fwLyY", "fKiBVKXVoD", "u267764797_V3OQl");
  $sql = "select * from agents";
  $result = $conn->query($sql);
  echo "<tbody>";
  echo "<tr>";
      echo "<th>AGENT_CODE</th>";
      echo "<th>AGENT_NAME</th>";
      echo "<th>WORKING_AREA</th>";
      echo "<th>COMMISSION</th>";
      echo "<th>PHONE_NO</th>";
      echo "<th>COUNTRY</th>";
  echo "</tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['AGENT_CODE'] . "</td>";
    echo "<td>" . $row['AGENT_NAME'] . "</td>";
    echo "<td>" . $row['WORKING_AREA'] . "</td>";
    echo "<td>" . $row['COMMISSION'] . "</td>";
    echo "<td>" . $row['PHONE_NO'] . "</td>";
    echo "<td>" . $row['COUNTRY'] . "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  $conn->close();
?>