<?php
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $stid = $_POST['stid'];
    $sname = $_POST['sname'];

    // Check if gender is set
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    } else {
        echo("Error: Gender is not selected.");
        return; // Stop execution if gender is not set
    }

    $dob = $_POST['dob'];
    $dep = $_POST['dep'];
    $avg = $_POST['avg'];
    $addr = $_POST['addr'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    if (strlen($stid) > 10) {
        echo("Error: Student ID exceeds maximum length.");
    }
    
    if (strlen($tel) > 10) {
        echo("Error: Telephone number exceeds maximum length.");
    }

    $stmt = null;

    // Check if the student ID already exists in the database
    $checkQuery = "SELECT COUNT(*) FROM students WHERE stid = :stid";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':stid', $stid);
    $checkStmt->execute();
    $rowCount = $checkStmt->fetchColumn();

    if ($rowCount > 0) {
        echo("Error: Student with ID $stid already exists.");
    } else {
        if (isset($_FILES['student_photo']) && $_FILES['student_photo']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg'];
            $fileType = mime_content_type($_FILES['student_photo']['tmp_name']);

            if (in_array($fileType, $allowedTypes)) {
                $uploadir = 'images/';
                $fileName = $stid . '.jpeg'; 
                $uploadFilePath = $uploadir . $fileName;

                if (move_uploaded_file($_FILES['student_photo']['tmp_name'], $uploadFilePath)) {
                    $query = "INSERT INTO students (stid, sname, gender, dob, dep, avg, addr, city, country, tel, email, photo) 
                        VALUES (:stid, :sname, :gender, :dob, :dep, :avg, :addr, :city, :country, :tel, :email, :photo)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':photo', $uploadFilePath);
                } else {
                    echo("Failed to upload photo");
                }
            } else {
                echo("Invalid file type. Only JPEG images are allowed.");
            }
        } else {
            // Non-file upload logic
            $query = "INSERT INTO students (stid, sname, gender, dob, dep, avg, addr, city, country, tel, email) 
                      VALUES (:stid, :sname, :gender, :dob, :dep, :avg, :addr, :city, :country, :tel, :email)";
            $stmt = $pdo->prepare($query);
        }

        if ($stmt !== null) {
            $stmt->bindParam(':stid', $stid);
            $stmt->bindParam(':sname', $sname);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':dep', $dep);
            $stmt->bindParam(':avg', $avg);
            $stmt->bindParam(':addr', $addr);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':country', $country);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
</head>
<body>
    <fieldset>
        <legend>Student Record</legend>
        <form action="register.php" method="post" enctype="multipart/form-data">
            <label for="stid">Student ID:</label>
            <input type="text" name="stid" id="stid" required>
            <br><br>
            <label for="sname">Student Name:</label>
            <input type="text" name="sname" id="sname" required>
            <br><br>
            <label for="gender">Gender:</label>
            <input type="radio" name="gender" id="male" value="male">
            <label for="male">Male</label>
            <input type="radio" name="gender" id="female" value="female">
            <label for="female">Female</label>
            <br><br>
            <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" id="dob" required>
            <br><br>
            <label for="dep">Department:</label>
            <input type="text" name="dep" id="dep" required>
            <br><br>
            <label for="avg">Average:</label>
            <input type="number" name="avg" id="avg" step="0.01" required>
            <br><br>
            <label for="addr">Address::</label>
            <input type="text" name="addr" id="addr" required>
            <br><br>
            <label for="city">City:</label>
            <input type="text" name="city" id="city" required>
            <label for="country">Country:</label>
            <input type="text" name="country" id="country" required>
            <p></p>

            <label for="tel">Tel:</label>
            <input type="tel" name="tel" id="tel" required>
            <br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <br><br>
            <label for="student_photo">Student Photo:</label>
            <input type="file" name="student_photo" id="student_photo">
            <br><br>
            <button type="submit">Insert</button>
        </form>
    </fieldset>
</body>
</html>
