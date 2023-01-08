<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
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
        #red
        {

        }
    </style>
</head>
<body>

    <?php
        session_start();
        //check if user is logged in already
        if (isset($_SESSION["loggedin"]) && $_SESSION === true)
        {
            header("Location: ../index.php");
            exit;
        }

        require_once("../Setup/functions.php");

        $email = $pass = "";
        $emailErr = $passErr = $loginErr = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            //verify username
            $x = 0;
            do 
            {

          
                if (empty($_POST["email"]))
                {
                    $emailErr = "Please enter an email adress";
                    break;
                }

                else if (check_email_exist($_POST["email"]) === false)
                {
                    $emailErr = "Your email adress is not registered under one of our accounts";
                    break;
                }

                else 
                {
                    $email = $_POST["email"];
                }

                //verify password exists

                if (empty($_POST["pass"]))
                {
                    $passErr = "Please enter a password";
                    break;
                }

                else 
                {
                    $pass = $_POST["pass"];
                }

                //verify if password matches email adress
                // $loginErr = verifyAccount($email, $pass);

                $passDB = fetchPass($email);
                if (passVerify($pass, $passDB) === true)
                {
                    session_start();
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $email; 
                    $_SESSION["key"] = hash("sha1", $pass);
                    $x = 1;
                    header("location: ../index.php");
                }

                else
                {
                    $passErr = "Your password is incorrect";
                    break;
                }
            } 
            while ($x = 0);
        }
    ?>


    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col bg-danger justify-content-center" id="red">
                <br><br><br>
                <h1 class="text-light"> <i class="bi bi-lock-fill"></i>RedLock...</h1>
                <br><br>
                <h3 class="text-light">Your very own simple, secure, clean password manager</h3>
                <h4 class="text-light">Store all your passwords safely with one master key 🔑</i></h4>
            </div>

            <div class="col">
                <div class="login-form p-4 m-4 align-center">
                    <h3>Login into <i class="bi bi-lock-fill"></i> RedLock</h3>
                    <?php 
                        if(!empty($login_err))
                        {
                            echo '<div class="alert alert-danger">' . $loginErr . '</div>';
                        }        
                    ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control w-75" id="email" name="email" value="example@gmail.com">
                            <p class="error"> <?php echo $emailErr;?> </p>
                        </div>
                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="password" class="form-control w-75" id="pass" name="pass">
                            <p class="error"> <?php echo $passErr;?> </p>
                        </div>
                        <button type="submit" class="btn btn-secondary my-3">Submit</button>
                    </form>
                    <p>Don't have an account yet?</p>
                    <a href="register.php">Create One</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>
</html>
