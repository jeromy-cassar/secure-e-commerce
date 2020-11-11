<html>
    <?php
    session_start();
    //if user wishes to logout, reset values and redirect to login page
    if(isset($_POST['logout'])){
        unset($_SESSION['login']);
        unset($_SESSION['username']);
    }
    echo 'Username: '.$_POST['username'].'<br>';
    echo 'Password: '.$_POST['password'].'<br>'; 
    echo 'Hashed Password: '.$_POST['hash_pwd'].'<br>';
    //get client-side values
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_pwd = $_POST['hash_pwd'];
    $pwdLength = strlen($_POST['password']); //length of password

    //validate credentials
        if(empty($username) || empty($password)){
            header("Location: ../client/login.html");
        } elseif($pwdLength < 6){
            header("Location: ../client/login.html");
        } else {
	    $account = $username.','.$hashed_pwd;
	    //check if the account already exists
	    $exist = 0;
        //read the file line by line
        $file = fopen("../database/users.txt","r");
            while(!feof($file))  {
                $line = trim(fgets($file));
                //separate username and password
                list($name, $pass) = explode(",", $line);
                //compare the content of the input and the line
                if($name == $username && $pass == $hashed_pwd) {
			        $exist = 1;
			        break;
	            }			
            }
        fclose($file);	
        //if user exists, redirect the user to the content page and enable login
	    if($exist == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['login'] = true;
            header("Location: ../client/content.php");
            //print_r($_SESSION);
            //echo 'Login Successful! You can now access the <a href="../client/content.php">shopping</a> page!';
        //if the user doesn't exist, redirect them to the login page
        } else {
		    header("Location: ../client/login.html"); //redirect user to login
	        }
        }
    ?>
</html>
