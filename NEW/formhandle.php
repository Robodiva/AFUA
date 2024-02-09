<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST["first_name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $date_of_birth = $_POST["date_of_birth"];
    $country = $_POST["country"];
   

    // Connect to the database
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "bank_app";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Insert data into database
    $sql = "INSERT INTO users (first_name, surname, email, phone_number, date_of_birth, country)
            VALUES ('$first_name', '$surname', '$email', '$phone_number', '$date_of_birth', '$country')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
