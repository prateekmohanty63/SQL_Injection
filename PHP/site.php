<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="owaspLogo.png">
    <title>SQL Injection</title>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#main">Try it out</a></li>
    </ul>
  </div>
</nav>
    <section class="Intro">
        <div class="heading">
            <div class="container">
                <p class="glitch">
                  <span aria-hidden="true"></span>
                  SQL Injection
                  <span aria-hidden="true"></span>
                </p>
              </div>
        </div>
    </section>
    <section class="about" id="about">
        <div class="aboutHeading">
            <h1>ABOUT</h1>
        </div>
        <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Neque sint magnam a sunt dolor? Iusto, numquam aut? Ratione culpa quos in illum rerum odit quae, dolores numquam quibusdam modi non cupiditate enim sequi ea. Earum similique laborum asperiores ea, nisi voluptatum placeat minus rerum inventore velit. Ea illo voluptatum quia. Eligendi totam itaque nesciunt quis, provident officiis veniam deleniti deserunt sapiente animi quod unde dolorem molestias nostrum voluptate beatae, accusamus ullam cupiditate suscipit quidem tempore maiores. Nemo facere eaque enim exercitationem eligendi iure nulla itaque, veniam eos harum error consectetur neque veritatis libero quos iste quia repellendus temporibus. Sequi, quaerat?
            <br><br>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Corporis blanditiis hic, magni aliquid ipsam dolores explicabo fugiat recusandae esse quas provident praesentium odit sint ad voluptate corrupti ab iusto fugit cupiditate modi animi reiciendis doloremque odio. Repellat non illum ullam dignissimos! Harum suscipit, sunt illum earum laborum commodi minima eaque.
        </p>
    </section>
    <section class="injection" id="main">
        <div class="injectionHeading">
            <h1>TRY IT OUT</h1>
        </div>
        <div class="main">
            <form action="main.php" method="get">
                <b>First Name : </b><input type="text" name="fname" class="input-stuff" required/>
                <br>
                <br>
                <b>Last Name : </b><input type="text" name="lname" class="input-stuff" required/>
                <br>
                <br>
                <center><input type="submit" class="btn-submit"></center>
            </form>
        </div>
        <br>
            <div class="FinalOutput">
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
                        echo "| id: " . $row["id"]. " | Name : " . $row["fname"]. " " . $row["lname"]. " |<br>";
                    }
                    } else {
                        echo "0 results";
                    }
                    
                    $conn->close();
                }
            ?>
        
    </section>
</body>
<script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>
</html>
