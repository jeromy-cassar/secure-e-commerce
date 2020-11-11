<?php
session_start();
//if user's session has expired, redirect to login 
if(!isset($_SESSION['login'])) {
    header("Location: login.html");
}
?>
<html>
    <head>
        <title>INTE1071 Secure E Commerce</title>
    </head>
    <script type="text/javascript" src="js/des.js"></script>
    <script type="text/javascript" src="js/rsa.js"></script>
    <script>
          var qtyA;
          var qtyB;
          var qtyC;
          function getQtyA(){
            //A
            //if input is less than 0, set the input value to 0
            if(document.getElementById('qtyA').value < 0){
                document.getElementById('qtyA').value = 0;
            }
            qtyA = document.getElementById('qtyA').value;

            //calculate total for Product A
            document.getElementById('totalA').innerHTML = 10*qtyA;

            //calculate and display total quantity
            var totalQty = parseInt(document.getElementById('qtyA').value) + parseInt(document.getElementById('qtyB').value) + parseInt(document.getElementById('qtyC').value);
            document.getElementById('totalQty').innerHTML = totalQty;

            //calculate total price
            var totalCost = parseInt(document.getElementById('totalA').innerHTML) + 
            parseInt(document.getElementById('totalB').innerHTML) + parseInt(document.getElementById('totalC').innerHTML);
            document.getElementById('total').innerHTML = totalCost;
          }
          function getQtyB(){
            //B
            //if input is less than 0, set the input value to 0
            if(document.getElementById('qtyB').value < 0){
                document.getElementById('qtyB').value = 0;
            }
            qtyB = document.getElementById('qtyB').value;

            //calculate total for Product B
            document.getElementById('totalB').innerHTML = 15*qtyB;

            //calculate and display total quantity
            var totalQty = parseInt(document.getElementById('qtyA').value) + parseInt(document.getElementById('qtyB').value) + parseInt(document.getElementById('qtyC').value);            document.getElementById('totalQty').innerHTML = totalQty;

            //calculate total price
            var totalCost = parseInt(document.getElementById('totalA').innerHTML) + 
            parseInt(document.getElementById('totalB').innerHTML) + parseInt(document.getElementById('totalC').innerHTML);
            document.getElementById('total').innerHTML = totalCost;
          }
          function getQtyC(){
            //C
            //if input is less than 0, set the input value to 0
            if(document.getElementById('qtyC').value < 0){
                document.getElementById('qtyC').value = 0;
            }
            qtyC = document.getElementById('qtyC').value;

            //calculate total for Product C
            document.getElementById('totalC').innerHTML = 20*qtyC;

            //calculate and display total quantity
            var totalQty = parseInt(document.getElementById('qtyA').value) + parseInt(document.getElementById('qtyB').value) + parseInt(document.getElementById('qtyC').value);
            document.getElementById('totalQty').innerHTML = totalQty;

            //calculate total price
            var totalCost = parseInt(document.getElementById('totalA').innerHTML) + 
            parseInt(document.getElementById('totalB').innerHTML) + parseInt(document.getElementById('totalC').innerHTML);
            document.getElementById('total').innerHTML = totalCost;
          }
          function validate(){
            var submit = "true";
            //check if fields are zero or less than zero
            if(document.getElementById('qtyA').value <= 0 || document.getElementById('qtyB').value <= 0 || document.getElementById('qtyC').value <= 0){
                submit = "false";
                alert("invalid integer");
            }
            //check if fields are empty 
            if(document.getElementById('qtyA').value == "" || document.getElementById('qtyB').value == "" || document.getElementById('qtyC').value == ""){
                submit = "false";
                alert("empty");
            }
            //check if fields are non-integer values
            if(isNaN(document.getElementById('qtyA').value) || isNaN(document.getElementById('qtyB').value) || isNaN(document.getElementById('qtyC').value)){
                submit = "false";
                alert("Non-integer values");
            }
            //check if input is above maximum
            if(document.getElementById('qtyA').value > 20 || document.getElementById('qtyB').value > 20 || document.getElementById('qtyC').value > 20){
                submit = "false";
                alert("value too high");
            }
            //check if input is correct
            if(submit=="false"){
                return false;
            }
            if(submit=="true"){
                return true;
                alert("successful");
            }
          }
        function DES_encryption() {
		    var message = document.getElementById("credit_card").value;
			var key = document.getElementById("DES_key").value;
			var encrypted = javascript_des_encryption(key, message);
			document.getElementById("encrypted_credit_card").value = encrypted;
        }
        function RSA_encryption(){
            var plaintext = document.getElementById("DES_key").value;
            var public_key = "-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzdxaei6bt/xIAhYsdFdW62CGTpRX+GXoZkzqvbf5oOxw4wKENjFX7LsqZXxdFfoRxEwH90zZHLHgsNFzXe3JqiRabIDcNZmKS2F0A7+Mwrx6K2fZ5b7E2fSLFbC7FsvL22mN0KNAp35tdADpl4lKqNFuF7NT22ZBp/X3ncod8cDvMb9tl0hiQ1hJv0H8My/31w+F+Cdat/9Ja5d1ztOOYIx1mZ2FD2m2M33/BgGY/BusUKqSk9W91Eh99+tHS5oTvE8CI8g7pvhQteqmVgBbJOa73eQhZfOQJ0aWQ5m2i0NUPcmwvGDzURXTKW+72UKDz671bE7YAch2H+U7UQeawwIDAQAB-----END PUBLIC KEY-----";
            //encrypt with public key
            var encrypt = new JSEncrypt();
            encrypt.setPublicKey(public_key);
            var encrypted = encrypt.encrypt(plaintext);
            document.getElementById("encrypted_DES").value = encrypted;
        }
      </script>
    <body>
        <?php echo 'Welcome, '.$_SESSION['username'].'!';?><br>
        <form action = "login.html" method="POST">
            <input type="submit" name="logout" id="logout" value="Logout">
        </form>
        <h2>Shopping</h2>
        <br>
        <form method="POST" action="../server/cart.php" onsubmit="return validate();">
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
                <th><input type="number" value="0" id="qtyA" name="qtyA" oninput="getQtyA();"></th>
                <th name="totalA" id="totalA">0</th>
            </tr>
            <tr>
                <th>Product B</th>
                <th>$15</th>
                <th><input type="number" id="qtyB" name="qtyB" value="0" oninput="getQtyB();"></th>
                <th name="totalB" id="totalB">0</th>
            </tr>
            <tr>
                <th>Product C</th>
                <th>$20</th>
                <th><input type="number" id="qtyC" name="qtyC" value="0" oninput="getQtyC();"></th>
                <th name="totalC" id="totalC">0</th>
            </tr>
            <tr>
                <th></th>
                <th>Total</th>
                <th name="totalQty" id="totalQty">0</th>
                <th name="total" id="total">0</th>
            </tr>
            <tr>
                <th colspan="4">DES Key: <input type="text" name="DES_key" required id="DES_key" placeholder="Enter DES Key"></th>
            </tr>
            <tr>
                <th colspan="4">Credit Card Number: <input type="text" required name="credit_card" id="credit_card" placeholder="Enter credit card"></th>
            </tr>
            <tr>
                <th></th>
                <th><input type="hidden" name="encrypted_DES" id="encrypted_DES"></th>
                <th><input type="hidden" name="encrypted_credit_card" id="encrypted_credit_card"></th>
                <th><input type="submit" value="Submit" onclick="DES_encryption(); RSA_encryption();"></th>
            </tr>
        </table>
        </form>
    </body>
</html>