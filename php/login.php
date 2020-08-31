<?php
    include("functions.php");
    include("db-connect.php");
    secure_session_start();

    $error;

    if(isset($_POST['login'])) {
        $user = $_POST['username'];
        $passw = $_POST['password'];
        
        $sql_query = "select username, user_id, password, email from users where username = ?";
        $stmt = $mysql_con->prepare($sql_query);
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username, $user_id, $password, $email);
        $stmt->fetch();
        
        if($stmt->num_rows == 1) {
            if(isset($_POST['remember'])) {
                setcookie("username", $user, strtotime('+7 days'));
                setcookie("password", $passw, strtotime('+7 days'));
            }
            if(password_verify($passw, $password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['email'] = $email;
                header("Location: ../index.php");
                exit();
            } else {
                $error = 'wrong password';
            }   
            
        } else {
            $error = "user doesn't exist";
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
				<a href= "../index.php">
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
					<li>
						<a class= "unactive" href= "mypages.php">Account</a>
					</li>
				</ul>
	        </nav>
			<section>
			    <article>
                    <form action="" method= "post">
                        <div class= "form">
                            <p class="p_form">Username:</p>
                            <input type="text" name="username" value="<?php if(isset($_COOKIE["username"])) {echo $_COOKIE["username"];} else {echo "";} ?>"/>
                        </div>
                        <div class= "form">
                            <p class="p_form">Password:</p>
                            <input type="password" name= "password" value= "<?php if(isset($_COOKIE["password"])) {echo $_COOKIE["password"];} else {echo "";} ?>"/>
                        </div>
                        <div id="register">
                            <input class="input" type="submit" name="login" value="Login"/>
                            <input class="input" type="checkbox" name="remember">
                            <p class="p_form" id="p_remember">Remember me</p>
                        </div>
                    </form>
                    <?php
                        if(isset($error)) {
                            echo $error;
                        }
                    ?>
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
	<script type= "text/javascript" src= "../javascript/jquery.js"></script>
</html>