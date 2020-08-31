<?php
    include("functions.php");
    include("db-connect.php");
    secure_session_start();

    $error;
	$result = $mysql_con->query("select title, content, category_id, date, user_id from posts where user_id=".$_SESSION["user_id"]);

    if(!is_logged_in()) {
    	header("Location: login.php");
    	exit();
    }

    if(isset($_POST["sub"])) {
    	if($_POST["password"] == $_POST["r_password"]) {
    		$user = $_POST['username'];
	        $passw = password_hash($_POST['password'], PASSWORD_BCRYPT);

	        if(username_available($user, "null", $mysql_con)) {
	            $stmt = $mysql_con->prepare("update users set username=?, password=? where user_id=?");
	            $stmt->bind_param("sss", $user, $passw, $_SESSION["user_id"]);
	            $stmt->execute();
	            header("Location: logout.php");
	            exit();
	        } else {
	            $error = "username is unavailable";
	        }
    	} else {
    		$error = "passwords do not match";
    	}
    }
?>

<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" href="../css/stilmall.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:700,300' rel='stylesheet' type='text/css'>
		<title>Teknik projekt</title>
    </head>
    <body>
        <div id= "wrapper"> <!-- Innehåll -->
            <header>
				<a href= "../index.html">
					<h1>Forum</h1>
				</a>
            </header>
            <nav>
				<ul>
                    <a href="<?php if(is_logged_in()) {echo 'logout.php';} else {echo 'login.php';} ?>"><?php if(is_logged_in()) {echo 'Logout';} else {echo 'Login';} ?></a>
					<li>
						<a class= "unactive" href= "../index.php">Start</a>
					</li>
					<li>
						<a class= "unactive" href= "register.php">Register</a>
					</li>
					<li id= "active">
						<a href= "mypages.php">Account</a>
					</li>
				</ul>
	        </nav>
			<section>
			    <article>
					<div id= "redigera">
						<h2>Edit Account</h2>
						<form action="" method= "post">
	                        <div class= "form">
	                            <p class="p_form">Username:</p>
	                            <input type="text" name="username"/>
	                        </div>
	                        <div class= "form">
	                            <p class="p_form">Password:</p>
	                            <input type="password" name= "password"/>
	                        </div>
	                        <div class="form">
	                            <p class="p_form">Repeat Password:</p>
	                            <input type="password" name="r_password"/>
	                        </div>
	                        <div class="form">
	                            <input type="submit" name="sub" value="change"/>
	                        </div>
	                    </form>
					</div>
					<?php
                        if(isset($error)) {
                            echo $error;
                        }
                    ?>
					<div>
						<h2>My posts</h2>
						<?php
							show_posts($result, $mysql_con);
						?>
					</div>
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
					<li>
						
					</li>
				</ul>
				<div id= "copyright">
					<p>&copy; 2016 Ruben H. Hume</p>
				</div>
			</footer>
        </div>
    </body>
	<script type= "text/javascript" src= "javascript/jquery.js"></script>
</html>