<?php 
  require_once "pdo.php";
  require_once "util.php";
    session_start();
    if ( ! isset($_SESSION['user_id'])) {
    	die( '<img src= "./img/access.jpg">'); 
    return;
    }
    
    if ( isset($_POST['cancel']) ) {
      header('Location: search_books.php');
      return;
    }
    if ( isset($_POST['member_id']) && isset($_POST['issue'])) {
      
      $msg = validateissue($pdo);
      if (is_string($msg)){
        $_SESSION['error'] = $msg;
        echo '<script>alert("Book Already alloted to same member");
        window.location.replace("issue_book.php?ISBN='.$_REQUEST['ISBN'].'");
            </script>';
        // header('Location: issue_book.php?ISBN='.$_REQUEST['ISBN']);
      }else {
        header('Location: issue_conf.php?ISBN='.$_REQUEST['ISBN'].'&member_id='.$_POST['member_id']);
      return;
      }
    }
    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Issue Books</title>
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
              <li class="nav-item">
                <a class="nav-link" href="library.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="search_books.php">Search Books</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="#">Issue Books</a>
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
    <div class="container" id="issue_books">
        <div class="row row-content">
            <div class="col-12">
                <h1>Issue Books</h1>
            </div>
            <div class="col-12 col-md-6">
                <?php 
                    flashMessages();
                    //Book Details display
                    $stmt = $pdo->prepare("SELECT * FROM books where ISBN = :xyz");
                    $stmt->execute(array(":xyz" =>$_GET['ISBN']));
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo '<h5><b>Book Details</b></h5>';
                    echo '<p>Title : '.$row['title'];
                    echo '</p><p>Author : '.$row['author'];
                    echo '</p><p>Price : '.$row['price'];
                    echo '</p><p>Publisher : '.$row['publisher'];
                    echo '</p><p>Description : '.$row['description'];
                    echo "</p><p></div>";
                ?>
                <form method="post"class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                  <input type="text" name="search" placeholder="Search for Members" class="form-control">
                  <select  id = "se"name="se" value = "se" class="form-control">
                    <option value="FirstName" >Name</option>
                    <option value="Email">Email </option>
                    <option value="Mobile"> Mobile</option>
                    <option value="member_id">Id</option>
                  </select>
                  <input type="submit" class="btn btn-primary" value="Search" name="submit">

                </form>
            
      <?php 
      if(isset($_POST['submit'])){
      $val = $_POST['se'];
      $searchq = $_POST['search'];
      $qu = "SELECT * FROM members WHERE  $val LIKE '%$searchq%'";
      $stmt = $pdo->query($qu);
      echo ("<h4>Search result for : '".$searchq."' in '".$val."' </h4>");
        echo('<table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Member ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead><tbody>');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo('<tr>
                <th scope="row">');
        echo(htmlentities($row['member_id']));
        echo('</th><td>');
        echo(htmlentities($row['FirstName']." ".$row['LastName']));
        echo('</td><td>');
        echo(htmlentities($row['Gender']));
        echo('</td><td>');
        echo(htmlentities($row['Email']));
        echo('</td><td>');
        echo(htmlentities($row['Mobile']));
        echo('</td><td><form method="post">');
        echo('<input type="hidden" name="member_id" value="'.$row['member_id'].'">');
        echo('<input type="submit" class="btn btn-success" name="issue" value="Issue">');
        echo('</form></td></tr>');
    }
    echo('</tbody></table>'); 
  }
  ?>
        </div>
    </div>

  <?php require_once "tail.php" ?>
</body>
</html>