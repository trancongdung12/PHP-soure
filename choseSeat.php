<?php
require 'connect.php';
require 'data.php';
error_reporting(0);
if (isset($_POST['login'])) {
    login();
}
if (isset($_POST['signup'])) {
    register();
}
if (isset($_POST['logout'])) {
    logout();
}

if (isset($_POST['normal'])) {


    if (isset($_SESSION['arrSeat'])) {
        $arr = $_SESSION['arrSeat'];
    } else {
        $arr = array();
    }
    $check = false;
    for ($i = 0; $i < count($_SESSION['arrSeat']); $i++) {
        if ($_POST['normal'] == $_SESSION['arrSeat'][$i]) {
            $check = true;
        }
    }
    if ($check == false) {
        array_push($arr, $_POST['normal']);
        $_SESSION['arrSeat'] = $arr;
    }
}

if (isset($_POST['vip'])) {

    if (isset($_SESSION['arrSeat'])) {
        $arr = $_SESSION['arrSeat'];
    } else {
        $arr = array();
    }
    $check = false;
    for ($i = 0; $i < count($_SESSION['arrSeat']); $i++) {
        if ($_POST['vip'] == $_SESSION['arrSeat'][$i]) {
            $check = true;
        }
    }
    if ($check == false) {
        array_push($arr, $_POST['vip']);
        $_SESSION['arrSeat'] = $arr;
    }
}

