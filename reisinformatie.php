<!DOCTYPE html>
<html lang="nl">
    <?php include ('includes/connect.php');?>

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
                <img class="header-image" href="index.php" src="images/logo.png">
            </div>
            <div class="header-right">
                <div class="header-group-item"><a href="verblijven.html">Bestemmingen</a></div>
                <div class="header-group-item"><a href="klantenservice.html"><b>Klantenservice</b></a></div>
                <div class="header-group-item"><a href="index.php">Home</a></div>

                <div class="header-group-item login marginleft"><a onclick="openForm()">Login</a></div>
                <div class="header-group-item login"><a onclick="openForm()">Register</a></div>

            </div>
        </nav>
        <nav class="header-bottom">
            <ul class="header-bottom-box">
                <li class="header-bottom-item "><i class="fa-solid fa-bed"></i><a href="index.php">Hotels</a></li>
                <li class="header-bottom-item "><i class="fa-solid fa-plane-departure"></i><a href="#">Vluchten</a></i>
                <li class="header-bottom-item"><i class="fa-solid fa-car"></i><a href="autoverhuur.html">Autoverhuur</a>
                </li>
            </ul>
        </nav>
    </header>
    

    <div class="form-popup" id="myForm">
        <form action="validate.php" method="post">
            <div class="login-box">
                <h1>Login</h1>
                <div class="progress">
                    <div class="progress-value"></div>
                </div>

                <div class="textbox">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <input type="text" placeholder="Username" name="adminname" value="">
                </div>

                <div class="textbox">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    <input type="password" placeholder="Password" name="password" value="">
                </div>

                <input class="button" type="submit" name="login" value="Sign In">
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </div>
        </form>
    </div>
    <div class="top-box" style="margin-bottom: 60px;">
        <div class="box-container" style="height: 400px; display: flex;">
            <div class="box1" style="width: 50%;">
                <div class="reisinformatieimage"><img src=""></div>
            </div>
            <div class="box2" style="width: 50%; margin-left: 20px;">
                <div class="insidebox1">
                    <span class="card__by">by <a href="#" class="card__author" title="author">D-reizen
                        </a></span>
                    <h1 style="margin-bottom: 30px;">
                    <?php
                            $sql = "SELECT * FROM reizen WHERE reisID=:term";
                            $stmt = $connect->prepare($sql);
                            $stmt->bindParam(":term", $_GET['id']);
                            $stmt->execute();
                            $result = $stmt->fetchAll();
                            foreach ($result as $value) {
                                echo $value['locatie'];
                            }
                    ?>
                </h1>
                        </div>
                <?php 
                echo "Vliegen vanaf: " . $value['beginplek']; ?> <br> <?php 
                echo "Vliegen naar: " . $value['eindplek']; ?> <br> <?php 

                echo "Kosten: €" . $value['kosten']; ?> <br> <?php 
                echo "Retour: " .  $value['retour']; ?> <br> <?php 
                echo "Startdatum: " . $value['startDatum']; ?> <br> <?php 
                echo "Einddatum: " . $value['eindDatum']; ?> <br> <?php 

                ?>              
                
                <div class="insidebox2" style="display: flex; height: 40px; margin-bottom: 100px;">
                    <div class="rate">
                        <input type="radio" id="star5" name="rate" value="5" />
                        <label for="star5" title="text">5 stars</label>
                        <input type="radio" id="star4" name="rate" value="4" />
                        <label for="star4" title="text">4 stars</label>
                        <input type="radio" id="star3" name="rate" value="3" />
                        <label for="star3" title="text">3 stars</label>
                        <input type="radio" id="star2" name="rate" value="2" />
                        <label for="star2" title="text">2 stars</label>
                        <input type="radio" id="star1" name="rate" value="1" />
                        <label for="star1" title="text">1 star</label>
                    </div>
                </div>
                <div class="insidebox2" style="display: flex; height: 40px; margin-bottom: 100px;">
                    <div class="boeken" style="width: 200px;"><a style="color: white;">Boek nu</a></div>
                </div>
            </div>
        </div>
  
        <div class="box-container" style="border-top-style: hidden;">
            <a style="margin-top: 10px; font-size: 30px;">Selecteer data om prijzen en beschikbaarheid te zien (kan
                inclusief Genius-prijzen zijn)</a>
        </div>
    </div>
    </div>
    <div class="footer">
        <footer id="site-footer">
            <section class="horizontal-footer-section" id="footer-middle-section">
                <div id="footer-about" class="footer-columns footer-columns-large">
                    <h1>Ons adress</h1>
                    <address>
                        <p><i class="fa-solid fa-location-dot"></i> 30/20, Verkhy street, Moscow, Russia</p>
                        <p><i class="fa-solid fa-phone"></i> 7 (800) 555–35–35</p>
                        <p><i class="fa-solid fa-envelope-circle-check"></i> noreply@reply.io</p>
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
                            <a href="#" class="footer-column-menu-item-link">Over ons</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="#" class="footer-column-menu-item-link">Terms of Use</a>
                        </li>
                        <li class="footer-column-menu-item">
                            <a href="#" class="footer-column-menu-item-link" role="menuitem">Legal Information</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="klantenservice.html" class="footer-column-menu-item-link">Stuur ons een
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