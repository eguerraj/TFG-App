<?php
  //include '../db.php';
  $conn = new mysqli("localhost", "u267764797_fwLyY", "fKiBVKXVoD", "u267764797_V3OQl");
  $sql = "select * from customer";
  $result = $conn->query($sql);
  echo "<tbody>";
  echo "<tr>";
      echo "<th>CUST_CODE</th>";
      echo "<th>CUST_NAME</th>";
      echo "<th>CUST_CITY</th>";
      echo "<th>WORKING_AREA</th>";
      echo "<th>CUST_COUNTRY</th>";
      echo "<th>GRADE</th>";
      echo "<th>OPENING_AMT</th>";
      echo "<th>RECEIVE_AMT</th>";
      echo "<th>PAYMENT_AMT</th>";
      echo "<th>OUTSTANDING_AMT</th>";
      echo "<th>PHONE_NO</th>";
      echo "<th>AGENT_CODE</th>";
  echo "</tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['CUST_CODE'] . "</td>";
    echo "<td>" . $row['CUST_NAME'] . "</td>";
    echo "<td>" . $row['CUST_CITY'] . "</td>";
    echo "<td>" . $row['WORKING_AREA'] . "</td>";
    echo "<td>" . $row['CUST_COUNTRY'] . "</td>";
    echo "<td>" . $row['GRADE'] . "</td>";
    echo "<td>" . $row['OPENING_AMT'] . "</td>";
    echo "<td>" . $row['RECEIVE_AMT'] . "</td>";
    echo "<td>" . $row['PAYMENT_AMT'] . "</td>";
    echo "<td>" . $row['OUTSTANDING_AMT'] . "</td>";
    echo "<td>" . $row['PHONE_NO'] . "</td>";
    echo "<td>" . $row['AGENT_CODE'] . "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  $conn->close();
?>