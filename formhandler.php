<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter signup form</title>
    <style type="text/css">
        body,p{
            color: black;
            font-family: verdana;
            font-size: 10pt
        }
    </style>
</head>
<body>
    <table border=0 cellpadding=10 width=100%>
        <tr>
            <td bgcolor="#F0F8FF" align=center valign=top width=17%></td>
            <td bgcolor="#FFFFFF" align=left valign=top width=83%>
                <h1>Newsletter sign-up form</h1>
                <?php
                    $host = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "newsletter_signup";
                    //establish connection using mysql
                    $conn = new mysqli($host, $username, $password, $database);
                    if($conn->connect_error){
                        die("Connection failed: " . $conn->connect_error);
                    }
                    if($_SERVER["REQUEST_METHOD"] === "POST"){
                        $email = trim($_POST['email']); // trim whitespace

                        // Validate email
                        if(empty($email)){
                            echo "<p>Email address is required.</p>";
                        }elseif(strlen($email)>30){#check if email size if more than 30
                            echo "<p>Is your email really that long?</p>";
                        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){#check validate email format
                            echo "<p>Invalid email address format.</p>";
                        }else{
                            // Prepare and bind the sql statement
                            $stmt = $conn->prepare("INSERT INTO users (id, email) VALUES(NULL, ?)");
                            $stmt->bind_param("s", $email);

                            // Execute the statement
                            if($stmt->execute()) {
                                echo "<p>Your information has been recorded</p>";
                            }else{
                                error_log("Database error".$stmt->error);
                                echo "<p>Something went wrong with your signup attempt...</p>";
                            }
                            $stmt->close();  // close the statement
                        }
                    }
                    $conn->close(); // close the connection
                ?>
            </td>
        </tr>
    </table>
</body>
</html>