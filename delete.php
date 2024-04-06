<?php
require_once 'conn.php';


if (isset($_GET['stid'])) {
    $stid = $_GET['stid'];


    $query = "DELETE FROM students WHERE stid = :stid";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':stid', $stid);
    $stmt->execute();


    header("Location: students.php");
   

    exit;
} else {
    echo "Student ID not provided.";
    exit;
}
?>