if (isset($_POST['couple'])) {

    if (isset($_SESSION['arrSeat'])) {
        $arr = $_SESSION['arrSeat'];
    } else {
        $arr = array();
    }
    $check = false;
    for ($i = 0; $i < count($_SESSION['arrSeat']); $i++) {
        if ($_POST['couple'] == $_SESSION['arrSeat'][$i]) {
            $check = true;
        }
    }
    if ($check == false) {
        array_push($arr, $_POST['couple']);
        $_SESSION['arrSeat'] = $arr;
    }
}
if (isset($_POST['deleteSeat'])) {
    for ($i = 0; $i < count($_SESSION['arrSeat']); $i++) {
        if ($_POST['deleteSeat'] == $_SESSION['arrSeat'][$i]) {
            unset($_SESSION['arrSeat'][$i]);
        }
    }
}
if (isset($_POST['orderProduct'])) {

    $sql = 'SELECT *FROM  product where id_product = ' . $_POST['orderProduct'];
    $rs = $connect->query($sql);
    while ($row = $rs->fetch_assoc()) {
        $_SESSION['name_product'] = $row['name'];
        $_SESSION['price_product'] = $row['price'];
    }
}
if (isset($_POST['endOrder'])) {
    for ($i = 0; $i < count($_SESSION['arrSeat']); $i++) {
        addSeatOfCinema($_SESSION['arrSeat'][$i], $_SESSION['id_cinema']);
    }
    echo '<script>alert("Order success");</script>';
    $seatArr = implode(", ", $_SESSION['arrSeat']);
    echo $test;
    $name_cus = $_SESSION['name_cus'];
    $phone = $_SESSION['phone'];
    $name_film = $_SESSION['name_film'];
    $date = $_SESSION['date'];
    $time = $_SESSION['time'];
    $theater = $_SESSION['getCinema'];
    $seat = $seatArr;
    $price_film = $_SESSION['totalPrice_film'];
    $name_product = $_SESSION['name_product'];
    $price_product = $_SESSION['price_product'];
    addOrder($name_cus, $phone, $name_film, $date, $time, $theater, $seat, $price_film, $name_product, $price_product);
    unset($_SESSION['arrSeat']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movie Ticket</title>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/jquery-3.4.1.slim.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap3.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" type="image/png" href="https://i1.wp.com/batdongsanngach.com/wp-content/uploads/2018/01/ticket-icon.png?fit=440%2C440&ssl=1" />
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap3.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrapv4.4.1.min.js"></script>
    <script type="text/javascript">
        $(document).on("click", ".navbar-right .dropdown-menu", function(e) {
            e.stopPropagation();
        });
    </script>
    <style>
        #nameLogo {
            position: absolute;
            top: 5px;
            left: 100px;
            color: #f60;
        }

        /* #btncheckout{
            position: absolute;
            top: 515px;
            right: 0px;
            z-index: 999;
        } */
    </style>
    <script src="index.js"></script>
</head>

<body>
    <div id="navbar">
        <nav class="navbar navbar-default navbar-expand-lg navbar-light">
            <div class="navbar-header d-flex col">
                <a class="navbar-brand" href="index.php"><span><img src="Image/logo.png" alt="" height="70px" width="100px"></span>
                    <p id="nameLogo"><b>Movie <br>Tickets</b></p>
                </a>
                <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
                    <span class="navbar-toggler-icon"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collection of nav links, forms, and other content for toggling -->
            <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">About</a></li>
                    <li class="nav-item dropdown">
                        <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">Services</a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item">Web Design</a></li>
                            <li><a href="#" class="dropdown-item">Web Development</a></li>
                            <li><a href="#" class="dropdown-item">Graphic Design</a></li>
                            <li><a href="#" class="dropdown-item">Digital Marketing</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a href="#" class="nav-link">Contact</a></li>
                </ul>
                <form class="navbar-form form-inline">
                    <div class="input-group search-box">
                        <input type="text" id="search" class="form-control" placeholder="Search here...">
                        <span class="input-group-addon"><i class="material-icons">&#xE8B6;</i></span>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right ml-auto">
                    <li class="nav-item" id="login" <?php if ($_SESSION['login'] == true) {
                                                        echo 'style="display: none"';
                                                    } ?>>
                        <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">Login</a>
                        <ul class="dropdown-menu form-wrapper">
                            <li>
                                <form method="post">
                                    <p class="hint-text">Sign in with your social media account</p>
                                    <div class="form-group social-btn clearfix">
                                        <a href="#" class="btn btn-primary pull-left"><i class="fab fa-facebook-f"></i> Facebook</a>
                                        <a href="#" class="btn btn-info pull-right"><i class="fab fa-twitter"></i> Twitter</a>
                                    </div>
                                    <div class="or-seperator"><b>or</b></div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="username" placeholder="Username" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                                    </div>
                                    <input type="submit" name="login" class="btn btn-primary btn-block" value="Login">
                                    <div class="form-footer">
                                        <a href="#">Forgot Your password?</a>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" id="signup" <?php if ($_SESSION['login'] == true) {
                                                            echo 'style="display: none"';
                                                        } ?>>
                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle get-started-btn mt-1 mb-1">Sign up</a>
                        <ul class="dropdown-menu form-wrapper">
                            <li>
                                <form method="post">
                                    <p class="hint-text">Fill in this form to create your account!</p>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="Rename" placeholder="Full name" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="Rephone" placeholder="Phone" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="Readdress" placeholder="Address" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="Reimage" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="Reuser" placeholder="Username" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="Repass" placeholder="Password" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="Recomfirm" placeholder="Confirm Password" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label class="checkbox-inline"><input type="checkbox" required="required"> I accept the <a href="#">Terms &amp; Conditions</a></label>
                                    </div>
                                    <input type="submit" class="btn btn-primary btn-block" name="signup" value="Sign up">
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
        </nav>

        <div class="dropdown" id="avatar-drop">
            <img <?php if ($_SESSION['login'] == true) {
                        echo 'style="display: block"';
                    } else {
                        echo 'style="display: none"';
                    } ?> class="img-circle dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" src="Image/avt/<?php echo $_SESSION['image']; ?>" alt="Avatar">
            <form method="post">
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">

                    <!-- <button class="dropdown-item" type="button">Another action</button> -->
                    <button name="profile" class="dropdown-item" type="button"><i class="fas fa-address-card"></i>&emsp;Profile</button>
                    <button name="logout" class="dropdown-item" type="submit"><i class="fas fa-sign-out-alt"></i>&emsp;Logout</button>

                </div>
            </form>
        </div>
    </div>
    <div class="container" style="margin-top: 100px">
        <div class="header-order">
            <h2 style="color: #f60;">Person/Seat selection</h2>
            <hr class="hr-order">
        </div>

        <div class="design-screen">
            <hr>
            <h3 style="text-align: center;">Screen</h3>
            <hr>

        </div>
        <div class="seat-screen">
            <div class="item-screen">
                <div class="stt-screen"><span>A</span></div>
                <div style="display: flex">
                    <?php displayNumberOfSeat('normal', 'A') ?>
                </div>
            </div>
            <div class="item-screen">
                <div class="stt-screen"><span>B</span></div>
                <div style="display: flex">
                    <?php displayNumberOfSeat('normal', 'B') ?>
                </div>
            </div>
            <div class="item-screen">

                <div class="stt-screen"><span>C</span></div>
                <div style="display: flex">
                    <?php displayNumberOfSeat('normal', 'C') ?>
                </div>
            </div>
            <div class="seat-vip">
                <div class="item-screen">

                    <div class="stt-screen"><span>D</span></div>
                    <div style="display: flex">
                        <?php displayNumberOfSeat('vip', 'D') ?>
                    </div>
                </div>
            </div>

            <div class="seat-vip">
                <div class="item-screen">

                    <div class="stt-screen"><span>E</span></div>
                    <div style="display: flex">
                        <?php displayNumberOfSeat('vip', 'E') ?>
                    </div>
                </div>
            </div>
            <div class="seat-couple">
                <div class="item-screen">

                    <div class="stt-screen"><span>F</span></div>
                    <div style="display: flex">
                        <?php displayNumberOfSeat('couple', 'F') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="title-seat">
            <button class="seat-selected">X</button><span>Seat Selected</span>
            <button class="seat-can"></button><span>Seat can choose</span>
            <button class="seat-bought"></button><span>Seat Bought</span>
            <button class="seat-cannot">X</button><span>Seat can't choose</span>
            <div class="name-seat">
                <button class="nomal-seat"></button><span>Nomal Seat</span>
                <button class="vip-seat"></button><span>Vip Seat</span>
                <button class="couple-seat"></button><span>Couple Seat</span>
            </div>
            <div class="name-seat" style="display: flex;color: red;border-bottom: 1px solid red;width: 470px">
                <div>
                    <p>Seat you choose:</p>
                </div>
                <?php if (isset($_SESSION['arrSeat'])) {
                    displayChooseSeat($_SESSION['arrSeat']);
                } ?>
            </div>
        </div>
        <div class="bottom-order">
            <h2 style="color: #f60;">Order snack bar product</h2>
            <hr class="hr-order">
            <div class="card-product">
                <?php displayProduct(); ?>
            </div>
            <hr class="hr-order">

            <button class="btn-comple" data-toggle="modal" name="checkOrder" <?php if ($_SESSION['arrSeat'] != null) {
                                                                                    echo 'data-target="#exampleModal"';
                                                                                }else{ echo 'onclick="checkSeat()"'; }?>>Complete Order</button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" id="exampleModalLabel">Your ticket</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="ticket-movie">
                                <div class="ticket-movie-name">
                                    <span style="color: #f60;margin-left: 5px;">Movie</span>
                                    <div class="ticket-movie-title">

                                        <div class="ticket-movie-img">
                                            <img src="<?php echo "image/film/" . $_SESSION['image_film'] ?>" alt="Image Film" height="100px" width="80px">
                                        </div>
                                        <div style="margin-left: 10px;">
                                            <p><b><?php echo $_SESSION['name_film'] ?></b></p>
                                            <p>2D</p>
                                            <p></p>
                                            <small>16 years old or order</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="ticket-movie-name">
                                    <span style="color: #f60;margin-left: 5px;">Infomation</span>
                                    <div class="ticket-movie-title">
                                        <div style="margin-left: 10px;" class="info-ticket">
                                            <p>
                                                <div class="info-ticket-div">
                                                    <div class="info-div"><span>Date</span></div>
                                                    <b><?php echo $_SESSION['date']; ?></b>
                                                </div>
                                            </p>

                                            <p>
                                                <div class="info-ticket-div">
                                                    <div class="info-div"><span>Showtime</span></div>
                                                    <b>14:15 ~ 16:32</b>
                                                </div>
                                            </p>
                                            <p>
                                                <div class="info-ticket-div">
                                                    <div class="info-div"><span>Theater</span></div>
                                                    <b><?php echo $_SESSION['getCinema'] ?></b>
                                                </div>
                                            </p>
                                            <p>
                                                <div class="info-ticket-div">
                                                    <div class="info-div"><span>Seat</span></div>
                                                    <b><?php for ($i = 0; $i < count($_SESSION['arrSeat']); $i++) {
                                                            echo $_SESSION['arrSeat'][$i] . ", ";
                                                        } ?></b>
                                                </div>
                                            </p>
                                            <p style="margin-top: 25px">
                                                <b class="price-ticket">
                                                    <?php $_SESSION['totalPrice_film'] = $_SESSION['price_film'] * count($_SESSION['arrSeat']);
                                                    echo number_format($_SESSION['totalPrice_film']);
                                                    ?>
                                                    đ</b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ticket-movie-name">
                                    <span style="color: #f60;margin-left: 5px;">Product</span>
                                    <div class="ticket-movie-title">
                                        <div style="margin-left: 10px;" class="info-ticket">
                                            <p>
                                                <div class="info-ticket-div">
                                                    <div class="info-pro"><span><?php echo $_SESSION['name_product']; ?></span></div>
                                                    <b><?php echo $_SESSION['price_product']; ?>đ</b><button style="border: none; color:red;background:none;margin-top: -23px">x</button>
                                                </div>

                                            </p>
                                            <p>
                                                <b class="price-product"><?php echo number_format($_SESSION['price_product']); ?>đ</b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ticket-movie-total">
                                    <span style="color: #f60;margin-left: 5px;">Total payment price</span>
                                    <div class="ticket-movie-title">
                                        <div style="margin-left: 10px;" class="info-ticket">
                                            <p>
                                                <div class="info-ticket-div">
                                                    <div class="info-pro"><span>Ticket</span></div>
                                                    <b><?php echo number_format($_SESSION['totalPrice_film']); ?>đ</b>
                                                </div>
                                                <div class="info-ticket-div">
                                                    <div class="info-pro"><span>Product</span></div>
                                                    <b><?php echo number_format($_SESSION['price_product']); ?>đ</b>
                                                </div>

                                            </p>
                                            <p>
                                                <b class="price-product"><?php echo number_format($_SESSION['price_product'] + $_SESSION['totalPrice_film']); ?>đ</b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="header-order">
                                    <h2 style="color: #f60;">Payment</h2>
                                    <hr class="hr-order">
                                    <div style="display: flex;justify-content: flex-start;width: 100%;margin-left: 100px">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend" style="margin-bottom: 10px">
                                                <div class="input-group-text">
                                                    <input checked type="checkbox" aria-label="Checkbox for following text input" id="cbCredit" onclick="displayCredit()">
                                                </div>
                                                <b>&emsp;Credit</b>
                                            </div>
                                            <div class="input-group-prepend" style="margin-bottom: 10px">
                                                <div class="input-group-text">
                                                    <input type="checkbox" aria-label="Checkbox for following text input" id="cbAtm" onclick="displayAtm()">
                                                </div>
                                                <b>&emsp;ATM card</b>
                                            </div>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" aria-label="Checkbox for following text input" id="cbMomo" onclick="displayMomo()">
                                                </div>
                                                <b>&emsp;MOMO</b>
                                            </div>
                                        </div>
                                        <div style="width: 2000px">
                                            <div class="credit" id="credit">
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="cardnumber"><b style="color: #f60">DUNGX</b>&emsp;|&emsp; 2121323133232</label>
                                                        <input type="text" class="form-control" id="cardnumber" placeholder="Card number" required>

                                                    </div>
                                                </div>
                                                <div class="form-row">

                                                    <div class="col-md-3 mb-3">
                                                        <select id="inputState" class="form-control">
                                                            <option selected>Month</option>
                                                            <?php for ($i = 1; $i <= 12; $i++) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <select id="inputState" class="form-control">
                                                            <option selected>Year</option>
                                                            <?php for ($i = 2020; $i <= 2040; $i++) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <!-- <label for="validationCustom03">CSC</label> -->
                                                        <input type="text" class="form-control" id="validationCustom03" placeholder="CSC" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="atm" id="atm" style="display: none">
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustom03"><b style="color: #f60">DUNGX</b>&emsp;|&emsp;100052241111

                                                        </label>
                                                        <div class="col-md-3 mb-3" style="padding: 0px;margin-right:2px">
                                                            <select id="inputState" class="form-control" style="padding: 0px">
                                                                <option selected>Bank</option>
                                                                <option value="">Vietcombank</option>
                                                                <option value="">Viettinbank</option>
                                                                <option value="">BIDV</option>
                                                                <option value="">Techcombank</option>
                                                                <option value="">TPbank</option>

                                                            </select>
                                                        </div>
                                                        <input type="text" class="form-control" id="validationCustom03" placeholder="Card number" required>

                                                    </div>
                                                </div>
                                                <div class="form-row">

                                                    <div class="col-md-3 mb-3">
                                                        <select id="inputState" class="form-control">
                                                            <option selected>Month</option>
                                                            <?php for ($i = 1; $i <= 12; $i++) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <select id="inputState" class="form-control">
                                                            <option selected>Year</option>
                                                            <?php for ($i = 2020; $i <= 2040; $i++) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <!-- <label for="validationCustom03">CSC</label> -->
                                                        <input type="text" class="form-control" id="validationCustom03" placeholder="Name in card" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mono" id="momo" style="display: none">
                                                <div class="form-row">
                                                    <img src="image/logo-1.png" alt="" height="50px" width="50px"><span>&emsp;Scan the code to pay</span>
                                                </div>
                                                <div class="form-row">
                                                    <img style="margin-left: 70px" src="image/qrcode.png" alt="" height="150px" width="150px">

                                                </div>
                                                <small style="text-align: center">
                                                    &emsp; &emsp;Use the MoMo App or
                                                    Camera <br>application supports QR code to scan codes.</small>

                                            </div>
                                            <div>
                                                <form method="post">
                                                    <input id="btncheckout" type="submit" name="endOrder" value="Check out" class="btn btn-danger">
                                                </form>
                                            </div>
                                            <script>
                                                var cbcredit = document.getElementById('cbCredit');
                                                var cbatm = document.getElementById('cbAtm');
                                                var cbmomo = document.getElementById('cbMomo');
                                                var credit = document.getElementById('credit');
                                                var atm = document.getElementById('atm');
                                                var momo = document.getElementById('momo');
                                                var button = document.getElementById('btncheckout');

                                                function displayAtm() {
                                                    if (cbatm.checked == true) {
                                                        atm.style.display = "block";
                                                        credit.style.display = "none";
                                                        momo.style.display = "none";
                                                        button.style.display = "block";
                                                        cbcredit.checked = false;
                                                        cbmomo.checked = false;
                                                    }
                                                }

                                                function displayCredit() {
                                                    if (cbcredit.checked == true) {
                                                        atm.style.display = "none";
                                                        credit.style.display = "block";
                                                        momo.style.display = "none";
                                                        button.style.display = "block";
                                                        cbatm.checked = false;
                                                        cbmomo.checked = false;
                                                    }
                                                }

                                                function displayMomo() {
                                                    if (cbmomo.checked == true) {
                                                        atm.style.display = "none";
                                                        credit.style.display = "none";
                                                        momo.style.display = "block";
                                                        button.style.display = "none";
                                                        cbatm.checked = false;
                                                        cbcredit.checked = false;
                                                    }
                                                }
                                                function checkSeat(){
                                                    alert("Please select the seat !");
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
    <footer id="myFooter">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Sign up</a></li>
                        <li><a href="#">Downloads</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="#">Company Information</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help desk</a></li>
                        <li><a href="#">Forums</a></li>
                    </ul>
                </div>
                <div class="col-sm-3 info">
                    <h5>Information</h5>
                    <p> This is a website of a future programmer. Everyone please support me.I love you so much.</p>
                </div>
            </div>
        </div>
        <div class="second-bar">
            <div class="container">
                <h2 class="logo"><a href="#"> LOGO </a></h2>
                <div class="social-icons">
                    <a href="#" class="twitter"><i class="fab fa-twitter-square"></i></a>
                    <a href="#" class="facebook"><i class="fab fa-facebook-square"></i></a>
                    <a href="#" class="google"><i class="fab fa-google-plus-square"></i></a>
                    <span>© 2019 DungxDev</span>
                </div>
            </div>
        </div>
    </footer>
    <script>
        window.onscroll = function() {
            myFunction()
        };

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }
    </script>
</body>

</html>