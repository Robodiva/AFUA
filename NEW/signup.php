<?php
// Define variables and initialize with empty values
$first_name = $surname = $email = $phone_number = $date_of_birth = $country = "";
$first_name_error = $surname_error = $email_error = $phone_number_error = $date_of_birth_error = $country_error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize first name
    if (empty($_POST["first_name"])) {
        $first_name_error = "First name is required";
    } else {
        $first_name = test_input($_POST["first_name"]);
      
        if (!preg_match("/^[a-zA-Z-' ]*$/", $first_name)) {
            $first_name_error = "Only letters and white space allowed";
        }
    }

    // Validate and sanitize surname
    if (empty($_POST["surname"])) {
        $surname_error = "Surname is required";
    } else {
        $surname = test_input($_POST["surname"]);
       
        if (!preg_match("/^[a-zA-Z-' ]*$/", $surname)) {
            $surname_error = "Only letters and white space allowed";
        }
    }

    // Validate and sanitize email
    if (empty($_POST["email"])) {
        $email_error = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Invalid email format";
        }
    }

    // Validate and sanitize phone number
    if (!empty($_POST["phone_number"])) {
        $phone_number = test_input($_POST["phone_number"]);
        // Check if phone number contains only numbers and dashes
        if (!preg_match("/^[0-9-]*$/", $phone_number)) {
            $phone_number_error = "Invalid phone number format";
        }
    }

    // Validate and sanitize date of birth
    if (empty($_POST["date_of_birth"])) {
        $date_of_birth_error = "Date of birth is required";
    } else {
        $date_of_birth = test_input($_POST["date_of_birth"]);
        // Check if date is in valid format (YYYY-MM-DD)
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date_of_birth)) {
            $date_of_birth_error = "Invalid date format";
        }
    }

    // Validate and sanitize country
    if (empty($_POST["country"])) {
        $country_error = "Country is required";
    } else {
        $country = test_input($_POST["country"]);
        // Check if country contains only letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $country)) {
            $country_error = "Only letters and white space allowed";
        }
    }

    if (empty($first_name_error) && empty($surname_error) && empty($email_error) && empty($phone_number_error) && empty($date_of_birth_error) && empty($country_error)) {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bank app database";

        $conn = new mysqli($servername, $username, $password, $dbname);

       
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert user data into the database
        $sql = "INSERT INTO users (first_name, surname, email, phone_number, date_of_birth, country)
                VALUES ('$first_name', '$surname', '$email', '$phone_number', '$date_of_birth', '$country')";

        if ($conn->query($sql) === TRUE) {
            echo "Congratulations, Sign up successful!"; 
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close database connection
        $conn->close();
    }
}

// Function to sanitize and validate input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
</head>
<body>

<h2>Signup Form</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
    <span class="error"><?php echo $first_name_error; ?></span><br><br>

    <label for="surname">Surname:</label>
    <input type="text" id="surname" name="surname" value="<?php echo $surname; ?>" required>
    <span class="error"><?php echo $surname_error; ?></span><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
    <span class="error"><?php echo $email_error; ?></span><br><br>

    <label for="phone_number">Phone Number:</label>
    <input type="tel" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>">
    <span class="error"><?php echo $phone_number_error; ?></span><br><br>

    <label for="date_of_birth">Date of Birth:</label>
    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $date_of_birth; ?>" required>
    <span class="error"><?php echo $date_of_birth_error; ?></span><br><br>

    <label for="country">Country:</label>
    <input type="text" id="country" name="country" value="<?php echo $country; ?>" required>
    <span class="error"><?php echo $country_error; ?></span><br><br>

    <input type="submit" value="Sign Up">
</form>

</body>
</html>
