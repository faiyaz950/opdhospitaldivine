<?php
error_reporting(0);
session_start();
include("DLL/config.php");
if(isset($_POST['submit']))
{
   if($_POST['email'] != "" && $_POST['password'] != "")
   {
   $sql=mysql_query("select * from admin where email='$_POST[email]'");
   $row=mysql_fetch_array($sql);
		if($row['password'] == $_POST['password'])
		{
		$_SESSION["user_login"]=$row;
			header("Location: show_patients.php");
		  die;
		}
		else{
			$_SESSION["error_msg"]="Plz Check your user id and password !!";
			header("Location: index.php");
			die;		
		}
	}	
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Divine health Care</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    	<link rel="stylesheet" media="screen" href="css/screen.css">


<?php include("theme-head.php"); ?>
</head>

<body class="hms-auth">

    <main class="hms-auth-shell">

        <section class="hms-auth-visual" aria-hidden="true">
            <div class="hms-auth-brand">
                <span class="hms-brand-mark"><i class="fa fa-plus"></i></span>
                <span><?php echo $site_name; ?><small>Hospital Management</small></span>
            </div>

            <div class="hms-auth-hero">
                <h2>Care, coordinated<br><span>from one place.</span></h2>
                <p>Patients, OPD, investigations, IPD, billing and reports for <?php echo $site_name; ?>, all in a single workspace.</p>
            </div>

            <ul class="hms-auth-features">
                <li><i class="fa fa-users"></i><br>Patients &amp; OPD<small>Registration and visits</small></li>
                <li><i class="fa fa-flask"></i><br>Investigations &amp; IPD<small>Reports and admissions</small></li>
                <li><i class="fa fa-line-chart"></i><br>Billing &amp; Reports<small>Income and expense</small></li>
            </ul>
        </section>

        <section class="hms-auth-panel">
            <div class="hms-auth-card" id="main">

                <div class="hms-auth-brand">
                    <span class="hms-brand-mark"><i class="fa fa-plus"></i></span>
                    <span><?php echo $site_name; ?><small>Hospital Management</small></span>
                </div>

                <h1>Admin Login</h1>
                <p class="hms-auth-sub">Sign in to continue to <?php echo $site_name; ?></p>

                <form method="post" action="">
                    <label for="user">Username</label>
                    <div class="hms-field">
                        <input type="text" name="email" id="user" autocomplete="username">
                        <i class="fa fa-user"></i>
                    </div>

                    <label for="pass">Password</label>
                    <div class="hms-field">
                        <input type="password" name="password" id="pass" autocomplete="current-password">
                        <i class="fa fa-lock"></i>
                    </div>

                    <input type="submit" name="submit" value="Login" class="hms-auth-submit">
                </form>
    <?php
	if($_SESSION["error_msg"] != '')
	{
    ?>
	<div id="result" class="warning hms-auth-msg is-error" role="alert"><i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION["error_msg"]; ?></div>
	<?php
	}
	else
	{
	?>
    <div id="result" class="warning hms-auth-msg is-info"><i class="fa fa-info-circle"></i> Please login!</div>
    <?php
     }
	 ?>

                <div class="hms-auth-foot"><i class="fa fa-shield"></i>Secure staff access &middot; <?php echo $site_name; ?></div>
            </div>
        </section>

    </main>

</body>

</html>
