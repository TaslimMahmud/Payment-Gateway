<?php
$con=mysqli_connect('localhost','root','','payment');
if (isset($_POST['payment']) && $_POST['amt'] >=99) {
    $name=$_POST['name'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $phone=$_POST['phone'];
    $amount=$_POST['amt'];
    include 'ssl/ssl.php';
    $api = new ssl/ssl('asttr61f16540f0fd1', 'asttr61f16540f0fd1@ssl', 'https://sandbox.sslcommerz.com/gwprocess/v3/api.php');
    try {
        $response = $api->paymentRequestCreate(array(
    
            "user_name" => $name,
            "email" => $email,
            "address" => $address,
            "phone" => $phone,
            "amount" => $amount,
            
            
            ));
       // print_r($response);
        $url=$response['longurl'];
        header("location:$url");
        }
        catch (Exception $e) {
            print('Error: ' . $e->getMessage());
        }
        $query="INSERT INTO transaction (name,email,address,phone,amount) VALUES ('$name','$email','$address','$phone','$amount')";
        $run=mysqli_query($con,$query);
    }
?>