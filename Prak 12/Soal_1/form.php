<!DOCTYPE html>
<html>
<head>
    <title>Add Profile</title>
</head>
<body>
    <h2>Add profile</h2>
    <?php
    if (isset($_GET['error'])) {
        $errors = explode('|', $_GET['error']);
        echo "<div style='color: red;'>";
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        echo "</div>";
    }
    ?>
    <form action="process.php" method="post">
        <table border="1" cellpadding="5">
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value=""></td>
            </tr>
            <tr>
                <td>Position</td>
                <td>
                    <select name="position">
                        <option value="Programmer">Programmer</option>
                        <option value="Senior Programmer" selected>Senior Programmer</option>
                        <option value="Junior Programmer">Junior Programmer</option>
                        <option value="System Analyst">System Analyst</option>
                        <option value="Senior Analyst">Senior Analyst</option>
                        <option value="Junior Analyst">Junior Analyst</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>Confirm Password</td>
                <td><input type="password" name="confirm_password"></td>
            </tr>
        </table><br>
        <input type="reset" value="Reset" onclick="document.querySelector('select').value = 'Senior Programmer';">
        <input type="submit" name="submit" value="Save">
    </form>
</body>
</html>
