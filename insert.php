<?php
$email = $_POST['email'];
$password = $_POST['passwords'];

if (!empty($email) || !empty($password)){
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "ha300900";
    $dbname = "hazeldb"; 

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
    } else {
        // $SELECT = "SELECT email From register Where email = ? Limit = 1";
        $INSERT = "INSERT Into register (email, passwords) values (?, ?)";

        $stmt = $conn->prepare("SELECT email From register Where email = ? ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            echo "new record inserted succesfully";
        } else {
            echo "someone already register using this email";
        }
        $stmt->close();
        $conn->close();
    } 
} else {
    echo "All fields are required";
    die();
}
?>