<?php
// Initialize the session
session_start();

// Include config file
require_once "includes/connect.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT gebruikerID, username, password FROM gebruikers WHERE username = ?";
        $link = mysqli_connect($host, $user, $pass, $db);
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    $link = mysqli_connect($host, $user, $pass, $db);
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
    

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://kit.fontawesome.com/cfd87a559f.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sccs/test.scss">
    <title>Revera.com</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
</head>

<body>
    <header class="main-header">
        <nav class="header-top">
            <div class="header-left">
                <a href="index.php">
                    <img class="header-image" src="images/logo.png">
                </a>
            </div>
            <div class="header-right">
                <div class="header-group-item"><a href="reizen.php">Bestemmingen</a></div>
                <div class="header-group-item"><a href="klantenservice.php">Klantenservice</a></div>
                <div class="header-group-item"><a href="index.php">Home</a></div>

                <div class="header-group-item login marginleft"><?php
                include('includes/connect.php'); // Includes Login Script
                if(isset($_SESSION['username']))
                echo "<a href='accountsettings.php'>" . $_SESSION['username'] . "</a>";
            else
                echo '<a class="catolag-list-items" onclick="openForm()">Login</a>';
                ?> </div>
                <div class="header-group-item login"><?php
                include('includes/connect.php'); // Includes Login Script
                if(isset($_SESSION['username']))
                echo "<a style='display:none'>" . $_SESSION['username'] . "</a>";
            else
                echo '<a class="catolag-list-items" href="register.php">Register</a>';
                ?></div>

            </div>
        </nav>

        <nav class="header-bottom">

            <ul class="header-bottom-box">
                <li class="header-bottom-item"><i class="fa-solid fa-bed"></i><a href="index.php">Hotels</a>
                </li>
                <li class="header-bottom-item "><i class="fa-solid fa-plane-departure"></i><a
                        href="vluchten.php">Vluchten</a></i>
                <li class="header-bottom-item"><i class="fa-solid fa-car"></i><a href="autoverhuur.php">Autoverhuur</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="form-popup" id="myForm">
    <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="login-box">
                <h1>Login</h1>
                <div class="progress">
                    <div class="progress-value"></div>
                </div>

                <div class="textbox">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>

                <div class="textbox">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    <input type="password" placeholder="Password" name="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
                <input class="button" type="submit" name="login" value="Sign In">
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </div>
        </form>
    </div>
    <div class="top-box">
        <div class="box-container">
            <div class="box-title">
                <h1>Populaire vliegmaatschapijen</h1>
            </div>
            <ul class="locations-container2" id="scrollbarlijstauto">
                <li class="autolijst">
                    <div class="autoverhuurlogos">
                        <img  src="https://i0.wp.com/insideflyer.nl/wp-content/uploads/2019/05/KLM-logo.png?ssl=1">
                    </div>
                </li>
                <li class="autolijst">
                    <div class="autoverhuurlogos">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4d/Ryanair_logo_new.svg/1024px-Ryanair_logo_new.svg.png" style="width: 150px; height: 30px; margin-top: 10px;">
                    </div>
                </li>
                <li class="autolijst">
                    <div class="autoverhuurlogos">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/EasyJet_logo.svg/1280px-EasyJet_logo.svg.png" style="width: 150px; height: 30px; margin-top: 10px;">
                    </div>
                </li>
                <li class="autolijst">
                    <div class="autoverhuurlogos">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/TUI_Logo_2016.svg/2560px-TUI_Logo_2016.svg.png">
                    </div>
                </li>
                <li class="autolijst">
                    <div class="autoverhuurlogos">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/Lufthansa_Logo_2018.svg/1280px-Lufthansa_Logo_2018.svg.png" style="width: 150px; height: 30px; margin-top: 10px;">
                    </div>
                </li>
                <li class="autolijst">
                    <div class="autoverhuurlogos">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Transavia_logo.svg/2560px-Transavia_logo.svg.png" style="width: 150px; height: 30px; margin-top: 10px;">
                    </div>
                </li>
                

            </ul>
        </div>
    <div class="stays-all">
        <div class="stays">
            <div class="popular-stays">
                <div class="sugg">
                    <img src="https://i.ibb.co/pK6TVYR/losangeles.png" alt="LA" style="width:100%">
                    <p>Los Angeles, USA</p>
                </div>
                <div class="sugg">
                    <img src="https://i.ibb.co/pK6TVYR/losangeles.png" alt="LA" style="width:100%">
                    <p>Los Angeles, USA</p>
                </div>
                <div class="sugg">
                    <img src="https://i.ibb.co/pK6TVYR/losangeles.png" alt="LA" style="width:100%">
                    <p>Los Angeles, USA</p>
                </div>
                <div class="sugg">
                    <img src="https://i.ibb.co/pK6TVYR/losangeles.png" alt="LA" style="width:100%">
                    <p>Los Angeles, USA</p>
                </div>
                <div class="sugg">
                    <img src="https://i.ibb.co/pK6TVYR/losangeles.png" alt="LA" style="width:100%">
                    <p>Los Angeles, USA</p>
                </div>
            </div>
            <div class="stays2">
                <div class="left">
                    <p>Zoeken op locatie</p>
                    <div class="left-search">
                        <input class="reverainput" id="name" placeholder="Locatie of omgeving"> <button
                            class="reverabutton" id="send">Zoek</button>
                    </div>
                    <ul class="locationslist">
                        <li class="region"> <a>Amerika</a> </li>
                        <li> <a>Los Angeles</a> </li>
                        <li> <a>Las Vegas</a> </li>
                        <li> <a>Washington</a> </li>
                        <li class="region"> <a>Spanje</a> </li>
                        <li> <a>Sevilla</a> </li>
                        <li> <a>Barcelona</a> </li>
                        <li> <a>Madrid</a> </li>
                        <li> <a>Valencia</a> </li>
                        <li class="region"> <a>Griekenland</a> </li>
                        <li> <a>Athene</a> </li>
                        <li> <a>Rhodos</a> </li>
                        <li> <a>Patras</a> </li>
                        <li> <a>Kos</a> </li>
                        </li>
                    </ul>
                </div>
                <div class="right">
                <?php include('php/reizen.php'); ?> 
                </div>
            </div>
</body>

</html>
<script src="javascript/code.js"></script>