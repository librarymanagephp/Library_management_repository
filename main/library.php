<?php 
require_once "pdo.php";
require_once "util.php";
    session_start();
    if ( ! isset($_SESSION['user_id'])) {
    	die( '<img src= "./img/access.jpg">');
    return;
	}
	 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Library</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php require_once "head.php"; ?>
</head>
<body>
	<nav class="navbar navbar-dark navbar-expand-lg fixed-top">
        <div class="container">
          <a class="navbar-brand mr-auto" href="#"><img src="img/logo.jpg" height="30" width="41"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="search_books.php">Search Books</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="add_books.php">Add Books</a>
              </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Manage Members
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="add_members.php">Add Member</a>
		          <a class="dropdown-item" href="approve_members.php">Approve Member</a>
		          <a class="dropdown-item" href="view_members.php">View Member</a>
		      </li>
            </ul>
            <span class="navbar-text">
                <a id="loginbutton" href="logout.php">Logout</a>
            </span>
          </div>
        </div>
  </nav>
  <header class="jumbotron" id="header">

        <div class="container">
            <div class="row row-header">
                <div class="col-12 col-sm-6">
                    <h1>ONLINE LIBRARY MANAGEMENT SYSTEM (OLMS)</h1>
                    <p>OLMS is concerned with all the activities involved in the management of any library materials and its members. This system guarantees efficiency & effectiveness in the managements of books. You must be a member inorder to experience full access to our system.</p>
                </div>
                <div class="col-12 col-sm align-self-center">
                    <img src="img/logo1.png" alt="logo" class="img-fluid" width="30%">
                </div>
            </div>
        </div>

    </header>
    <div class="container">
      <center>
    <span class="border">
      <h3>
    	<?php 
            flashMessages();
        ?>
      </h3>
      </span>
      </center>

      <div id="home-tiles" class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <a href="view_members.php"><div id="menu-tile"><span>Search Members</span></div></a>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <a href="search_books.php"><div id="specials-tile"><span>Search Books</span></div></a>
        </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">             
                <div class="col-4 offset-1 col-sm-2">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Home</a></li>
                        <li><a href="./aboutus.html">About</a></li>
                        <li><a href="./contactus.html">Contact</a></li>
                    </ul>
                </div>
                <div class="col-7 col-sm-5">
                    <h5>Our Address</h5>
                    <address>
                        NSEC<br>
                        Srinagar, Panchpota, Garia<br>
                        Kolkata, West Bengal, India<br><br>
                  <i class="fa fa-phone fa-lg"></i>: +91 887 744 5566<br>
                  <i class="fa fa-fax fa-lg"></i>: +91 887 744 5566<br>
                  <i class="fa fa-envelope fa-lg"></i>: <a href="mailto:olms@library.com">olms@library.com</a>
               </address>
                </div>
                <div class="col-12 col-sm-4 align-self-center">
                    <div class="text-center">
                        <a class="btn btn-social-icon btn-google" href="http://google.com/+"><i class="fa fa-google-plus fa-lg"></i></a>
                        <a class="btn btn-social-icon btn-facebook" href="http://www.facebook.com/profile.php?id="><i class="fa fa-facebook fa-lg"></i></a>
                        <a class="btn btn-social-icon btn-linkedin" href="http://www.linkedin.com/in/"><i class="fa fa-linkedin fa-lg"></i></a>
                        <a class="btn btn-social-icon btn-twitter" href="http://twitter.com/"><i class="fa fa-twitter fa-lg"></i></a>
                        <a class="btn btn-social-icon btn-google" href="http://youtube.com/"><i class="fa fa-youtube fa-lg"></i></a>
                        <a class="btn btn-social-icon" href="mailto:"><i class="fa fa-envelope-o fa-lg"></i></a>
                    </div>
                </div>
           </div>
           <div class="row justify-content-center">             
                <div class="col-auto">
                    <p>© Copyright 2020 OLEM </p>
                </div>
           </div>
        </div>
    </footer>
	<?php require_once "tail.php" ?>
</body>
</html>