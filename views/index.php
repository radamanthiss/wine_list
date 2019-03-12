<?php
require_once '../vendor/autoload.php';
include '../controllers/db_connect.php';
?>

<!doctype html>
<html>
<head>
<title>Wine</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Sublime Contact Form Widget Responsive, Login form web template,Flat Pricing tables,Flat Drop downs  Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- fonts -->
<link href="//fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Muli:300,400" rel="stylesheet">

<!-- /fonts -->

<!-- css -->
<link rel="shortcut icon" href="../public/images/favicon.ico">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="Stylesheet" href="../public/css/style.css" />
<!-- /css -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body style="padding-top: 50px;">
<div class="content-w3ls agileits w3 wthree w3-agile w3-agileits agileinfo agile container">
<h1 class="agileits w3 wthree w3-agile w3-agileits agileinfo agile">WINE LIST</h1>
<form action="validacion.php" method="post" class="form-agileits" id="formulario" name="formulario" >
	<div class="form-group" >
    	<select id="list_wine" class="form-control" name="wines">
    	<?php 
    	    $conn = db_connect();
    	    $query = $conn->query("SELECT * FROM wine");
            while($valores = mysqli_fetch_array($query)){
                echo '<option value="'.$valores["title"].'">'.$valores["title"].'</option>';
            }
        ?>
    	
    	</select>
    </div>
     <div class="form-group" >
        <div class="col-md-12 text-center" >
            <button type="submit" class="btn btn-primary btn-lg" style="margin-bottom: 10px;">Submit</button>
        </div>
    </div>
		
</form>

</div>


</body>
</html>