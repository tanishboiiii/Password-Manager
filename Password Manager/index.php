<!DOCTYPE html>
<html>
  <head>
    <title></title>
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
        </style>
    </head>

  <body>

    <nav class="navbar navbar-expand-sm navbar-light bg-danger">
      <div class="container-fluid ">
        <a class="navbar-brand" href="#" style=" color: white;"><i class="bi bi-lock-fill"></i> Red Lock</a>
        <a class="navbar-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" style=" color: white;">Add Account</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav ">
            <li class="nav-item">
              <a class="nav-link active" href="Login/logout.php" style=" color: white;"><i class="bi bi-box-arrow-right" style="font-size: 20px;"></i> Logout</a>
            </li>
          </ul>		  
        </div>
      </div>
	  </nav>




      <div class="container">
        <?php
            require("Setup/functions.php");
            session_start();
            if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
            {
                header("location: Login/login.php");
                exit;
            }
            $userData = fetchUserByEmail($_SESSION["username"]);
            $userId = $userData["id"];
            $name = $userData["name"];
            $email = $userData["email"];
            $key = $_SESSION["key"];
            
            $app = $userName = $pass = "";
            $appErr = $userErr = $passErr = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if (empty($_POST["application"]))
                {
                  $appErr = "Please enter an application name";
                }
                else
                {
                  $app = $_POST["application"];
                  $app = encrypt($key, $app);
                }

                if (empty($_POST["username"]))
                {
                  $userErr = "Please enter a username";
                }
                else
                {
                  $username = $_POST["username"];
                  $username = encrypt($key, $username);
                }

                if (empty($_POST["pass"]))
                {
                  $passErr = "Please enter a password";
                }
                else
                {
                  $pass = $_POST["pass"];
                  $pass = encrypt($key, $pass);
                }
            }
        ?>
      
      <div id="addAccErr">
            <?php
              if ($_SERVER["REQUEST_METHOD"] == "POST")
              {
                if ($appErr == "" && $userErr == "" && $passErr == "")                      
                {
                    insertUserAcc($userId, $app, $username, $pass);
                }

                else 
                {
                  echo "<br>";
                  echo "<h3>Add Account Errors:</h3>";
                  echo '<p class="error">'.$appErr."</p>";
                  echo '<p class="error">'.$userErr."</p>";
                  echo '<p class="error">'.$passErr."</p>";
                  echo '<button type="button" class="btn btn-primary" onclick="clearErr()">Clear Error Log</button>';
                }
              }
            ?>
      </div>
      
      <div id="table">
        <table class="table">
          <thead>
              <tr>
              <th scope="col">Application</th>
              <th scope="col">Username</th>
              <th scope="col">Password</th>
              <th scope="col">Delete</th>
              </tr>
          </thead>
          <tbody>

          <?php
            $userAccList = userAccList($userId);            
            echo "<br>";
            echo "<h1>My Accounts:</h1>";
            echo "<br>";

            foreach ($userAccList as $value)
            {
                $value["application"] = decrypt($key, $value["application"]);
                $value["username"] = decrypt($key, $value["username"]);
                $value["password"] = decrypt($key, $value["password"]);
                echo "<tr>";
                  echo "<td>".$value["application"]."</td>";
                  echo "<td>".$value["username"]."</td>";
                  echo "<td>".$value["password"]."</td>";
                  echo '<td><button type="button" class="btn btn-danger"><i class="bi bi-trash3"></i> Delete</button></td>';

                echo "</tr>";
            }
            
        ?>
        </tbody>

        <table>
      </div>

    <!-- Modal -->
    <div class="modal" id = "exampleModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Account</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
      <div class="modal-body">
            <div class="login-form align-center">
              
              <form method="post">
                  <div class="form-group">
                      <label for="application">Application</label>
                      <input type="text" class="form-control w-75" id="application" name="application">
                  </div>

                  <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control w-75" id="username" name="username">
                  </div>
                  <div class="form-group">
                      <label for="pass">Password</label>
                      <input type="password" class="form-control w-75" id="pass" name="pass">
                  </div>
                  <button type="submit" class="btn btn-primary my-3">Submit</button>
              </form>
            </div>
        </div>

        
        </div>
      </div>
</div>
</div>
      
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
     <script type="text/javascript">
        function clearErr() 
        {
          console.log("hello");
          document.getElementById("addAccErr").innerHTML= "";
        }
     </script>
  </body>
</html>