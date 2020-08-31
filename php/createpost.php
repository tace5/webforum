<?php
    include("functions.php");
    include("db-connect.php");
    secure_session_start();
    if(!is_logged_in()) {
        header("Location: login.php");
    } else {
        if(isset($_POST["create_post"])) {
            $title = $_POST["title"];
            $text = $_POST["content"];
            $user_id = $_SESSION["user_id"];
            
            $category = $_POST["category"];
            $stmt = $mysql_con->prepare("select category_id from categories where title=?");
            $stmt->bind_param('s', $category);
            $stmt->execute();
            $stmt->bind_result($category_id);
            $stmt->fetch();
            
            if(isset($_POST["title"], $_POST["category"])) {
                $stmt->prepare("insert into posts (title, content, category_id, user_id) values (?, ?, ?, ?)");
                $stmt->bind_param("ssii", $title, $text, $category_id, $user_id);
                $stmt->execute();
                header("Location: ../index.php");
            } else {
                echo "Please fill in title and category!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang= "sv">
    <head>
        <meta charset= "utf-8"/>
		<meta name= "viewport" content= "width=device-width, initial-scale=1">
	    <link rel= "stylesheet" href= "../css/stilmall.css">
		<link rel= "stylesheet" href= "../css/imgslider_css.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:700,300' rel='stylesheet' type='text/css'>
		<title>Teknik projekt</title>
    </head>
    <body>
        <div id= "wrapper"> <!-- Innehåll -->
            <header>
				<a href= "../index.php">
					<img src= "../bilder/kugghjul_ikon.png">
					<h1>Forum</h1>
				</a>
            </header>
            <nav>
				<ul>
                    <a href="<?php if(is_logged_in()) {echo 'logout.php';} else {echo 'login.php';} ?>"><?php if(is_logged_in()) {echo 'Logout';} else {echo 'Login';} ?></a>
					<li>
						<a class="unactive" href= "../index.php">Start</a>
					</li>
					<li>
						<a class= "unactive" href= "register.php">Registrera</a>
					</li>
					<li>
						<a class= "unactive" href= "mypages.php">Konto</a>
					</li>
				</ul>
	        </nav>
			<section>
			    <article id= "index_article">
                    <form action="" method="post">
                        <div>
                            <p>Title:</p>
                            <input id="title" name="title"/>
                        </div>
                        <div>
                            <p>Category:</p>
                            <select name="category">
                                <?php
                                    $result = $mysql_con->query("select title from categories");
                                    while($r = mysqli_fetch_assoc($result)) {
                                ?>
                                <option value="<?php echo $r["title"] ?>"><?php echo $r["title"] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div>
                            <p>Text:</p>
                            <textarea id="content" name="content"></textarea>
                        </div>
                        <input type="submit" name="create_post" value="Submit"/>
                    </form>
			    </article>
			</section>
			<footer>
			    <ul>
					<li>
						<a class= "ikoner" href= "https://twitter.com/rubenhume"><img src= "../bilder/twitter.png"></a>
					</li>
					<li>
						<a class= "ikoner" href= "mailto: ruben.hume@live.se"><img src= "../bilder/email.png"></a>
					</li>
				</ul>
				<div id= "copyright">
					<p>&copy; 2016 Ruben H. Hume</p>
				</div>
			</footer>
        </div>
		<script type= "text/javascript" src= "javascript/jquery.js"></script>
		<script type= "text/javascript" src= "javascript/jquery.slides.min.js"></script>
		<script type= "text/javascript" src= "javascript/jquery.slides_2.js"></script>
		<script type= "text/javascript" src= "javascript/scrolltotop.js"></script>
    </body>
</html>