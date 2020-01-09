<?php
require_once 'data.php';
error_reporting(0);
if (isset($_POST['addFilm'])) {
    addFilm();
}

if (isset($_GET['id'])) {
    
    $sql = "SELECT * FROM film WHERE id =" . $_GET['id'];
    $result = $connect->query($sql);
    while ($film = $result->fetch_assoc()) {
        $id = $film['id'];
        $name = $film['name_film'];
        $image = $film['image_film'];
        $video = $film['video_film'];
        $summary = $film['status_film'];
        $time = $film['time_film'];
        $price = $film['price_film'];
        $age = $film['age_film'];
    }
 
}
if(isset($_POST['updateFilm'])){
    updateFilm($_GET['id']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add films</title>
    <link href="admin/bootstrap.min.css" rel="stylesheet">
    <link href="admin/font-awesome.min.css" rel="stylesheet">
    <link href="admin/datepicker3.css" rel="stylesheet">
    <link href="admin/admin.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button>
                <a class="navbar-brand" href="#"><span>Dungx</span>Admin</a>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <em class="fa fa-envelope"></em><span class="label label-danger">15</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="http://placehold.it/40/30a5ff/fff">
                                    </a>
                                    <div  class="message-body"><small class="pull-right">3 mins ago</small>
                                        <a href="#"><strong>John Doe</strong> commented on <strong>your photo</strong>.</a>
                                        <br /><small class="text-muted">1:24 pm - 25/03/2015</small></div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="http://placehold.it/40/30a5ff/fff">
                                    </a>
                                    <div class="message-body"><small class="pull-right">1 hour ago</small>
                                        <a href="#">New message from <strong>Jane Doe</strong>.</a>
                                        <br /><small class="text-muted">12:27 pm - 25/03/2015</small></div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="all-button">
                                    <a href="#">
                                        <em class="fa fa-inbox"></em> <strong>All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <em class="fa fa-bell"></em><span class="label label-info">5</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div><em class="fa fa-envelope"></em> 1 New Message
                                        <span class="pull-right text-muted small">3 mins ago</span></div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div><em class="fa fa-heart"></em> 12 New Likes
                                        <span class="pull-right text-muted small">4 mins ago</span></div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div><em class="fa fa-user"></em> 5 New Followers
                                        <span class="pull-right text-muted small">4 mins ago</span></div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar">
            <div class="profile-userpic">
                <img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
            </div>
           
            <div class="profile-usertitle">
                <div class="profile-usertitle-name">Admin</div>
                <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>
        <form role="search">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
            </div>
        </form>
        <ul class="nav menu">
            <li><a href="#"><em class="fas fa-chart-line">&nbsp;</em>Films portfolio</a></li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-1">
                    <em class="fas fa-cubes">&nbsp;</em> Films <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-1">
                    <li>
                        <a class="" href="admin.php">
                            <span class="fa fa-arrow-right">&nbsp;</span> List films
                        </a>
                    </li>
                    <li>
                        <a class="active" href="#">
                            <span class="fa fa-arrow-right">&nbsp;</span> Add films
                        </a>
                    </li>

                </ul>
            </li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-2">
                    <em class="fas fa-shopping-cart">&nbsp;</em> Order <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-2">
                    <li>
                        <a class="" href="listOrder.php">
                            <span class="fa fa-arrow-right">&nbsp;</span> List order
                        </a>
                    </li>
                    <li>
                        <a class="" href="#">
                            <span class="fa fa-arrow-right">&nbsp;</span> New order
                        </a>
                    </li>
                </ul>
            </li>
            <li><a href="listAccount.php"><em class="fas fa-users">&nbsp;</em> Account user</a></li>
            <li><a href="#"><em class="fas fa-comments">&nbsp;</em> Contact</a></li>
            <li><a href="index.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
        </ul>
    </div>
    <!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li>
                    <a href="#">
                        <em class="fa fa-home"></em>
                    </a>
                </li>
                <li class="active">Add Films</li>
            </ol>
        </div>
        <!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add Films</h1>
            </div>
        </div>
        <!--/.row-->
        <div class="row" id="row-table">
            <form class="form-add" style="margin-left: 100px" method="post" enctype="multipart/form-data">
                <div class="form-row col-md-12">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Name</label>
                        <input type="text" name="name" class="form-control" id="inputEmail4" value="<?php echo $name ?>">
                    </div>
                </div>
                <div class="form-row col-md-12">
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Link Video</label>
                        <input type="text" name="video" class="form-control" id="inputPassword4" value="<?php echo $video ?>">
                    </div>
                </div>
                <div class="form-row col-md-12">
                    <div class="form-group col-md-2">
                        <label for="inputState">Age allow</label>
                        <select id="inputState" name="age" class="form-control">
                            <option value="13" <?php if ($age == 13) {
                                                    echo ' selected="selected"';
                                                } ?>>13</option>
                            <option value="15" <?php if ($age == 15) {
                                                    echo ' selected="selected"';
                                                } ?>>15</option>
                            <option value="18" <?php if ($age == 18) {
                                                    echo ' selected="selected"';
                                                } ?>>18</option>
                            <option value="All" <?php if ($age == 'All') {
                                                    echo ' selected="selected"';
                                                } ?>>All</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputZip">Price</label>
                        <input type="text" name="price" class="form-control" id="inputZip" value="<?php echo $price ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputZip">Time</label>
                        <input type="text" name="time" class="form-control" id="inputZip" placeholder="00 hr 00 min" value="<?php echo $time ?>">
                    </div>
                </div>
                <div class="form-row col-md-12">
                    <div class="form-group col-md-6">
                        <label for="inputCity">Image</label>
                        <input type="file" name="image" class="form-control" id="inputCity" value="<?php echo $image ?>">
                    </div>

                </div>
                <div class="form-group col-md-12">
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlTextarea1">Summary</label>
                        <textarea class="form-control" name="summary" id="exampleFormControlTextarea1" rows="3"><?php echo htmlspecialchars($summary) ?></textarea>
                        <input value="<?php if(isset($_GET['id'])){ echo 'Update';}else{echo 'Add';}  ?> " type="submit" style="margin-top: 20px" name="<?php if(isset($_GET['id'])){ echo 'updateFilm';}else{echo 'addFilm';}  ?>" class="btn btn-primary"></input>
                  
                    </div>

                </div>


            </form>
        </div>

        <div class="col-sm-12">
            <p class="back-link">Design by <a href="https://www.facebook.com/profile.php?id=100006749658966">Dungx</a></p>
        </div>
    </div>
    <!--/.row-->
    </div>
    <!--/.main-->



</body>

</html>