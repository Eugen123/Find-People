<html>
<head>
<title> tema</title>
</head>

<body>
<?php

$n=3;
$Hn=array();
$ln=array();
$i=1;
do
{

	for($j=1;$j<$n+2;$j++)
	{
	
		array_push($ln, 1/($i+$j-1));
	}
	$i++;
	
	array_push($Hn, $ln);
	unset($ln);
	$ln= array();
}while ($i<$n+2) ;
$i=1;
$j=1;
for($i=0;$i<$n;$i++)
{
	for($j=0;$j<$n;$j++)
	{

		echo round($Hn[$i][$j],3);
	echo "\t";

	}
	echo "<br />";
}


$l=array();



for($i=0;$i<$n;$i++)
{
	for ($k=0; $k < $n; $k++) 
	{ 
		$sum1=0;
		for ($j=0; $j < $i-1; $j++) { 
		$sum1 += pow($l[$i][$j], 2);
 	}
 		$sum=0;
		for($j=1;$j<$k-1;$j++)
			$sum+=$l[$i][$j] * $l[$k][$j]; 
		array_push($l, 1/sqrt($Hn[$i][$i] - $sum1) * ($Hn[$i][$j] - $sum));
	}
}

$sum=0;
for($i=0; $i<$n; $i++)
{
	for ($j=0; $j < $i-1; $j++) { 
		$sum += pow($l[$i][$j], 2);
 	}
	echo "l[$i][$i]= " + round(sqrt($Hn[$i][$i] - $sum),3) - 1;
	echo "\t"; 
}
?>
</body>
</html>