<?php
include "connection.php";

// ====================================================================
// STEP 1: THE TRAFFIC COP
// JavaScript sends a "role" flag ("rider" or "driver"). 
// This decides which path the code takes.
// ====================================================================
$role = $_POST['role'];


// ====================================================================
// PATH A: RIDER REGISTRATION
// ====================================================================
if ($role === 'rider') {

    // 1. RECEIVE INPUTS: Grab the specific data sent by registerRider() in JS
    $name     = $_POST['name'];
    $contact  = $_POST['contact'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 2. VALIDATE INPUTS: Check for missing data or letters in the phone number
    if (empty($name) || empty($contact) || empty($username) || empty($password)) {
        echo "Please fill all fields!";
        exit();
    }
    if (!preg_match('/^[0-9]+$/', $contact)) {
        echo "Error: Contact number must contain only numbers!";
        exit();
    }

    // 3. CHECK DUPLICATES: Look inside customer_tbl
    $check_query = "SELECT * FROM customer_tbl WHERE contact_no='$contact' OR username='$username'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "User already exists!";
    } else {
        // 4. INSERT INTO DATABASE
        // ----------------------------------------------------------------
        // DATA MAP: 
        // Database Columns -> (name,    contact_no, email,    password)
        // PHP Variables    -> ('$name', '$contact', '$username', '$password')
        // ----------------------------------------------------------------
        $sql = "INSERT INTO customer_tbl (name, contact_no, username, password) 
                VALUES ('$name', '$contact', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registered successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
} 


// ====================================================================
// PATH B: DRIVER REGISTRATION
// ====================================================================
else if ($role === 'driver') {
    
    // 1. RECEIVE INPUTS: Grab the specific data sent by registerDriver() in JS
    $name = $_POST['name'];
    $contact  = $_POST['contact'];
    $username    = $_POST['username'];
    $password = $_POST['password'];
    $plate_no = $_POST['plate_no'];
    $brand    = $_POST['brand'];
    $model    = $_POST['model'];
    $color    = $_POST['color'];

    // 2. VALIDATE INPUTS: Check for missing data or letters in the phone number
    if (empty($name) || empty($contact) || empty($username) || empty($password) || empty($plate_no) || empty($brand) || empty($model) || empty($color)) {
        echo "Please fill all fields!";
        exit();
    }
    if (!preg_match('/^[0-9]+$/', $contact)) {
        echo "Error: Contact number must contain only numbers!";
        exit();
    }

    // 3. CHECK DUPLICATES: Check contact number and email
    $check_query = "SELECT * FROM driver_tbl WHERE contact_no='$contact' OR username='$username' OR plate_no='$plate_no'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "User already exists!";
    } else {
        // 4. INSERT INTO DATABASE
        // ----------------------------------------------------------------
        // DATA MAP: 
        // Database Columns -> (username,    contact_no, email,    password,    plate_no,    brand,    model,    color)
        // PHP Variables    -> ('$username', '$contact', '$email', '$password', '$plate_no', '$brand', '$model', '$color')
        // ----------------------------------------------------------------
        $sql = "INSERT INTO driver_tbl (name, contact_no, username, password, plate_no, brand, model, color) 
                VALUES ('$name', '$contact', '$username', '$password', '$plate_no', '$brand', '$model', '$color')";

        if ($conn->query($sql) === TRUE) {
            echo "Registered successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
} 


// ====================================================================
// PATH C: SECURITY CATCH-ALL
// If someone tries to send data without a role, block them.
// ====================================================================
else {
    echo "Error: Invalid user role!";
}
?>