<?php
    //score table exists check
    require_once('./score.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8" />
        <!-- 스크립트 작성이 용이하도록 jquery 라이브러리를 사용 -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript">
            // 아래쪽 테이블 데이터를 ajax를 통하여 score_listget.php 파일에서 가져오도록 구현한 함수
            // sort값이 있을 경우 정렬을 sort 값에 맞추어 가져오도록 정의
            function getList(sort) {
                $.get( './score_listget.php?sort=' + sort ).done( function ( data ) {
                    var objData = JSON.parse(data);
                    var strAppend;
                    for ( var i = 0; i < objData.length; i++ ) {
                        strAppend += '<tr>';
                        strAppend += '<td>' + objData[i].num + '</td>';
                        strAppend += '<td>' + objData[i].name + '</td>';
                        strAppend += '<td>' + objData[i].sub1 + '</td>';
                        strAppend += '<td>' + objData[i].sub2 + '</td>';
                        strAppend += '<td>' + objData[i].sub3 + '</td>';
                        strAppend += '<td>' + objData[i].sub4 + '</td>';
                        strAppend += '<td>' + objData[i].sub5 + '</td>';
                        strAppend += '<td>' + objData[i].sum + '</td>';
                        strAppend += '<td>' + objData[i].avg + '</td>';
                        strAppend += '<td><input type="button" class="btnDel" data-num="' + objData[i].num + '" value="삭제하기" /></td>';
                        strAppend += '</tr>';
                    }
                    $('#listTable > tbody').html(strAppend);
                });
            }

            // 페이지 로딩시 발동되는 함수
            $(document).ready(function () {
                // 아래쪽 테이블 리스트 초기화
                getList('');

                // 입력버튼 클릭시 데이터 validation check 하고 ajax를 통하여 전달 및 디비 입력 처리
                $(document).on('click', 'input[name=btnInput]', function () {
                    if ( $('input[name=str_name]').val() === '' || $('input[name=str_name]').val() === null ) {
                        alert( '이름을 입력하세요.' );
                    } else if ( $('input[name=int_sub1]').val() === '' || $('input[name=int_sub1]').val() === null ) {
                        alert( '과목1의 점수를 입력하세요.' );
                    } else if ( $('input[name=int_sub2]').val() === '' || $('input[name=int_sub2]').val() === null ) {
                        alert( '과목2의 점수를 입력하세요.' );
                    } else if ( $('input[name=int_sub3]').val() === '' || $('input[name=int_sub3]').val() === null ) {
                        alert( '과목3의 점수를 입력하세요.' );
                    } else if ( $('input[name=int_sub4]').val() === '' || $('input[name=int_sub4]').val() === null ) {
                        alert( '과목4의 점수를 입력하세요.' );
                    } else if ( $('input[name=int_sub5]').val() === '' || $('input[name=int_sub5]').val() === null ) {
                        alert( '과목5의 점수를 입력하세요.' );
                    } else {
                        $.post( './score_action.php', $('#frmInput').serialize() ).done( function( data ) {
                            if ( data === 'true' ) {
                                // 입력후 경고창 띄우고, 새로고침이 아니므로 폼을 리셋하고, 리스트를 갱신
                                alert( '입력이 완료되었습니다.' );
                                $('#frmInput')[0].reset();
                                getList('');
                            } else {
                                alert( '오류가 발생하였습니다.' );
                            }
                        } );
                    }
                });

                $(document).on('click', 'input.btnDel', function () {
                    $.post( './score_action.php', {'type':'delete', 'num':$(this).data('num')} ).done( function( data ) {
                        if ( data === 'true' ) {
                            // 삭제후 경고창 띄우고, 리스트를 갱신
                            alert( '삭제가 완료되었습니다.' );
                            getList('');
                        } else {
                            alert( 'error' );
                        }
                    } );
                });
            });
        </script>
    </head>
    <body>
        <div>
            <h4>1) 성적 입력 하기</h4>
            <form id="frmInput">
                <input type="hidden" name="type" value="insert" />
                <table border="1">
                    <tr>
                        <td>
                            이름 : <input type="text" name="str_name" style="width:60px;" />&nbsp;
                            과목1 : <input type="text" name="int_sub1" style="width:40px;" />&nbsp;
                            과목2 : <input type="text" name="int_sub2" style="width:40px;" />&nbsp;
                            과목3 : <input type="text" name="int_sub3" style="width:40px;" />&nbsp;
                            과목4 : <input type="text" name="int_sub4" style="width:40px;" />&nbsp;
                            과목5 : <input type="text" name="int_sub5" style="width:40px;" />&nbsp;
                        </td>
                        <td>
                            <input type="button" name="btnInput" value="입력하기" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div>
            <h4>2) 성적 출력 하기</h4>
            <a href="javascript:getList('asc');">[성적순 정렬]</a>&nbsp;<a href="javascript:getList('desc');">[성적역순 정렬]</a>
            <table id="listTable" border="1">
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>이름</th>
                        <th>과목1</th>
                        <th>과목2</th>
                        <th>과목3</th>
                        <th>과목4</th>
                        <th>과목5</th>
                        <th>합계</th>
                        <th>평균</th>
                        <th>삭제</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </body>
</html>