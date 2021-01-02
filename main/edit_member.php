<?php 
require_once "pdo.php";
require_once "util.php";
    session_start();
    if ( ! isset($_SESSION['user_id'])) {
    	die( '<img src= "./img/access.jpg">');
    return;
    }
    
    if ( isset($_POST['cancel']) ) {
        header('Location: library.php');
        return;
    }

    if ( isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['position']) && isset($_POST['gender']) && isset($_POST['mobile'])&& isset($_POST['email']) && isset($_POST['College'])&& isset($_POST['Address']) && isset($_POST['dob']) && isset($_REQUEST['member_id'])) {

        $msg = validate_edit_members($pdo);
	    if (is_string($msg)){
            $_SESSION['error'] = $msg;
            header("Location: library.php");
            return;
        }

        $sql = "UPDATE members SET 
        FirstName = :fn, 
        LastName = :ln, 
        Position = :po, 
        Gender = :ge, 
        Mobile = :mo, 
        Email = :em, 
        College = :co, 
        Address = :ad, 
        DOB = :dob WHERE member_id = :mid";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':fn' => $_POST['fname'],
            ':ln' => $_POST['lname'],
            ':po' => $_POST['position'],
            ':ge' => $_POST['gender'],
            ':mo' => $_POST['mobile'],
            ':em' => $_POST['email'],
            ':co' => $_POST['College'],
            ':ad' => $_POST['Address'],
            ':dob' => $_POST['dob'],
            ':mid' => $_REQUEST['member_id'])
        );

        $_SESSION['success'] = "Member Updated";
        echo '<script>alert("Member Updated Successfully");
            window.location.replace("library.php");
            </script>';
        // header("Location: library.php");
        return;
    }
    

    $stmt = $pdo->prepare("SELECT * FROM members where member_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['member_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $FirstName = htmlentities($row['FirstName']);
    $LastName = htmlentities($row['LastName']);
    $Position = htmlentities($row['Position']);
    $Gender = htmlentities($row['Gender']);
    $Mobile = htmlentities($row['Mobile']);
    $Email = htmlentities($row['Email']);
    $College = htmlentities($row['College']);
    $Address = htmlentities($row['Address']);
    $DOB = htmlentities($row['DOB']);
    $member_id = htmlentities($_REQUEST['member_id']);
	 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Members</title>
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
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Manage Books
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="add_books.php">Add Books</a>
                  <a class="dropdown-item" href="remove_books.php">Remove Books</a>
                   
              </li>
              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Manage Members
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">Add Member</a>
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
    <div class="container" id="add_members">
        <div class="row row-content">
            <div class="col-12">
                <h1>Add Member</h1>
            </div>
            <div class="col-12 col-md-6">
                <?php 
                    flashMessages();
                ?>
                <form method="post">
                    <div class="form-group row">
                        <label for="fname" class="col-md-2 col-form-label">FirstName</label>
                        <div class="col-md-10">
                            <input type="text" name="fname" id="fname" class="form-control" value="<?=$FirstName ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-md-2 col-form-label">LastName</label>
                        <div class="col-md-10">
                            <input type="text" name="lname" id="lname" class="form-control" value="<?=$LastName ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-md-2 col-form-label">Gender</label>
                        <div class="col-md-10">
                            <select id="sex" name="gender" class="form-control" value="<?=$Gender ?>">
                            <option selected name ="gender">Gender</option>
                            <option value = "Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Trans">Transgender</option>
                    </select>
                        </div>
                    </div>

                    

                    <div class="form-group row">
                        <label for="position" class="col-md-2 col-form-label">Position</label>
                        <div class="col-md-10">
                            <input type="text" name="position" id="position" class="form-control" value="<?=$Position ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobile" class="col-md-2 col-form-label">Mobile</label>
                        <div class="col-md-10">
                            <input type="text" name="mobile" id="mobile" class="form-control" value="<?=$Mobile ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label">email</label>
                        <div class="col-md-10">
                            <input type="text" name="email" id="email" class="form-control" value="<?=$Email ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dob" class="col-md-2 col-form-label">Date of Birth</label>
                        <div class="col-md-10">
                            <input type="date" name="dob" id="dob" class="form-control" value="<?=$DOB ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="College" class="col-md-2 col-form-label">College</label>
                        <div class="col-md-10">
                            <input type="text" name="College" id="College" class="form-control" value="<?=$College ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Address" class="col-md-2 col-form-label">Address</label>
                        <div class="col-md-10">
                            <textarea name="Address" rows="5" cols="80" class="form-control"><?=$Address ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10">
                        <!-- <input type="submit" value="Add">
                        <input type="submit"value="Cancel" name="cancel"> -->
                        <input type="submit" class="btn btn-primary" value="Add">
                        <input type="submit" class="btn btn-secondary" name="cancel" value="Cancel">
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once "tail.php" ?>
</body>
</html> 