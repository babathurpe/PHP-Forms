<?php
    // Grab our POSTed form values
    // Note that whatever is enclosed by $_POST[""] matches the form input elements
/* @var $_POST type */
if(isset($_POST['submit']))
{
    // Connect to our DB with mysql_connect(<server>, <username>, <password>)
    $sql_connection = mysql_connect("localhost", "root", "");
    //if no connection then display this error message
    if (!$sql_connection){
        die("Cannot connect to database. Try again later.");
    }
    
    mysql_select_db("simplesocialnetwork", $sql_connection);

    $name = mysql_real_escape_string(htmlspecialchars($_POST["name"]));
    $password = mysql_real_escape_string(md5($_POST["password"]));
    $gender = mysql_real_escape_string(htmlspecialchars($_POST["gender"]));
    $city = mysql_real_escape_string(htmlspecialchars($_POST["city"]));
    $country = mysql_real_escape_string(htmlspecialchars($_POST["country"]));
    $dob = mysql_real_escape_string(htmlspecialchars($_POST["date"]));
    $relationship = mysql_real_escape_string(htmlspecialchars($_POST["status"]));

                if($name && $password && $gender && $city && $country && $dob && $relationship)
                {
                    $sql = "INSERT INTO user (name,password,sex,city, country, dateOfBirth, relationship_status)
                        VALUES ('$name','$password','$gender','$city','$country','$dob','$relationship'
                        )";
                mysql_query($sql, $sql_connection);
                //echo'header(Location'
                header('Location: thankyou.html ');
                mysql_close($sql_connection);
            } else {
                echo 'Some fields are empty';
                header('Location: register.html ');
            }
    
    }
?>
