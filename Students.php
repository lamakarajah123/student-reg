<?php
require_once 'conn.php';

$query = "SELECT * FROM students";
$stmt = $pdo->prepare($query);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
</head>
<body>
    <fieldset>
        To register a new student, click on the following link: <b><a href="register.php" target="_blank">Register</a></b>
        <p>Or use the actions below to edit, delete, or view a student's record.</p>

        <table border="3">
            <caption>Students Table Result</caption>
            <thead>
                <tr>
                    <th>Student Photo</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Average</th>
                    <th>Department</th>
                    <th colspan="3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><img src="<?php echo $student['photo']; ?>" alt="photo" width="50"></td>
                    <td>                                                          
                        <a href="view.php?stid=<?php echo $student['stid']; ?>">
                            <?php echo $student['stid']; ?>
                        </a>
                    </td>
                    <td><?php echo $student['sname']; ?></td>
                    <td><?php echo $student['avg']; ?></td>
                    <td><?php echo $student['dep']; ?></td>
                    <td>
                        <a href="edit.php?stid=<?php echo $student['stid']; ?>">
                            <img src="edit.png" alt="Edit" width="20" height="20">
                        </a>
                    </td>
                    <td>
                        <a href="delete.php?stid=<?php echo $student['stid']; ?>">
                            <img src="delete.png" alt="Delete" width="20" height="20">
                        </a>
                      
                    </td>
                </tr>
                <?php
             endforeach;
             
             ?>
            </tbody>
        </table>
    </fieldset>
</body>
</html>
