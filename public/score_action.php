<?php
    //score table exists check
    require_once('./score.php');

    mysqli_select_db($connect, 'score');
    if ( $_POST['type'] === 'insert' ) {
        $sql = 'INSERT INTO `score` ( `name`, `sub1`, `sub2`, `sub3`, `sub4`, `sub5`, `sum`, `avg` ) value ( \'';
        $sql .= $_POST['str_name'].'\', ';
        $sql .= $_POST['int_sub1'].', ';
        $sql .= $_POST['int_sub2'].', ';
        $sql .= $_POST['int_sub3'].', ';
        $sql .= $_POST['int_sub4'].', ';
        $sql .= $_POST['int_sub5'].', ';
        $sql .= ( $_POST['int_sub1'] + $_POST['int_sub2'] + $_POST['int_sub3'] + $_POST['int_sub4'] + $_POST['int_sub5'] ).', ';
        $sql .= ( ( $_POST['int_sub1'] + $_POST['int_sub2'] + $_POST['int_sub3'] + $_POST['int_sub4'] + $_POST['int_sub5'] ) / 5 ).' ) ';
    } else if ( $_POST['type'] === 'delete' ) {
        $sql = 'DELETE FROM `score` WHERE num = '.$_POST['num'];
    }
    $result = mysqli_query($connect, $sql);
    var_export($result);
?>