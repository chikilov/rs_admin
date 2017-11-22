<?php
    $connect = mysqli_connect('localhost', '<uid>', '<password>') or die('SQL server에 연결할 수 없습니다.');

    mysqli_select_db($connect, '<database_name>');
    //IF NOT EXISTS 옵션을 넣어 없을때만 테이블이 생성되도록 처리
    $sql = 'CREATE TABLE IF NOT EXISTS `score` ( `num` int NOT NULL AUTO_INCREMENT, `name` varchar(12), `sub1` int, `sub2` int, `sub3` int, `sub4` int, `sub5` int, `sum` int, `avg` int, PRIMARY KEY (`num`) ) ENGINE=`INNODB` ';
    $result = mysqli_query($connect, $sql);
?>