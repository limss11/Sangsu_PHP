<?php
/**
 * Created by PhpStorm.
 * User: kim2
 * Date: 2019-04-04
 * Time: 오전 9:39
 */

# TODO: MySQL DB에서, num에 해당하는 레코드 삭제하기!
$connect = mysql_connect("localhost","lss","6295");
$db_con = mysql_select_db("lss_db", $connect);
$sql = "delete  from tableboard_shop where num = '$_GET[num]';";
$result = mysql_query ($sql, $connect);


if(!$result){
    echo "<script> alert('delete - error message') </script>";
}


?>

<script>
    location.replace('../index.php');
</script>
