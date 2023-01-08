<?php
    include_once("config.php");

    function check_email_exist($email)
    {
        $pdo = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $sql = "SELECT * FROM users WHERE email='".$email."'";
        $result = $pdo->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) 
        {
            return true;
        } 
        else 
        {
            return false;
        } 
    }

    function test_input($data) 
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function insertUser($name, $email, $pass)
    {
        $pdo = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $pass = hash("sha256", $pass);
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";
        $pdo->query($sql);
    }

    function passVerify($inputPass, $pass)
    {
        $inputPass = hash("sha256", $inputPass);
        if ($inputPass === $pass)
        {
            return true;
        }

        return false;
    }

    function fetchPass($email)
    {
        $pdo = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $sql = "SELECT password FROM users WHERE email='".$email."'";
        $result = $pdo->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $pass = $data[0]["password"];

        return $pass;
    }

    function fetchUserByEmail($email)
    {
        $pdo = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $sql = "SELECT id, name, email FROM users WHERE email='".$email."'";
        $result = $pdo->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data[0];
    }

    function encrypt($key, $data)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption = openssl_encrypt($data, $ciphering, $key, $options, $encryption_iv);

        return $encryption;
    }
   
    function decrypt($key, $encryption)
    {
        $ciphering = "AES-128-CTR";
        $options = 0;
        $decryption_iv = '1234567891011121';
        $decryption = openssl_decrypt ($encryption, $ciphering, $key, $options, $decryption_iv);
        
        return $decryption;
    }

    function insertUserAcc($userID, $app, $username, $pass)
    {
        $pdo = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $sql = "INSERT INTO userAcc (userID, application, username, password) VALUES ('$userID', '$app', '$username', '$pass')";
        $pdo->query($sql);
    }

    function userAccList($userID)
    {
        $pdo = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $sql = "SELECT id, application, username, password FROM userAcc WHERE userID='".$userID."'";
        $result = $pdo->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }
?>  