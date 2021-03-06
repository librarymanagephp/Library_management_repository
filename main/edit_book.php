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

    if ( isset($_POST['title']) && isset($_POST['author']) && isset($_POST['price']) && isset($_POST['publisher'])  && isset($_REQUEST['ISBN'])) {

        $msg = validate_edit_books();
	    if (is_string($msg)){
            $_SESSION['error'] = $msg;
            header("Location: edit_book.php?ISBN=".$_REQUEST['ISBN']);
            return;
        }

        // $sql = "INSERT INTO books (title, author, price, publisher, description, available, total)
        //             VALUES (:ti, :au, :pr, :pu, :desc, :ava, :ava)";
        $sql = "UPDATE books SET
                    title = :ti,
                    author = :au,
                    price = :pr,
                    publisher = :pu,
                    description = :desc WHERE ISBN = :isbn";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':ti' => $_POST['title'],
            ':au' => $_POST['author'],
            ':pr' => $_POST['price'],
            ':pu' => $_POST['publisher'],
            ':desc' => $_POST['description'],
            ':isbn' => $_REQUEST['ISBN'])
        );

        $_SESSION['success'] = "Book Updated";
        echo '<script>alert("Book Updated Successfully");
              window.location.replace("library.php");
            </script>';
		// header("Location: library.php");
		return;
    }
    

    $stmt = $pdo->prepare("SELECT * FROM books where ISBN = :xyz");
    $stmt->execute(array(":xyz" => $_GET['ISBN']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $title = htmlentities($row['title']);
    $author = htmlentities($row['author']);
    $price = htmlentities($row['price']);
    $publisher = htmlentities($row['publisher']);
    $description = htmlentities($row['description']);
    // $available = htmlentities($row['available']);
    // $total = htmlentities($row['total']);
    $ISBN = htmlentities($_REQUEST['ISBN']);
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
              <li class="nav-item">
                <a class="nav-link" href="library.php">Home</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="search_books.php">Search Books</span></a>
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
		          <a class="dropdown-item" href="approve_members.php">Appove Member</a>
		          <a class="dropdown-item" href="view_members.php">View Member</a>
		      </li>
            </ul>
            <span class="navbar-text">
                <a id="loginbutton" href="logout.php">Logout</a>
            </span>
          </div>
        </div>
    </nav>
    <div class="container" id="add_books">
        <div class="row row-content">
            <div class="col-12">
                <h1>Edit Books</h1>
            </div>
            <div class="col-12 col-md-6">
                <?php 
                    flashMessages();
                ?>
                <form method="post">
                    <div class="form-group row">
                        <label for="title" class="col-md-2 col-form-label">Title</label>
                        <div class="col-md-10">
                            <input type="text" name="title" id="title" class="form-control" value="<?= $title ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="author" class="col-md-2 col-form-label">Author</label>
                        <div class="col-md-10">
                            <input type="text" name="author" id="author" class="form-control" value="<?= $author ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="price" class="col-md-2 col-form-label">Price</label>
                        <div class="col-md-10">
                            <input type="text" name="price" id="price" class="form-control" value="<?= $price ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="publisher" class="col-md-2 col-form-label">Publisher</label>
                        <div class="col-md-10">
                            <input type="text" name="publisher" id="publisher" class="form-control" value="<?= $publisher ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-2 col-form-label">Description</label>
                        <div class="col-md-10">
                            <textarea name="description" rows="5" cols="80" class="form-control"><?= $description ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10">
                        <input type="submit" class="btn btn-primary" value="Update">
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