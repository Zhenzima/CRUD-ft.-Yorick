<?php
   include('login.php');
   include ('includes/connect.php');
   
   ?>
<!DOCTYPE html>
<html lang="nl">
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
                  href="reizen.php">Vluchten</a></i>
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
      <div class="top-box" style="margin-bottom: 60px;">
         <div class="box-container reisinfo" style="height: auto; display: flex;">
            <div class="box1" style="width: 50%;">
               <?php
                  $sql = "SELECT * FROM reizen WHERE reisID=:term";
                  $stmt = $connect->prepare($sql);
                  $stmt->bindParam(":term", $_GET['id']);
                  $stmt->execute();
                  $result = $stmt->fetchAll();
                  foreach ($result as $value) {
                      ?>                         <img class="reisinformatieimage" src=<?php echo $value['foto']; ?>>
            </div>
            <div class="box2" style="width: 50%; margin-left: 20px;">
               <div class="insidebox1">
                  </a></span>
                  <h1 style="margin-bottom: 30px;">
                     <?php
                        echo $value['locatie'];
                        }
                        ?>
                  </h1>
               </div>
               <?php 
                  echo "Vliegen vanaf: " . $value['beginplek']; ?> <br> <?php 
                  echo "Vliegen naar: " . $value['eindplek']; ?> <br> <?php 
                  ?> <br> 
               <?php
                  echo "Kosten: €" . $value['kosten']; ?> <br> <?php 
                  echo "Retour: " .  $value['retour']; ?> <br> <?php 
                  echo "Startdatum: " . $value['startDatum']; ?> <br> <?php 
                  echo "Einddatum: " . $value['eindDatum']; ?> <br> <?php 
                  ?>              

                    <form class="searchdishpanel" name="search" method="post">
                     <?php if(isset($_SESSION['username'])) { ?>
                        <button name="search" class="reverabutton boekknop">Boeken</button>
                    <?php 
                  } else if (!isset($_SESSION['username'])) {
                     echo '<br> <b>Je moet ingelogd zijn om te boeken.</b>';
                  
                  }
                    ?>
                </form>
                
                <?php if (isset($_POST["search"])) {
                    $sql = "INSERT INTO `gebruikersboekingen` (`gebruikerID`, `boekingID`) VALUES (:gebruikerID, :boekingID);";
                    $stmt = $connect->prepare($sql);
                    $gebrID = $_SESSION['id'];
                    $stmt->bindParam(":gebruikerID",  $gebrID);
                    $stmt->bindParam(":boekingID",  $_GET['id']);
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    echo "<br>Boeking toevoegd voor " . $_SESSION['username'] . " <Br><a class=bekijk href=boekingen.php>Bekijk mijn boekingen</a>";
            
         }
                    ?>
                        

                </div>
                
         </div>
         <div class="recensies">
            <?php 
            if(isset($_SESSION['username'])) {
            ?>
                           <h1>Plaats een recensie</h1>
                            <p>Je kan ook een aantal sterren geven.</p>
                            <form class="plaatsRecensie" name="plaatsRecensie" method="post">
                            <input class="recensietitel" name="recensietitel" placeholder="Titel"></textarea>

                               </span> <textarea class="recensieinput" name="recensietext" placeholder="Typ hier je recensie"></textarea>
                              <div class="bottomright">
                                 <span>Hoeveel sterren zou je de reis geven? </span>
                                 <select name="rating">
                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                       <option value="4">4</option>
                                       <option value="5">5</option>
                                 </select>
                                 <button name="plaatsRecensie" class="reverabutton">Plaats</button>
                                 </div>
                            </form>
                            <?php 
            } else if (!isset($_SESSION['username'])) {
               echo '<b>Je moet inlogd zijn om een recensie te plaatsen.</b>';
            }
                            
                            ?>
                            
                            
                            
                            <h1>Wat vinden andere klanten?</h1>
                            <p>Vind hier recensies van anderen.</p>
                            <?php include('php/getrecensies.php')?>
     
                        </div>

      </div>
   
      </div>
      </div>
      <div class="footer">
         <footer id="site-footer">
            <section class="horizontal-footer-section" id="footer-middle-section">
               <div id="footer-about" class="footer-columns footer-columns-large">
                  <h1>Ons adress</h1>
                  <address>
                     <p><i class="fa-solid fa-location-dot"></i> 30/20, Heyendaal, Nijmegen, The Netherlands</p>
                     <p><i class="fa-solid fa-phone"></i> +31 6 13 26 34 33</p>
                     <p><i class="fa-solid fa-envelope-circle-check"></i> Revera@gmail.com</p>
                     <p><i class="fa-solid fa-clock"></i> 8:00 AM – 8:00 PM</p>
                  </address>
               </div>
               <div class="footer-columns">
                  <h1>Overzicht</h1>
                  <ul class="footer-column-menu" role="menu">
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="#" class="footer-column-menu-item-link">Services </a>
                     </li>
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="#" class="footer-column-menu-item-link">Pricing</a>
                     </li>
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="#" class="footer-column-menu-item-link">Portfolio</a>
                     </li>
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="#" class="footer-column-menu-item-link">News</a>
                     </li>
                  </ul>
               </div>
               <div class="footer-columns">
                  <h1>Bronnen</h1>
                  <ul class="footer-column-menu" role="menu">
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="#" class="footer-column-menu-item-link">FAQ</a>
                     </li>
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="#" class="footer-column-menu-item-link">Media</a>
                     </li>
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="#" class="footer-column-menu-item-link">Guides</a>
                     </li>
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="#" class="footer-column-menu-item-link">Free Resources</a>
                     </li>
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="#" class="footer-column-menu-item-link">Testimonials</a>
                     </li>
                  </ul>
               </div>
               <div class="footer-columns">
                  <h1>Informatie</h1>
                  <ul class="footer-column-menu" role="menu">
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="overons.php" class="footer-column-menu-item-link">Over ons</a>
                     </li>
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="termsofuse.php" class="footer-column-menu-item-link">Terms of Use</a>
                     </li>
                     <li class="footer-column-menu-item">
                        <a href="legalinformation.php" class="footer-column-menu-item-link" role="menuitem">Legal Information</a>
                     </li>
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="klantenservice.php" class="footer-column-menu-item-link">Stuur ons een
                        berichtje</a>
                     </li>
                     <li class="footer-column-menu-item" role="menuitem">
                        <a href="#" class="footer-column-menu-item-link">Laat feedback achter</a>
                     </li>
                  </ul>
               </div>
            </section>
            <section class="horizontal-footer-section" id="footer-bottom-section">
               <div id="footer-copyright-info">
                  &copy; ROC Nijmegen Inc. 2022. All rights reserved.
               </div>
               <div id="footer-social-buttons">
                  <img src="https://img.icons8.com/ios-filled/25/999999/facebook--v1.png" />
                  <img src="https://img.icons8.com/ios-filled/25/999999/telegram-app.png" />
                  <img src="https://img.icons8.com/ios-filled/25/999999/pinterest--v1.png" />
                  <img src="https://img.icons8.com/ios-filled/25/999999/instagram--v1.png" />
               </div>
            </section>
         </footer>
      </div>
   </body>
</html>
<script src="javascript/code.js"></script>