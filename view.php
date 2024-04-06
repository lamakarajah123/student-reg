<?php
require_once 'conn.php';


if(isset($_GET['stid'])) {
    $studentId = $_GET['stid'];

   
    $query = "SELECT * FROM students WHERE stid = :stid";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':stid', $studentId, PDO::PARAM_INT);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

 
    if ($student) {
       
        echo "<p><img src='" . $student['photo'] . "' alt='photo' width='50'></p>";
        echo "<p><h1><strong>Student ID:</strong> " . $student['stid'] ." , ";
        echo "<strong> Name:</strong>" . $student['sname']." </h1> " ;
        echo "<ul><li>Average: " . $student['avg'] . " </li>";
        echo " <li>Department:  " . $student['dep'] . "</li> ";
        echo " <li>Date Of Birth:  " . $student['dob'] . "</li> </ul>";
        echo "<p><strong>Contact" ." </strong></p>";
        echo "<p>Send Email to : <a href='mailto:" . $student['email'] . "'>" . $student['email'] . "</p></a>";
        echo "<p>Phone: <a href='tel:" . $student['tel'] . "'>" . $student['tel'] . "</a></p>";
        echo "<p><i>Address: " . $student['city'] , "," , $student['country'] . " </i></p>";
    } else {
       
        echo "<p>Error: Invalid Student ID</p>";
    }
} else {
   
    echo "<p>Error: Student ID not provided</p>";
}
?>
