<?php

session_start();
require_once 'connect.php';

function logout()
{
    header("Location: index.php");
    session_destroy();
  
}

function login()
{
    global $connect;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE  user = '$username'and pass = '$password'";
    $rs = $connect->query($sql);

    if ($rs->num_rows > 0) {
        while ($acc = $rs->fetch_assoc()) {


            if ($acc['type'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php?id=" . $acc["id"]);
                $_SESSION['user'] = $username;
                $_SESSION['login'] = true;
                $_SESSION['name_cus'] = $acc["name"];
                $_SESSION['phone'] = $acc["phone"];

                // echo "<script>alert('Welcome ".$acc['name']."');</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid username or password')</script>";
    }
}
function register()
{
    global $connect;
    $sql1 = "SELECT user  FROM user ";
    $rs1 = $connect->query($sql1);
    $target_dir = "image/avt/";
    $target_file = $target_dir . basename($_FILES["Reimage"]["name"]);
    $image = basename($_FILES["Reimage"]["name"]);
    if (file_exists($target_file)) {
        $image = rand(1,10000). basename($_FILES["Reimage"]["name"]);
        $target_file = $target_dir .$image;
    }
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $isUpload = false;
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $isUpload = true;
    }
    move_uploaded_file($_FILES["Reimage"]["tmp_name"], $target_file);
    
    $name = $_POST['Rename'];
    $phone = $_POST['Rephone'];
    $address = $_POST['Readdress'];
    // $image = $_POST['Reimage'];
    $user = $_POST['Reuser'];
    $pass = $_POST['Repass'];
    $comfirm = $_POST['Recomfirm'];
    $isExistUsername = false;
    while ($row = $rs1->fetch_assoc()) {
        if ($user == $row['user']) {
            $isExistUsername = true;
        } else {
            $isExistUsername = false;
        }
    }
    if ($isExistUsername == false) {
        if ($pass == $comfirm && $isUpload == false) {
            $sql = "INSERT INTO user(user,pass,name,phone,address,type,image) VALUE('$user','$pass','$name','$phone','$address','user','$image')";
            $connect->query($sql);
            echo "<script>alert('Registion success')</script>";
            $sql2 = "SELECT * FROM user WHERE  user = '$user'and pass = '$pass'";
            $rs = $connect->query($sql2);
            while ($acc = $rs->fetch_assoc()) {
                header("Location: index.php?id=" . $acc["id"]);
                $_SESSION['user'] = $user;
                $_SESSION['login'] = true;
                $_SESSION['name_cus'] = $acc["name"];
                $_SESSION['phone'] = $acc["phone"];

            }

        } else {
            echo "<script>alert('Registion fail')</script>";
        }
    } else {
        echo "<script>alert('Username exist')</script>";
    }
}
function displayFilm($category)
{
    global $connect;
    $sql = "select*from film";
    $rs = $connect->query($sql);
    while ($film = $rs->fetch_assoc()) {
        if ($category == $film['category']) {
            echo '<div class="product-slide">';
            echo '<img src="image/film/' . $film['image_film'] . '" alt="First slide">';
            echo '<p style="margin-top:10px"><b>' . $film['name_film'] . '</b></p>';
            echo '<div class="middle">';
            echo '<div class="text"><a href="details.php?id=' . $film['id'] . '">Details</a></div>';
            echo '<div class="text1"><a href="order.php?id=' . $film['id'] . '"><i class="fas fa-band-aid"></i>Ticket</a></div>';
            echo '</div></div>';
        }
    }
}
function searchByName($name){
    global $connect;
    $sql = "SELECT * FROM film WHERE name_film LIKE '%".$name."%'";
    $rs = $connect->query($sql);
    while ($film = $rs->fetch_assoc()) {
            echo '<div class="product-slide">';
            echo '<img src="image/film/' . $film['image_film'] . '" alt="First slide">';
            echo '<p style="margin-top:10px"><b>' . $film['name_film'] . '</b></p>';
            echo '<div class="middle">';
            echo '<div class="text"><a href="details.php?id=' . $film['id'] . '">Details</a></div>';
            echo '<div class="text1"><a href="order.php?id=' . $film['id'] . '"><i class="fas fa-band-aid"></i>Ticket</a></div>';
            echo '</div></div>';
        
    }
}
function detailFilm()
{
    global $connect;
    $sql = "select*from film where id =" . $_GET['id'];
    $rs = $connect->query($sql);
    while ($film = $rs->fetch_assoc()) {
        echo '<iframe class="video" width="560" height="315" src="' . $film['video_film'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        echo '<div class="video-title">';
        echo '<h1>' . $film['name_film'] . '</h1>';
        echo '<small>PG-132 hr 21 minDecember 20, 2019</small>';
        echo '<div class="detail-video">';
        echo '<p> <b>' . $film['status_film'] . '</b></p>';
        echo '<p><b>Directed By:</b> J.J. Abrams</p>';
        echo '<p><b>Age Range Allowed:</b>' . $film['age_film'] . '</p>';
        echo '<p><b>Running Time:</b>' . $film['time_film'] . '</p><p>';
        echo '<b>Genre:</b> Fantasy & Adventure & Sci-Fi & Action</p>';
        echo '<p><b>Gross Box Office:</b> $177,383,864</p>';
        echo '<p> <b> Release Date:</b> December 20, 2019</p></div> </div>';
    }
}
function displayTable()
{
    global $connect;
    $sql = "select*from film";
    $rs = $connect->query($sql);
    $i = 0;
    while ($film = $rs->fetch_assoc()) {
        echo '<tr><th scope="row">' . ++$i . '</th>';
        echo '<td>' . $film['name_film'] . '</td>';
        echo '<td><img src="image/film/' . $film['image_film'] . '" alt="" height="80px" width="80px"></td>';
        echo '<td> ' . $film['video_film'] . '</td>';
        // echo'<td class="text-crop">'.$film['time_film'].'</td>';
        echo '<td>' . $film['time_film'] . '</td>';
        echo '<td>' . number_format($film['price_film']) . '<ins>đ</ins></td>';
        echo '<td>' . $film['age_film'] . '</td>';
        echo '<td>' . $film['category'] . '</td>';
        echo '<td> <a href="addFilm.php?id=' . $film['id'] . '"><i class="fas fa-edit"></i></a></td>';
        echo '<td> <form method="post"><input type="text" name="delete" value="' . $film['id'] . '" hidden><button><i class="fas fa-trash-alt"></i></button></form></td></tr>';
    }
}
function displayViewFilm(){
    

}
function addFilm()
{
    global $connect;
    $target_dir = "image/film/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $image = basename($_FILES["image"]["name"]);
    if (file_exists($target_file)) {
        $image = rand(1,10000). basename($_FILES["image"]["name"]);
        $target_file = $target_dir .$image;
    }
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $name = $_POST['name'];
    // $image = $_POST['image'];

    $video = $_POST['video'];
    $summary = $_POST['summary'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    $age = $_POST['age'];

    $sql = "INSERT INTO film(name_film,image_film,video_film,status_film,time_film,price_film,age_film,category) 
           VALUE ('$name','$image','$video','$summary','$time',$price,'$age','nowplay')";

    $connect->query($sql);
    echo "<script>alert('Added film " . $name . " success')</script>";
}
function deleteFilm($index)
{
    global $connect;
    $sql = "DELETE FROM film WHERE id =" . $index;
    $connect->query($sql);
}
function updateFilm($id)
{
    global $connect;
    $target_dir = "image/film/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $image = basename($_FILES["image"]["name"]);
    if (file_exists($target_file)) {
        $image = rand(1,10000). basename($_FILES["image"]["name"]);
        $target_file = $target_dir .$image;
    }
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $name = $_POST['name'];
    // $image = $_POST['image'];
    $video = $_POST['video'];
    $summary = $_POST['summary'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    $age = $_POST['age'];
    $sql = "UPDATE film SET name_film = '$name',image_film ='$image', video_film = '$video',
            status_film = '$summary', time_film= '$time',price_film = $price,age_film = '$age' WHERE id = $id";
    // echo $sql;
    $connect->query($sql);

    header("Location: admin.php");
    // echo "<script>alert('Update film ".$name." success')</script>";
}
function mostView()
{
    global $connect;
    $sql = "select*from film";
    $rs = $connect->query($sql);

    while ($film = $rs->fetch_assoc()) {
        if ($film['age_film'] == 13) {
            echo ' <li class="list-group-item"><form><button style="background:none;border:none;" name="mostView" value="' . $film['name_film'] . '" ><span style="background: #8bc34a; " class="num-rated">' . $film['age_film'] . '</span>' . $film['name_film'] . '</button></form></li>';
        } else if ($film['age_film'] == 16) {
            echo ' <li class="list-group-item"><form><button style="background:none;border:none;" name="mostView" value="' . $film['name_film'] . '" ><span style="background: #00bcd4; " class="num-rated">' . $film['age_film'] . '</span>' . $film['name_film'] . '</button></form></li>';
        } else if ($film['age_film'] == 18) {
            echo ' <li class="list-group-item"><form><button style="background:none;border:none;" name="mostView" value="' . $film['name_film'] . '" ><span style="background: red; " class="num-rated">' . $film['age_film'] . '</span>' . $film['name_film'] . '</button></form></li>';
        } else {
            echo ' <li class="list-group-item"><form><button style="background:none;border:none;" name="mostView" value="' . $film['name_film'] . '" ><span style="background: #ff9800; " class="num-rated">' . $film['age_film'] . '</span>' . $film['name_film'] . '</button></form></li>';
        }
    }
}
function displayDay($month, $year)
{
    $count = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for ($i = 1; $i <= $count; $i++) {
        if ($i == date('d') && $month == date('m') && $year == date('Y')) {
            echo "<li><form method='post'><button class='active' name='getDay' value ='" . $i . "'>" . $i . "</button></form></li>";
        } else {
            echo "<li><form method='post'><button name='getDay' value ='" . $i . "'>" . $i . "</button></form></li>";
        }
    }
}
function getchose_Day($chose)
{

    echo $chose . "-" . date("m-Y");
    echo "(" . date('l') . ")";
}
function displayCity()
{
    global $connect;
    $sql = 'SELECT * from district ';

    $rs = $connect->query($sql);
    while ($cinema = $rs->fetch_assoc()) {
        $sql1 = 'SELECT count(c.name_cinema) as sl, id_cinema from cinema as c  where  c.id_city = "' . $cinema["id_city"] . '"';
        $rs1 = $connect->query($sql1);

        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
        echo ' <form><button name="namecity" style="border: none; background: none" value="' . $cinema["id_city"] . '">' . $cinema["name_city"] . '</button></form>';

        echo '<span class="badge badge-primary badge-pill">';
        while ($row = $rs1->fetch_assoc()) {
            echo $row['sl'];
            // $_SESSION['id_cinema'] = $row['id_cinema'];
        }

        echo '</span></li>';
    }
}
function displayCinema($x)
{
    global $connect;
    $sql = ' SELECT name_cinema,id_cinema from cinema  where id_city = "' . $x . '" ;';
    $rs = $connect->query($sql);
    while ($row = $rs->fetch_assoc()) {
        $_SESSION['cinema'] = $row['name_cinema'];
    
        echo '<form><button name="getCinema" value="' . $row['id_cinema'] . '" type="submit" class="btn btn-secondary">' . $_SESSION['cinema'] . '</button></form>';
    }
}
function choseTime($date, $id_cinema){
    
    global $connect;

    $newDate = date("Y/m/d", strtotime($date));
    $sql = ' SELECT * from timeCinema where date = "' . $newDate . '" and id_cinema = ' . $id_cinema . '; ';
    $rs = $connect->query($sql);
    $i = 0;
    while ($row = $rs->fetch_assoc()) {
        echo '<div class="screen">';
        echo '<p>Screen ' . ++$i . '</p>';
        echo '<p><b>' . $row['time'] . '</b></p>';
        echo '<span>' . $row['seat'] . '/ ' . $row['seat'] . ' Seats</span></div>';
        $_SESSION['time'] =$row['time'];
    }
}
function displayNumberOfSeat($type,$name){
    global $connect;
  
    $sql = 'SELECT * FROM seatOfCinema';
    $rs = $connect->query($sql);
    $arr = $rs->fetch_all();
    for($i=1;$i<=10;$i++){  
        $check=false;  
        $isName = $name.$i;
        for($j=0;$j<count($arr);$j++){
            if($isName==$arr[$j][1]){
             echo   '<form method="post"><span><button disabled="disabled"  class="active" type="submit" name="'.
                $type.'" value="'.$isName.'" = >'.$i.'</button></span></form>';
                $check=true;
            }
        }
        if($check==false){
            echo '<form method="post"><span><button class="nonActive" type="submit" name="'.
            $type.'" value="'.$isName.'" = >'.$i.'</button></span></form>';
        }
     }
}

function addSeatOfCinema($seat,$cinema){
        global $connect;
            $sql = 'INSERT INTO seatOfCinema (nameSeat,id_cinema) VALUE("'.$seat.'","'.$cinema.'");';
            $connect->query($sql); 
}
function displayChooseSeat($arr){
    //TODO display seat
    
        for ($i = 0; $i < count($arr); $i++) {
            echo '<div style="display: flex">';
            echo $arr[$i];
            echo '<form method="post"><button style="background:none;border:none" type="submit" name="deleteSeat" value="'.$arr[$i].'" >x</button></div>';
        }
       
    } 

function displayProduct(){
    global $connect;
    $sql = 'SELECT * FROM product';
    $rs = $connect->query($sql);
    while($product = $rs->fetch_assoc()){

      echo '<form method ="post"><div class="card" style="width: 18rem;" id="cardProduct">';
      echo '<img class="card-img-top" src="'."image/product/".$product['image'].'" alt="Card image cap" width="286px" height="180">';
      echo '<div class="card-body">';
      echo '<h5 class="card-title">'.$product['name'].'</h5>';
      echo '<p class="card-text"><small>Sale price</small>&emsp;<b><span>'.number_format($product['price']).'</span>đ</b></p>';
      echo '<button type="submit" class="btn btn-danger" name="orderProduct" value="'.$product['id_product'].'">Order</button>';
      echo '</div></div></form>';
    }
}

function addOrder($name_cus,$phone,$name_film,$date,$time,$theater,$seat,$price_film,$name_product,$price_product){
    global $connect;
    $newDate = date("Y/m/d", strtotime($date));
    $sql = "INSERT INTO orderProduct(name_cus,phone_cus,name_film,movie_day,movie_time,theater,seat,film_price,name_product,product_price)
    VALUE ('$name_cus','$phone','$name_film','$newDate','$time','$theater','$seat',$price_film,'$name_product',$price_product);";
    $connect->query($sql);
}

function displayTableOrder(){
    global $connect;
    $sql = "select*from orderProduct";
    $rs = $connect->query($sql);
    $i = 0;
    while ($film = $rs->fetch_assoc()) {
        echo '<tr><th scope="row">' . ++$i . '</th>';
        echo '<td>' . $film['name_cus'] . '</td>';
        echo '<td> ' . $film['phone_cus'] . '</td>';
        echo '<td>' . $film['name_film'] . '</td>';
        echo '<td>' . $film['movie_day'] . '</td>';
        echo '<td>' . $film['movie_time'] . '</td>';
        echo '<td>' . $film['theater'] . '</td>';
        echo '<td>' . $film['seat'] . '</td>';
        echo '<td>' . $film['name_product'] . '</td>';
        echo '<td>' . number_format($film['film_price']) . '<ins>đ</ins></td>';
        echo '<td>' . number_format($film['product_price']) . '<ins>đ</ins></td>';
        echo '<td>' . number_format($film['film_price']+$film['product_price']) . '<ins>đ</ins></td>';
    }
}
function displayTableAccount()
{
    global $connect;
    $sql = "select*from user";
    $rs = $connect->query($sql);
    $i = 0;
    while ($acc = $rs->fetch_assoc()) {
        if($acc['type']!= "admin"){
        echo '<tr><th scope="row">' . ++$i . '</th>';
        echo '<td>' . $acc['name'] . '</td>';
        echo '<td>' . $acc['phone'] . '</td>';
        echo '<td>' . $acc['address'] . '</td>';
        echo '<td>' . $acc['user'] . '</td>';
        echo '<td><img src="image/avt/' . $acc['image'] . '" alt="" height="80px" width="80px"></td>';
        echo '<td> <form method="post"><input type="text" name="delete" value="' . $acc['id'] . '" hidden><button><i class="fas fa-trash-alt"></i></button></form></td></tr>';
        }
    }
}
function getFilmByIdUser($user){
    global $connect;
    $sql = "select*from orderProduct where user =".$user;
    $rs = $connect->query($sql);
    $i = 0;
}