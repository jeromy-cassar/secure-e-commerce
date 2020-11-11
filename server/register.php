<html>
    <?php
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
            header("Location: ../client/register.html");
        } elseif($pwdLength < 6){
            header("Location: ../client/register.html");
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
                if($name == $username) {
			        $exist = 1;
			        break;
	            }			
            }
        fclose($file);	
        //if user exists, redirect the user to the register page
	    if($exist == 1) {
		    header("Location: ../client/register.html");
        //if the user doesn't exist, write the new account to the file and redirect them to the login page
        } else {
		    //open users text files
		    $file = fopen("../database/users.txt","a");
		    //write account to file with line-by-line character
		    fwrite($file,$account."\n");
		    //close file
		    fclose($file);
		    header("Location: ../client/login.html"); //redirect user to login
	        }
        }
    ?>
</html>
