<?php

    require_once dirname(__FILE__) . '/DbConnect.php';
    // opening db connection
    $db = new DbConnect();
    $conn = $db->connect();
    $sql = "SELECT u.name, r.date, r.userScore, r.enemyScore FROM result r JOIN user u ON r.idUser=u.idUser ORDER BY r.date";
    if($result = mysqli_query($conn, $sql))
    {
        $resultArray = array();
        $tempArray = array();
        while ($row = $result->fetch_object())
        {
            $tempArray = $row;
            array_push($resultArray, $tempArray);
        
        }
        echo json_encode($resultArray);
    }
    mysqli_close($con);
    ?>	