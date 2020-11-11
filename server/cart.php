<?php
session_start();
include('rsa.php');
include('des.php');
//if user's session has expired, redirect to login 
if(!isset($_SESSION['login'])) {
    header("Location: ../client/login.html");
}
//--GET POST DATA--
//assign variables to variables
$qtyA = $_POST['qtyA'];
$qtyB = $_POST['qtyB'];
$qtyC = $_POST['qtyC'];
//calculate subtotals
$subtotalA = $qtyA * 10;
$subtotalB = $qtyB * 15;
$subtotalC = $qtyC * 20;
//calculate total cost
$total_cost = $subtotalA + $subtotalB + $subtotalC;
//calculate total quantity
$total_qty = $qtyA + $qtyB + $qtyC;
?>
<html>
    <head>
        <title>INTE1071 Secure E Commerce</title>
    </head>
    <body>
        <?php echo 'Welcome, '.$_SESSION['username'].'!';?><br>
        <form action = "../client/login.html" method="POST">
            <input type="submit" name="logout" id="logout" value="Logout">
        </form>
        <h2>Cart</h2>
        <br>
        <table style="border-spacing:5px;">
            <tr>
                <th>Products</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <tr>
                <th>Product A</th>
                <th>$10</th>
                <th><?= $qtyA ?></th>
                <th><?= $subtotalA ?></th>
            </tr>
            <tr>
                <th>Product B</th>
                <th>$15</th>
                <th><?= $qtyB ?></th>
                <th><?= $subtotalB ?></th>
            </tr>
            <tr>
                <th>Product C</th>
                <th>$20</th>
                <th><?= $qtyC ?></th>
                <th><?= $subtotalC ?></th>
            </tr>
            <tr>
                <th></th>
                <th>Total</th>
                <th><?= $total_qty ?></th>
                <th><?= $total_cost ?></th>
            </tr>
        </table>
        </form>
        <br>
        Received DES Key:
        <?php 
            $encrypted_DES = $_POST['encrypted_DES'];
            echo $encrypted_DES; //print the encrypted DES key 
        ?>
        <br><br>
        Decrypted DES Key:
        <?php
            //--decrypt the DES key via RSA server-side--
            //get RSA private key
            $privateKey = get_rsa_privatekey('private.key');
            //compute decrypted value
            $decrypted_DES = rsa_decryption($encrypted_DES, $privateKey);
            echo $decrypted_DES; //print the decrypted DES key
        ?><br><br>
        Received Credit Card information:
        <?php
            $encrypted_credit_card = $_POST['encrypted_credit_card'];
            echo $encrypted_credit_card; //print encrypted credit card   
        ?><br><br>
        Decrypted Credit Card informaton:
        <?php
            //--decrypt the credit card information via DES server-side--
            $decrypted_credit_card = php_des_decryption($decrypted_DES, $encrypted_credit_card);
            echo $decrypted_credit_card; //print the decrypted credit card

            $data = 
            "Product A:".$qtyA.','.$subtotalA." (10 each)"."\n".
            "Product B:".$qtyB.','.$subtotalB." (15 each)"."\n".
            "Product C:".$qtyC.','.$subtotalC." (20 each)"."\n";    
            //--write the order into the text file--
            //open file
            $file = fopen('../database/orders.txt', "a");
            //write order to text file
            fwrite($file,
            "------------------------------"."\n".
            "Username: ".$_SESSION['username']."\n".
            "ORDER:"."\n".
            $data.
            "Total: ".$total_cost."\n".
            "Credit Card Number: ".$decrypted_credit_card."\n".
            "------------------------------");
            //close the file
            fclose($file);
            echo "<br>Your order has been added to the users.txt file. Check the text file for your order <a href='../database/orders.txt'>here.</a>";
        ?>
    </body>
</html>