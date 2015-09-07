<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Non Linear Regression</title>
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
include "GaussianElimination.php";
$find=$Findx; // value to find using final equation
$n=count($x); // Number of elements
$sum_y=0;$sum_yy=0;$sum_xy=0;$sum_x=0;$sum_xx=0;$sum_xxx=0;$sum_xxxx=0;$sum_x2y=0; // Total Sum Variables

for($i=0;$i<$n;$i++) // Get Squares X and Y
{
 $xx[$i]=$x[$i]*$x[$i]; // Xi^2
 $yy[$i]=$y[$i]*$y[$i]; // Yi^2
 $xxx[$i]=$x[$i]*$x[$i]*$x[$i]; // Xi^3
 $xxxx[$i]=$x[$i]*$x[$i]*$x[$i]*$x[$i]; // Xi^4
}

for($i=0;$i<$n;$i++) // Get Sum totals
{
 $sum_x +=$x[$i]; // total x
 $sum_y +=$y[$i]; // total y
 $sum_xx +=$xx[$i]; // total x^2
 $sum_xy +=$x[$i]*$y[$i]; // total (Xi)(Yi)
 $sum_xxx +=$xxx[$i]; // total x^3
 $sum_xxxx +=$xxxx[$i]; // total x^4
 $sum_x2y +=$xx[$i]*$y[$i]; // total (Xi)^2(Yi)
}

// A is the matrix value in order
$A = array(array($sum_xxxx, $sum_xxx, $sum_xx),
           array($sum_xxx, $sum_xx, $sum_x),
           array($sum_xx, $sum_x, $n));
  
// b is the result... (values after "=" )  
$b = array($sum_x2y, $sum_xy, $sum_y);

$g = new GaussianElimination;

$coe = $g->solve($A, $b); // Contains coefficient values
$solution_A=$coe[0]; //A
$solution_B=$coe[1]; //B
$solution_C=$coe[2]; //C
$find2=$find*$find;// find^2

$ax2=$solution_A*$find2; // Ax^2
$bx=$solution_B*$find; // Bx
$c=($solution_C); // C
$reg=$ax2+$bx+$c; // Regression result: Ax^2+Bx+C

//Decimals Round (up to 7 decimals)
$sum_x=round($sum_x,7);
$sum_xx=round($sum_xx,7);
$sum_xxx=round($sum_xxx,7);
$sum_xxxx=round($sum_xxxx,7);
$sum_y=round($sum_y,7);
$sum_xy=round($sum_xy,7);
$sum_x2y=round($sum_x2y,7);
$solution_A=round($solution_A,7);
$solution_B=round($solution_B,7);
$solution_C=round($solution_C,7);
$find2=round($find2,7);
$ax2=round($ax2,7);
$bx=round($bx,7);
$c=round($c,7);
$reg=round($reg,7);
//-------------------------------------------------------------------------------

echo "
<p style=\"text-align:center\">`n=`Number of total elements
<br>
`n=4`
</p>
<p style=\"text-align:center\">
  `(sum_(i=1)^nx_i^4)a+(sum_(i=1)^nx_i^3)b+(sum_(i=1)^nx_i^2)c=(sum_(i=1)^nx_i^2y_i)`  
  <br>
	`($sum_xxxx)a+($sum_xxx)b+($sum_xx)c=($sum_x2y)`
</p>
<p style=\"text-align:center\">
`(sum_(i=1)^nx_i^3)a+(sum_(i=1)^nx_i^2)b+(sum_(i=1)^nx_i)c=(sum_(i=1)^nx_iy_i)`
<br>
`($sum_xxx)a+($sum_xx)b+($sum_x)c=($sum_xy)`
</p>
<p style=\"text-align:center\">
`(sum_(i=1)^nx_i^2)a+(sum_(i=1)^nx_i)b+(n)c=(sum_(i=1)^ny_i)`
<br>
`($sum_xx)a+($sum_x)b+($n)c=($sum_y)`
</p>
<p style=\"text-align:center\">
`:.`Solving the system of linear equations:
<br>
`a=$solution_A`
<br>
`b=$solution_B`
<br>
`c=$solution_C`
</p>
<p style=\"text-align:center\">
`:.`The equation of the curve is:
<br>
`y=ax^2+bx+c`
<br>
`y($find)=($solution_A)($find2)+($solution_A)($find)+($solution_C)`
<br>
`y($find)=$reg`
</p>
";
?>
</div>
</body>
</html>