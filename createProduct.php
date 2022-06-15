<?php
    include 'includes/connect.php';

    if(isset($_POST['add_product'])){
        $hotel = $_POST['hotel'];
        $kosten = $_POST['kosten'];
        $locatie = $_POST['locatie'];
        $startDatum = $_POST['startDatum'];
        $eindDatum = $_POST['eindDatum'];
        $regio = $_POST['regio'];
        $beginplek = $_POST['beginplek'];
        $eindplek = $_POST['eindplek'];

        if(empty($kosten) || empty($locatie) || empty($regio)){
            header('Location: adminpage.php');
            exit();
        }else{
            $sql = "INSERT INTO reizen(hotel, kosten, locatie, startDatum, eindDatum, beginplek, eindplek, regio) VALUES (:hotel, :kosten, :locatie, :startDatum, :eindDatum, :beginplek, :eindplek, :regio)";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':hotel', $hotel);
            $stmt->bindParam(':kosten', $kosten);
            $stmt->bindParam(':locatie', $locatie);
            $stmt->bindParam(':startDatum', $startDatum);
            $stmt->bindParam(':eindDatum', $eindDatum);
            $stmt->bindParam(':beginplek', $beginplek);
            $stmt->bindParam(':eindplek', $eindplek);
            $stmt->bindParam(':regio', $regio);
            $stmt->execute();

    
            header('Location: adminpage.php');
            exit();
        }

    } else {
        header('Location: ../login.php');
        exit();
    }
?>