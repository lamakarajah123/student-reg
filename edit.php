<?php
require_once 'conn.php';

if (isset($_GET['stid'])) {
    $stid = $_GET['stid'];
    $query = "SELECT * FROM students WHERE stid = :stid";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':stid', $stid, PDO::PARAM_INT);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "Student not found.";
        exit;
    }
} else {
    echo "Student ID not provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $sname = $_POST['sname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $dep = $_POST['dep'];
    $avg = $_POST['avg'];
    $addr = $_POST['addr'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
  

    $query = "UPDATE students SET sname = :sname, gender = :gender, dob = :dob, dep = :dep, avg = :avg, 
              addr = :addr, city = :city, country = :country, tel = :tel, email = :email 
              WHERE stid = :stid";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':sname', $sname);
    $stmt->bindValue(':gender', $gender);
    $stmt->bindValue(':dob', $dob);
    $stmt->bindValue(':dep', $dep);
    $stmt->bindValue(':avg', $avg);
    $stmt->bindValue(':addr', $addr);
    $stmt->bindValue(':city', $city);
    $stmt->bindValue(':country', $country);
    $stmt->bindValue(':tel', $tel);
    $stmt->bindValue(':email', $email);
   

    $stmt->bindValue(':stid', $stid);
    $stmt->execute();

    header("Location: students.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
<fieldset>
        <legend>Edit Student</legend>
<form method="POST">
    <label for="sname">Name:</label>
    <input type="text" id="sname" name="sname" value="<?php echo $student['sname']; ?>">
    <br><br>

    <label for="gender">Gender:</label>
<input type="radio" name="gender" id="male" value="male" <?php echo ($student['gender'] == 'male') ? 'checked' : ''; ?>>
<label for="male">Male</label>

   <input type="radio" name="gender" id="female" value="female" <?php echo ($student['gender'] == 'female') ? 'checked' : ''; ?>>
    <label for="female">Female</label>
    <br><br>

    <label for="dob">Date of Birth:</label>
    <input type="text" id="dob" name="dob" value="<?php echo $student['dob']; ?>">
    <br><br>

    <label for="dep">Department:</label>
    <input type="text" id="dep" name="dep" value="<?php echo $student['dep']; ?>">
    <br><br>

    <label for="avg">Average:</label>
    <input type="text" id="avg" name="avg" value="<?php echo $student['avg']; ?>">
    <br><br>

    <label for="addr">Address:</label>
    <input type="text" id="addr" name="addr" value="<?php echo $student['addr']; ?>">
    <br><br>

    <label for="city">City:</label>
    <input type="text" id="city" name="city" value="<?php echo $student['city']; ?>">
    <br><br>

    <label for="country">Country:</label>
    <input type="text" id="country" name="country" value="<?php echo $student['country']; ?>">
    <br><br>

    <label for="tel">Tel:</label>
    <input type="text" id="tel" name="tel" value="<?php echo $student['tel']; ?>">
    <br><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" value="<?php echo $student['email']; ?>">
    <br><br>

   

    <button type="submit">Update</button>
</form>
</form>
    </fieldset>

</body>
</html>
