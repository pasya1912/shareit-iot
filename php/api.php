<?php
include 'koneksi.php';
//set timezone to Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');

//receive get request jarak

//make sure its number and not empty
if (isset( $_GET['jarak']) && is_numeric( $_GET['jarak']) && !empty( $_GET['jarak'])) {
    $jarak = $_GET['jarak'];

    //select jarak from history order by waktu
    $sql = "SELECT jarak FROM history ORDER BY waktu DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if(!$row) return;
    if($row['jarak'] == $jarak)
    {
        echo "same";
        return;
    }
    
    //save to database key jarak and value jarak if exist update
    $sql = "INSERT INTO setting (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = ?";
    //prepare statement
    $stmt = $conn->prepare($sql);
    $key = "jarak";
    //bind parameter
    $stmt->bind_param("sss", $key, $jarak, $jarak);
    //execute
    $stmt->execute();
    //close connection

    //if success echo success
    if($stmt){
        //insert into history jarak and waktu
        $sql = "INSERT INTO history (`jarak`, `waktu`) VALUES (?, NOW())";
        //prepare statement
        $stmts = $conn->prepare($sql);
        //bind parameter
        $stmts->bind_param("s", $jarak);
        //execute
        $stmts->execute();
        //close connection
        echo "success";
        $stmts->close();

    }else{
        echo "failed";
    }
    $stmt->close();
}
