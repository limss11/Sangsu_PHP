# TableBoard_Shop
게시판-Shop 의 TODO 완성하기!

## 기존 파일
```
 .
├── css - board_form.php와 index.php 에서 사용하는 stylesheet
│   └── ...
├── fonts - 폰트
│   └── ...
├── images - 아이콘 이미지
│   └── ...
├── vender - 외부 라이브러리
│   └── ...
├── js - board_form.php와 index.php 에서 사용하는 javascript
│   └── ...
├── function
│   └── insert.php - 게시글 작성 기능 구현
│   └── update.php - 게시글 수정 기능 구현
│   └── delete.php - 게시글 삭제 기능 구현
├── board_form.php - 게시글 작성/수정 시 사용하는 form이 포함된 php 파일
├── index.php - 게시글 조회 기능 구현
```

## MySQL 테이블 생성!

create table tableboard_shop(
num int not null,
date date,
order_id int,
name char(20),
price int,
quantity int,
primary key(num)
);

Note: 
- table 이름은 tableboard_shop 으로 생성
- 기본키는 num 으로, 그 외의 속성은 board_form.php 의 input 태그 name 에 표시된 속성 이름으로 생성
- 각 속성의 type 은 자유롭게 설정 (단, 입력되는 값의 타입과 일치해야 함)
    - ex) price -> int
    - ex) name -> char or varchar
    
## index.php 수정
[여기에 index.php 를 어떻게 수정했는지, 설명을 작성하세요.]


    $connect = mysql_connect("localhost","lss","6295");
    $db_con = mysql_select_db("lss_db", $connect);
    $sql = "select * from tableboard_shop;";
    $result = mysql_query ($sql, $connect);
db 연동 코드 작성

    while ( $row = mysql_fetch_array($result))
                    {
                        $total = $row[price] * $row[quantity];
                     
                        echo "
                          <tr onclick=\"location.href = ('board_form.php?num=$row[num]')\">
                             <td class=\"column1\"> $row[date] </td>
                             <td class=\"column2\"> $row[order_id] </td>
                             <td class=\"column3\"> $row[name] </td>
                             <td class=\"column4\"> $$row[price] </td>
                             <td class=\"column5\"> $row[quantity] </td>
                             <td class=\"column6\"> $total</td>
                           </tr>
                           ";
                    }

                    mysql_close();
기존 표 모델과 같은 형식으로 데이터베이스에서 값을 읽어와서 표를 작성하는 코드

 기 작성된 html 코드는 주석처리함
## board_form.php 수정
[여기에 board_form.php를 어떻게 수정했는지, 설명을 작성하세요.]

    $connect = mysql_connect("localhost","lss","6295");
             $db_con = mysql_select_db("lss_db", $connect);
             $sql = "select * from tableboard_shop where num = '$_GET[num]';";
             $result = mysql_query ($sql, $connect);
         
         if(isset($_GET[num])) {
            $row = mysql_fetch_array($result);
            $total = $row[price]*$row[quantity];
         }
DB연결 후 $_GET[num]으로 num에 해당하는 row를 가져오도록 sql을 설정한 후 mysql_fetch_array을 사용, $row에 저장함.

    <td class="column1"> <input name="date" type="text" value="<? echo $row[date]; ?>" /> </td>
                          <td class="column2"> <input name="order_id" type="number" value="<? echo $row[order_id]; ?>" /> </td>
                          <td class="column3"> <input name="name" type="text" value="<?  echo $row[name]; ?>" /> </td>
                          <td class="column4"> <input name="price" type="number" placeholder="$" style="text-align: right;" value="<? echo $row[price]; ?>" /> </td>
                          <td class="column5"> <input name="quantity" type="number" value="<? echo $row[quantity]; ?>" style="text-align: right;" /> </td>
                          <td class="column6"> $<span id="total"> <? echo $total; ?> </span> </td> 
                          
$row에 저장된 값들을 자리에 맞게 echo문을 써서 화면에 표시함
## function
### insert.php 수정
[여기에 insert.php 를 어떻게 수정했는지, 설명을 작성하세요.]

    $connect = mysql_connect("localhost","lss","6295");
    $db_con = mysql_select_db("lss_db", $connect);
    $sql = "insert into tableboard_shop(date, order_id, name, price, quantity) 
                  values ('$_POST[date]', '$_POST[order_id]','$_POST[name]', '$_POST[price]', '$_POST[quantity]');";
    $result = mysql_query ($sql, $connect);
    
    
    # 참고 : 에러 메시지 출력 방법
    if(!$result) {
        echo "<script> alert('insert - error message') </script>";
    }
    
DB 연결 후 sql문을 DB에 삽입하는 구문을 사용, values에 POST로 받은 값들을 지정하였다.

if(!$result)로 insert가 제대로 되지 않았을 경우 기 작성되있던 에러메세지를 출력하게 하였다.
### update.php 수정
[여기에 update.php 를 어떻게 수정했는지, 설명을 작성하세요.]

    $connect = mysql_connect("localhost","lss","6295");
    $db_con = mysql_select_db("lss_db", $connect);
    $sql = "update tableboard_shop set date 
              = '$_POST[date]', order_id = '$_POST[order_id]', name = '$_POST[name]', price = '$_POST[price]', quantity = '$_POST[quantity]' where num = $_GET[num]";
    
    $result = mysql_query ($sql, $connect);
    
    
    # 참고 : 에러 메시지 출력 방법
    if(!$result) {
        echo "<script> alert('update - error message') </script>";
    }
    
DB 연결 후 sql문을 update ... set을 사용하여 기존 값들을 POST로 받은 값으로 update하게 하였다.
### delete.php 수정
[여기에 delete.php 를 어떻게 수정했는지, 설명을 작성하세요.]

    $connect = mysql_connect("localhost","lss","6295");
    $db_con = mysql_select_db("lss_db", $connect);
    $sql = "delete  from tableboard_shop where num = '$_GET[num]';";
    $result = mysql_query ($sql, $connect);
    
    
    if(!$result){
        echo "<script> alert('delete - error message') </script>";
    }

DB 연결 후 SQL문을 delete from 을 사용하여 $_GET[num]으로 받은 num에 해당하는 열을 지우도록 코드를 작성하였다.