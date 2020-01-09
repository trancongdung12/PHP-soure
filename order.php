<?php
error_reporting(0);
require 'data.php';


if (isset($_POST['login'])) {
    login();
}
if (isset($_POST['signup'])) {
    register();
}
if (isset($_POST['logout'])) {
    logout();
}
if (isset($_GET['id'])) {
    $sql = "SELECT *  FROM film where id =" . $_GET['id'];
    $rs = $connect->query($sql);

    while ($row = $rs->fetch_assoc()) {
        $name = $row['name_film'];
        $_SESSION['name_film'] = $name;
        $_SESSION['image_film'] = $row['image_film'];
        $_SESSION['price_film'] = $row['price_film'];
    }
}
if (isset($_GET['mostView'])) {
    $_SESSION['name_film'] = $_GET['mostView'];
    //TODO: chuyển ảnh vào session
}
$month = date('F');
$year  = date('Y');
$m = date('m');
if (isset($_GET['plusMonth'])) {
    $m = $_GET['plusMonth'] + 1;
    if ($m > 12) {
        $year = date('Y') + 1;
        $m = 1;
        $month = date('F', strtotime('0 months', strtotime(12)));
    }
    $x = $_GET['plusMonth'] . " months";
    $month = date('F', strtotime($x, strtotime(12)));
}
if (isset($_GET['minuteMonth'])) {
    if ($_GET['minuteMonth'] > date("m")) {
        $m = $_GET['minuteMonth'];
        $x = $_GET['plusMonth'] - 1 . " months";
        $month = date('F', strtotime($x, strtotime(12)));
    }
}
if (isset($_GET['getCinema'])) {
    $sql1 = "SELECT *  FROM cinema where id_cinema =" . $_GET['getCinema'];
    $rs = $connect->query($sql1);
    while ($row = $rs->fetch_assoc()) {
        $_SESSION['id_cinema'] = $row['id_cinema'];
        $_SESSION['getCinema'] = $row['name_cinema'];
    }
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
    <link rel="stylesheet" href="css/style1.css">
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
                    <li class="nav-item" <?php if ($_SESSION['login'] == true) {
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
                                        <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                                    </div>
                                    <input name="login" type="submit" class="btn btn-primary btn-block" value="Login">
                                    <div class="form-footer">
                                        <a href="#">Forgot Your password?</a>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" <?php if ($_SESSION['login'] == true) {
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
    <div class="container">
        <div class="header-order" style="margin-top: 100px;"">
            <h2 style=" color: #f60;">Buy tickets</h2>
            <hr class="hr-order">
        </div>
        <div class="month">
            <ul>
                <li class="prev">
                    <form method="get"><button name="minuteMonth" value="<?php if (isset($_GET['minuteMonth'])) {
                                                                                echo $_GET['plusMonth'] - 1;
                                                                            } else {
                                                                                echo date('m');
                                                                            } ?>"><i class="fas fa-chevron-left"></i></button></form>
                </li>
                <li class="next">
                    <form method="get"><button name="plusMonth" value="<?php if (isset($_GET['plusMonth'])) {
                                                                            echo $m;
                                                                        } else {
                                                                            echo date('m');
                                                                        } ?>"><i class="fas fa-chevron-right"></i></button></form>
                </li>
                <li>
                    <?php echo $month ?><br>
                    <span style="font-size:18px"> <?php echo $year ?></span>
                </li>
            </ul>
        </div>

        <ul class="weekdays">
            <li>Mo</li>
            <li>Tu</li>
            <li>We</li>
            <li>Th</li>
            <li>Fr</li>
            <li>Sa</li>
            <li>Su</li>
        </ul>

        <ul class="days">
            <?php displayDay($m, $year); ?>
        </ul>

        <div class="cinema-title">

            <hr class="hr-order">

        </div>
        <table class="table table-striped">
            <tr>
                <th>Cinema</th>
                <th>Movie</th>
            </tr>
            <tr>
                <td>Your Cinema</td>
                <td>Most View</td>
            </tr>
            <tr>
                <td>
                    <div class="cinema-chose">
                        <div class="list-city">
                            <ul class="list-group">
                                <?php displayCity(); ?>
                            </ul>

                        </div>
                        <div class="list-cinema">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <?php if (isset($_GET['namecity'])) {
                                    $_SESSION['nameCity'] = $_GET['namecity'];
                                    displayCinema($_SESSION['nameCity']);
                                } else {
                                    displayCinema('1_hcm');
                                }  ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="view-most">
                        <ul id="mostview" class="list-group" style="height: 200px;overflow: auto;">
                            <?php mostView(); ?>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr class="tr-footer">
                <td>Date: <span style="margin-right: 200px;"><?php if (isset($_POST['getDay'])) {
                                                                    $date = $_POST['getDay'] . "-" . $m . "-" . $year;

                                                                    if (strtotime($date) > strtotime(date("d-m-Y"))) {
                                                                        echo  $date . "(" . date('l') . ")";
                                                                    } else {
                                                                        $date = date("d-m-Y");
                                                                        echo $date . "(" . date('l') . ")";
                                                                    }
                                                                    $_SESSION['date'] = $date;
                                                                } else {
                                                                    $date = date("d-m-Y");
                                                                    echo  $date . "(" . date('l') . ")";
                                                                    $_SESSION['date'] = date("d-m-Y");
                                                                }  ?></span> Cinema: <span>

                        <?php if (isset($_SESSION['getCinema'])) {
                            echo $_SESSION['getCinema'];
                        } else {
                            echo "Please select a Cinema";
                        } ?></span>
                </td>

                <td>Movie: <span><?php if (isset($_SESSION['name_film'])) {
                                        // $_SESSION['name_film'] = $name;
                                        echo $_SESSION['name_film'];
                                    } else {
                                        echo "Please select a Movie";
                                    } ?></span></td>
            </tr>

        </table>
        <div class="btn-footer">
            <button class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">SHOW TIME</button>
        </div>
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Showtime</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <small style="color: red;">The show time can be different by 10 minutes due to preview running.</small>
                        <div class="name-film">
                            <hr>
                            <!-- <span class="num-rated">All</span> -->
                            <span><?php echo $_SESSION['name_film']; ?></span>
                            <hr>
                        </div>
                        <div>
                            <p><b><?php echo $_SESSION['getCinema']; ?></b></p>
                            <p>2D | Subtitle</p>

                        </div>
                        <div class="list-screen">
                            <?php
                            // if(isset($_SESSION['id_cinema']))
                            // { choseTime($date,$_SESSION['id_cinema']);}
                            // else{

                            // }
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form method="post"><button type="submit" name="checkLogin"  class="btn btn-danger" style="background-color: #f60;">
                        <a style="text-decoration: none;color:white" 
                        <?php if ($_SESSION['login'] == true && $_SESSION['getCinema'] != null) { echo ' href="choseSeat.php" ';} ?>
                        >OK</a></button>
                        <?php
                        // unset($_SESSION['getCinema']);
                        if(isset($_POST['checkLogin'])){
                            if ($_SESSION['login'] == true) {
                                if($_SESSION['getCinema'] == null)
                                {
                                    echo '<script>alert("Please select a cinema !")</script>';
                                }
                               
                            } else {
                                echo '<script>alert("You must sign-in before order !")</script>';
                            }
                        }
                         ?>

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