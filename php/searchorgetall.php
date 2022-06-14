<?php
if (isset($_POST["search"])) {
            $sql = "SELECT * FROM reizen WHERE locatie=:term";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(":term", $_POST['term']);
            $stmt->execute();
            $result = $stmt->fetchAll();
            echo "Resultaten voor zoekactie: ";
            foreach ($result as $value) {
            ?>  



                    <div class="stay-item">
                        <img src=<?php echo $value['foto']; ?>>

                        <div class="stay-info">
                        <div class="stay-info-left">

                            <h1><?php echo $value['locatie']; ?></h1>
                            <p>Kosten: €<?php echo $value['kosten']; ?></p>
                            <p>Vanaf vliegveld: <?php echo $value['beginplek']; ?></p>
                            <p>Naar vliegveld: <?php echo $value['eindplek']; ?></p>
                            </div>
                            <div class="stay-info-right">
                            
                            <?php 
                            if ($value['retour'] == 1)  
                               echo "Retour: Ja <br>" . "Startdatum: " . $value['startDatum'] . "<br>" . "Einddatum: " . $value['eindDatum'];
                            else    
                               echo "Retour: Nee <br>" . "Startdatum: " . $value['startDatum'] 
                            ?>

                            </div>

                        </div>
                    </div>
                 <?php
            }
                
                
            
} else {
    include_once ('php/getreizen.php');
}
?>