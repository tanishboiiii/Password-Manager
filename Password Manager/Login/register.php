<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Account</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
        .error 
        {
            color: red;
        }

        html,body 
        {
            height: 100%;
        }

/*        #myform 
        {
            width:800px; 
            margin:0 
            auto;
        }*/
    </style>

</head>
<body class=" bg-">
 
    <?php
    require("../Setup/functions.php");
    // define variables and set to empty values
    $nameErr = $emailErr = $passErr = "";
    $name = $email = $pass ="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (empty($_POST["name"])) 
        {
            
            $nameErr = "Name is required";
        } 
        else 
        {
            $name = test_input($_POST["name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) 
            {
            $nameErr = "Only letters and white space allowed";
            }
        }
    
        //email verify
        if (empty($_POST["email"])) 
        {
            $emailErr = "Email is required";
        } 

        //check for database
        else if(check_email_exist($_POST["email"]))
        {
            $emailErr = "Email Account Already Registerd";
        }
        else 
        {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
            $emailErr = "Invalid email format";
            }

        }

        //password verify
        if(empty(trim($_POST["pass"])))
        {
            $passErr= "Please enter a password.";     
        }
        elseif(strlen(trim($_POST["pass"])) < 6)
        {
            $passErr = "Password must have atleast 6 characters.";
        } 
        else
        {
            $pass = trim($_POST["pass"]);
        }

        //insert user info into database

        if (empty($nameErr) && empty($emailErr) && empty($passErr))
        {
            insertUser($name, $email, $pass);
            header("Location: login.php");
        }


    }

    ?>

    <div class="container-fluid h-100 bg-light" id="myForm">
        <div class="row h-100">
            <div class="col bg-danger justify-content-center" id="red">
                <br><br><br>
                <h1 class="text-light"> <i class="bi bi-lock-fill"></i>RedLock...</h1>
                <br><br>
                <h3 class="text-light">Your very own simple, secure, clean password manager</h3>
                <h4 class="text-light">Store all your passwords safely with one master key 🔑</i></h4>
            </div>
        <div class="col">
                
                    <h3>Create Account</h3>
                    <form method="post">
                        <div class="form-group">
                            <label for="text">Full-Name</label>
                            <input type="text" class="form-control w-50" id="name" name="name" value="<?php echo $name;?>">
                            <p class="error"> <?php echo $nameErr;?> </p>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control w-50" id="email" name="email" value="<?php echo $email;?>">
                            <p class="error"> <?php echo $emailErr;?> </p>

                        </div>
                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="password" class="form-control w-50" id="pass" name="pass">
                            <p class="error"> <?php echo $passErr;?> </p>

                        </div>
                        <button type="submit" class="btn btn-primary my-3" ">Register Now</button>
                    </form>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>
</html>

<!-- 
    - grab user input
    - check if account exists
    - commit to database with password hash
-->

<!-- Array ( [name] => Quandale Dingle [email] => example@gmail.com [pass] => sdfsdf ) 1 -->