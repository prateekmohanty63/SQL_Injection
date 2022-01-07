<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <form action="site.php" method="get">
        First Name: <input type="text" name="fname">
            Last Name: <input type="text" name="lname">
        <input type="submit">
        </form>
    
    <?php
        if (isset($_GET['fname']) && isset($_GET['lname'])) {
            $servername = "localhost";
            $username = "root";
            $password = "ganesh99";
            $dbname = "owasp";
    
            $conn = new mysqli($servername, $username, $password, $dbname);
    
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $userFirstName = $_GET['fname'];
            $userLastName = $_GET['lname'];
            //$id = $_GET['id'];
            $sql = "SELECT id, fname, lname FROM myDB WHERE fname = '$userFirstName' AND lname = '$userLastName'";
            //$sql = "SELECT first_name, last_name FROM users WHERE id = ".$id;
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
           
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Name: " . $row["fname"]. " " . $row["lname"]. "<br>";
                echo $sql;
            }
            } else {
                echo "0 results";
            }
            $conn->close();
        }
    ?>
</body>
</html>
