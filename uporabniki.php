<?php
$st1 = mt_rand(1,10);
$st2 = mt_rand(1,10);
$operator = mt_rand(1,2);
if ($operator ==1)
{
    $rezultat = $st1 + $st2;
    $op = "+";
}
if ($operator ==2)
{
    $rezultat = $st1 * $st2;
    $op = "*";
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>KNJIGA GOSTOV</title>
    <style>

   table, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 7px;
    background-color: lightblue;
}
    th {
      border: 1px solid black;
      border-collapse: collapse;
      padding: 7px;
      background-color: red;
    }

    </style>
</head>
<body style="padding: 10px 50px 10px 50px">
<div class="row">
    <div class="col-4">
        <!-- vnos komentarjev -->
        <div class="card">
            <div class="card-header">
                <h1>VNOS KOMENTARJEV</h1>
            </div>
            <div class="card-body">
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="email1">EMAIL:</label>
                        <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Vnesi email:">
                    </div>
                    <div class="form-group">
                        <label for="ime">IME:</label>
                        <input type="text" class="form-control" name="ime" aria-describedby="emailHelp" placeholder="Vnesi ime:">
                    </div>
                    <div class="form-group">
                        <label for="priimek">PRIIMEK:</label>
                        <input type="text" class="form-control" name="priimek" placeholder="Vnesi priimek:">
                    </div>
                    <div class="form-group">
                        <label for="komentar">KOMENTAR:</label>
                        <textarea name="komentar" class="form-control" placeholder="Vnesi komentar:"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="rezultat">REZULTAT (<?php echo $st1.$op.$st2; ?>=?):</label>
                        <input type="text" class="form-control" name="rezultat" placeholder="Vnesi rezultat:">
                    </div>
                    <input type="hidden" value="<?php echo $rezultat; ?>" name="rezultat2">
                    <input type="submit" class="btn btn-primary" name="btn_poslji" value="Pošlji">
                </form>
                <?php
                if (isset($_POST['btn_poslji']))
                {
                    $email = $_POST['email'];
                    $ime = $_POST['ime'];
                    $priimek = $_POST['priimek'];
                    $komentar = $_POST['komentar'];
                    $rezultat1 = $_POST['rezultat'];
                    if ($_POST['rezultat2'] == $rezultat1)
                    {
                        //vpis komentarja v datoteko
                        $datoteka = fopen("komentarji.txt", "w") or die("Ne morem odpreti datoteke!");
                        $txt = "<h2>".$ime." ".$priimek."<small>"." ".$email."</small></h2><p>".$komentar;

                        fwrite($datoteka, $txt);
                        fclose($datoteka);
                        $servername = "localhost";
                        $username = "root";
                        $password = "Squierstratcy1605!";
                        $dbname = "uporabniki";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "INSERT INTO komentarji (Ime,Priimek, Email, Komentar)
                        VALUES ('$ime', '$priimek', '$email', '$komentar')";

                        if ($conn->query($sql) === TRUE) {
                            echo "New record created successfully";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }

                        $conn->close();
                                            }

                                        }
                                        ?>

            </div>
        </div>
    </div>
    <div class="col-8">
        <!-- izpis komentarjev -->
        <h1>KOMENTARJI</h1>
        <hr>
        <?php
        $_file = fopen("komentarji.txt","r");
        echo fgets($_file);
        fclose($_file);
        ?>
        <br>
        <br>
        <?php

        $servername = "localhost";
        $username = "root";
        $password = "Squierstratcy1605!";
        $dbname = "uporabniki";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT ID, Ime, Priimek, Email, Komentar FROM komentarji";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Name</th><th>Mail</th><th>Comment</th></tr>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td> ".$row["ID"]."</td>     <td>".$row["Ime"]." ".$row["Priimek"]."</td>  <td> ".$row["Email"]."</td>  <td> ".$row["Komentar"]."</td>      </tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
