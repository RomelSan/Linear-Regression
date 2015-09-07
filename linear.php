<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Linear Regression</title>
		<script type="text/javascript" src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=AM_HTMLorMML-full"></script>
		<!-- Bootstrap -->
			<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="bootstrap/js/jquery-1.11.3.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</head>
<body>
<div class="container">
<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
// Check if there are values to Solve
if (!isset($_POST['Xf']))
	{
		die("Input Value for X is required");
	}
	
	if ( strlen( $_POST[ 'Xf' ] ) <= 0 )
	{
	die("Input Value for X is required");
	}
	
if (!isset($_POST['Yf']))
	{
		die("Input Value for Y is required");
	}
	
	if ( strlen( $_POST[ 'Yf' ] ) <= 0 )
	{
	die("Input Value for X is required");
	}
	
if (!isset($_POST['Find']))
	{
		die("Input Value for Find is required");
	}
	
	if ( strlen( $_POST[ 'Find' ] ) <= 0 )
	{
	die("Input Value for Find is required");
	}
// End Check if there are values to Solve

$Xf=$_POST['Xf'];
$Yf=$_POST['Yf'];
$Findx=$_POST['Find'];
 
$x=explode(",", $Xf);  // X Variable into Array
$y=explode(",", $Yf); // Y Variable into Array

if (count($x) != count($y)) //Check that number of elements are exact for X and Y
{
	die("Number of elements in X does not equal number of elements in Y");
}

// Check for numbers only
foreach ($x as $testcase)  // X values
	{
		if (is_numeric($testcase)) 
			{
				// echo "The string $testcase consists of all numbers.\n";
			} 
		else 
			{
				// echo "The string $testcase does not consist of numbers.\n";
				die("Check input of X variable. Enter numeric values only");
			}
	}
	
foreach ($y as $testcase2) // Y values
	{
		if (is_numeric($testcase2)) 
			{
				// echo "The string $testcase consists of all numbers.\n";
			} 
		else 
			{
				// echo "The string $testcase does not consist of numbers.\n";
				die("Check input of Y variable. Enter numeric values only");
			}
	}
	
if (!is_numeric($Findx)) 
			{
				die("Check input of entry to find. Enter numeric values only");
			} 
// End Check for numbers
 
// Regression Solver Code
$find=$Findx; // value to find using final equation
$n=count($x); // Number of elements
$sum_y=0;$sum_yy=0;$sum_xy=0;$sum_x=0;$sum_xx=0; // Total Sum Variables

for($i=0;$i<$n;$i++) // Get Squares X and Y
{
 $xx[$i]=$x[$i]*$x[$i]; // Xi^2
 $yy[$i]=$y[$i]*$y[$i]; // Yi^2
}

for($i=0;$i<$n;$i++) // Get Sum totals
{
 $sum_x +=$x[$i]; // total x
 $sum_y +=$y[$i]; // total y
 $sum_xx +=$xx[$i]; // total x^2
 $sum_xy +=$x[$i]*$y[$i]; // total (Xi)(Yi)
}

$nr=($n*$sum_xy)-($sum_x*$sum_y); // get first row of "a" -> n(XiYi) - XiYi
$sum_x2=$sum_x*$sum_x; // Get (Xi) square
$dr=($n*$sum_xx)-$sum_x2; // // Get second row of "a" -> n(Xi^2) - (Xi)^2
$res=$nr/$dr; // Make the division of "a" row 1 and row 2 --> this is the slope
$slope=$res; // "a" --> this is the slope
$intercept=($sum_y -($slope*$sum_x))/$n; // "b" value -> [Yi - (a) (Xi)] / n
$reg= $intercept + ($slope*$find); // Regression Result -> a(x) + b

//Decimals Round (up to 7 decimals)
$sum_x=round($sum_x,7);
$sum_xx=round($sum_xx,7);
$sum_y=round($sum_y,7);
$sum_xy=round($sum_xy,7);
$sum_x2=round($sum_x2,7);
$slope=round($slope,7);
$intercept=round($intercept,7);
$reg=round($reg,7);

//-------------------------------------------------------------------------------

echo "
<p style=\"text-align:center\">`n=`Number of total elements
<br>
`n=$n`
<br>
`sum_(i=1)^nx_i=$sum_x`
<br>
`sum_(i=1)^ny_i=$sum_y`
<br>
`sum_(i=1)^nx_i^2=$sum_xx`
<br>
`sum_(i=1)^nx_iy_i=$sum_xy`
</p>
<p style=\"text-align:center\">
  `a=((n)(sum_(i=1)^nx_iy_i)-(sum_(i=1)^nx_i)(sum_(i=1)^ny_i))/((n)(sum_(i=1)^nx_i^2)-(sum_(i=1)^nx_i)^2)`
  <br>
  <br>
  `a=(($n)($sum_xy)-($sum_x)($sum_y))/(($n)($sum_xx)-($sum_x2))`
  <br>
  <br>
  `a=$slope`
</p>
<p style=\"text-align:center\">
`b=((sum_(i=1)^ny_i)-(a)(sum_(i=1)^nx_i))/(n)`
  <br>
  <br>
`b=($sum_y-$slope($sum_x))/($n)`
  <br>
  <br>
`b=$intercept`
</p>
<p style=\"text-align:center\">
`:.`The linear Equation is:
<br>
`y=ax+b`
<br>
`y($find)=$slope($find)+($intercept)`
<br>
`y($find)=$reg`
</p>
";
?>
</div> 
</body>
</html>