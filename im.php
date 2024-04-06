<?php
require_once 'conn.php';

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $dep = $_POST["dep"];
    $avg = $_POST["avg"];
    $addr = $_POST["addr"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];

    if ($_FILES["image"]["error"] == 4) {
        echo "<script>alert('Image Does Not Exist');</script>";
    } else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script>alert('Invalid Image Extension');</script>";
        } else if ($fileSize > 1000000) {
            echo "<script>alert('Image Size Is Too Large');</script>";
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, 'img/' . $newImageName);

            $query = "INSERT INTO your_table_name_here (sname, gender, dob, dep, avg, addr, city, country, tel, email, photo) 
                      VALUES ('$name', '$gender', '$dob', '$dep', '$avg', '$addr', '$city', '$country', '$tel', '$email', '$newImageName')";

            mysqli_query($conn, $query);

            echo "<script>alert('Successfully Added'); document.location.href = 'Students.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Upload Image File</title>
  </head>
  <body>
  <form action="im.php" method="post" enctype="multipart/form-data">
            <label for="stid">Student ID:</label>
            <input type="text" name="stid" id="stid" required>
      <label for="name">Name : </label>
      <input type="text" name="name" id="name" required value=""> <br>
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
            <label for="dob">Date of Birth :</label>
                <input type="text" name="dob" id="dob"  required >
            <br><br>
            <label for="dep">Department:</label>
            <input type="text" name="dep" id="dep" required>
            <br><br>
            <label for="avg">Average:</label>
            <input type="number" name="avg" id="avg" step="0.01" required>
            <br><br>
            <label for ="addr">Address::</label>
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
      <label for="image">Image : </label>
      <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" value=""> <br> <br>
      <button type="submit" name="submit">Submit</button>
    </form>
    <br>
    <a href="data.php">Data</a>
  </body>
</html>
