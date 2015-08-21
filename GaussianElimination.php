 <?php
/**
* @class GaussianElimination.php
* 
* Gaussian elimination solver with partial pivoting.  Originally 
* written in Java by Robert Sedgewick and Kevin Wayne:  
*
* @see http://www.cs.princeton.edu/introcs/95linear/GaussianElimination.java.html
*
* Ported to PHP by Paul Meagher
* Maintained by Romel Vera Cadena 
*
* @modified June  12/2007 reimplemented as a GaussianElimination.php class
* @modified March 26/2007 implemented as a function gauss($A, $b)
* @modified August 18/2015 Fixed Epsilon for PHP5 (Romel Vera)
* @version 0.4
*/
class GaussianElimination {
  /**
  * Implements gaussian elimination solver with partial pivoting.
  *
  * @param double[][] $A coefficient matrix
  * @param double[]   $b output vector
  * @return double[]  $x solution vector
  */
  public static function solve($A, $b) {    
    // number of rows
    $N  = count($b);

    // forward elimination
    for ($p=0; $p<$N; $p++) {

      // find pivot row and swap
      $max = $p;
      for ($i = $p+1; $i < $N; $i++)
        if (abs($A[$i][$p]) > abs($A[$max][$p]))
          $max = $i;
      $temp = $A[$p]; $A[$p] = $A[$max]; $A[$max] = $temp;
      $t    = $b[$p]; $b[$p] = $b[$max]; $b[$max] = $t;

	    /** 
		* Smallest deviation allowed in floating point comparisons. 
		*/
		$epsilon=1e-10;
		
      // check if matrix is singular
	  
      if (abs($A[$p][$p]) <= $epsilon) die("Matrix is singular or nearly singular");

      // pivot within A and b
      for ($i = $p+1; $i < $N; $i++) {
        $alpha = $A[$i][$p] / $A[$p][$p];
        $b[$i] -= $alpha * $b[$p];
        for ($j = $p; $j < $N; $j++)
          $A[$i][$j] -= $alpha * $A[$p][$j];
      }
    }

    // zero the solution vector
    $x = array_fill(0, $N-1, 0);

    // back substitution
    for ($i = $N - 1; $i >= 0; $i--) {
      $sum = 0.0;
      for ($j = $i + 1; $j < $N; $j++)
        $sum += $A[$i][$j] * $x[$j];
      $x[$i] = ($b[$i] - $sum) / $A[$i][$i];
    }

    return $x;

  }

}

?> 