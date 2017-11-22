<?php
    //score table exists check
    require_once('./score.php');

    mysqli_select_db($connect, 'score');

    $objResult = array();
    $sql = 'SELECT * FROM score ';
    if ( isset($_GET['sort']) && array_key_exists('sort', $_GET) ) {
        if ( $_GET['sort'] === 'asc' || $_GET['sort'] === 'desc' ) {
            $sql .= 'ORDER BY sum '.$_GET['sort'];
        }
    }

    $result = mysqli_query($connect, $sql);
    if ( mysqli_num_rows($result) > 0 ) {
        while($row = mysqli_fetch_array($result)) {
            $objResult[] = $row;
        }
    }

    echo json_encode( $objResult, JSON_UNESCAPED_UNICODE );
?>