
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
