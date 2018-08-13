<?php
//jedenfalls
//12-08-2012
//normal distribution

//include charting libraries
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_bar.php');

include 'connect.php';
$module = $_GET['module'];

$checka = mysql_fetch_array(mysql_query("SELECT `Title` FROM modules WHERE `Code` = '$module'"));

//look up key
$selotele = $checka[0];

//shorten module titles with ‘introduction to’ in them
$matakala  = substr(str_ireplace("Introduction to ", "", $selotele),0,12);

#############
// Some nonrandom data

$retrieve_marks = mysql_query("SELECT `mark` FROM `exams` WHERE `modcode`='$module' AND `year`='2013'");
while($row = mysql_fetch_array($retrieve_marks)){
      $marks[] = $row[0];
}

//calculate standard deviation of the marks array
function standard_deviation($marks){
	if(is_array($marks)){
		$mean = array_sum($marks) / count($marks);
		foreach($marks as $key => $num) $devs[$key] = pow($num - $mean, 2);
		return sqrt(array_sum($devs) / (count($devs) - 1));
	}
}

$stdev = standard_deviation($marks);
$count = count($marks);
$mean = array_sum($marks) / $count;

 sort($marks);

$first = $marks[0];
$firstus = $marks[0];
$cc = $count-1;
$last = $marks[$cc];

 //interpolate where $start would be equal to 0.00005

 /* $start = 0;
  if(($start >-1)&&($start < $firstal>0.0005)){
   $norm[] = (1/ (sqrt(2*pi())*$stdev)) * pow(2.718281828,(-1*( pow(($mean-$first),2) / (2*pow($stdev,2)))));
   $normal = (1/ (sqrt(2*pi())*$stdev)) * pow(2.718281828,(-1*( pow(($mean-$first),2) / (2*pow($stdev,2)))));
      }*/

   //ok, now do it backwards

 //echo "Firstus ke ".$firstus."<hr>";
  $newage = (1/ (sqrt(2*pi())*$stdev)) * pow(2.718281828,(-1*( pow(($mean-$firstus),2) / (2*pow($stdev,2)))));

  while($firstus >-1){
//for the part right below, dont use 101 as the reference point, instead, use 101 in conjunction with the y-value for the starting x.
 if(($firstus>-1)&&($firstus<$first)&&($newage>0.00025)){
   $norm[] = ((1/ (sqrt(2*pi())*$stdev)) * pow(2.718281828,(-1*( pow(($mean-$firstus),2) / (2*pow($stdev,2))))))*$count;
   $newage = (1/ (sqrt(2*pi())*$stdev)) * pow(2.718281828,(-1*( pow(($mean-$firstus),2) / (2*pow($stdev,2)))));

 $xdata[] = $firstus;
 }
 $firstus--;
 }

sort($norm);
sort($xdata);

 for($first;$first<=$last;$first++){

    $norm[] = ((1/ (sqrt(2*pi())*$stdev)) * pow(2.718281828,(-1*( pow(($mean-$first),2) / (2*pow($stdev,2))))))*$count;
    $normal = (1/ (sqrt(2*pi())*$stdev)) * pow(2.718281828,(-1*( pow(($mean-$first),2) / (2*pow($stdev,2)))));

    $xdata[] = $first;
 }

while($first <110){

 //for the part right below, don’t use 101 as the reference point, instead, use 101 in conjunction with the y-value for the starting x.
 if(($first<101)&&($normal>0.00025)){
   $norm[] = ((1/ (sqrt(2*pi())*$stdev)) * pow(2.718281828,(-1*( pow(($mean-$first),2) / (2*pow($stdev,2))))))*$count;
   $normal = (1/ (sqrt(2*pi())*$stdev)) * pow(2.718281828,(-1*( pow(($mean-$first),2) / (2*pow($stdev,2)))));
      }
 $xdata[] = $first;
 $first++;
 }

 //balance the bell if above -1 and below 101;

 if($first){}
#############
$countm = count($marks);

foreach($marks as $key => $value){
 $ydata[] = $value * $countm;
 if($key==37){$zzdata[] = $value * $countm-0.3;}  else{$zzdata[] = 0;}
}

$xzdata = array(0.0010,0.0010,0.0015,0.003,0.004416359,0.006579581,0.008796719,0.010798193,0.013123163,0.015790032,0.018809815,0.022184167,0.025903519,0.029945493,0.034273718,0.038837211,0.043570435,0.048394145,0.05321705,0.057938311,0.062450787,0.066644921,0.070413065,0.073654028,0.076277563,0.078208539,0.079390509,0.079788456,0.079390509,0.078208539,0.076277563,0.073654028,0.070413065,0.066644921,0.062450787,0.057938311,0.05321705,0.048394145,0.043570435,0.038837211,0.034273718,0.029945493,0.025903519,0.022184167,0.018809815,0.015790032,0.013123163,0.010798193,0.008796719,0.006579581,0.004416359,0.003,0.0015,0.0010,0.0010);

$count2 = count($xzdata);

foreach($xzdata as $key => $value){
 $zdata[] = $value * $count2;
}

//and now onto the graph

// Size of the overall graph
$width=400;
$height=250;

// Create the graph and set a scale.
// These two calls are always required
$graph = new Graph($width,$height);
$graph->SetScale('intlin');
$graph->img->SetMargin(40,20,30,70);

// Create the linear plot
$lineplot=new LinePlot($norm);
//$lineplot->mark->SetType(MARK_UTRIANGLE);
$lineplot->SetColor('blue');
$lineplot->SetWeight(1);

//$lineplot->mark->SetFillColor('red');
$graph->title->Set("Distribution of marks -".$matakala);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,10);

$start =$xdata[0] ;
$end = count($norm);
$final = 100 - $start;

//$graph->title->Set("starts at ".$start." ends at ".$final);

$graph->xaxis->title->Set("Marks (%)");
$graph->yaxis->title->Set("Number of Candidates");


//$graph->xscale->SetMax($final);
//$graph->SetScale('intlin',0,0,0,$end);

$lineplot->SetLegend("Average");

$bplot = new BarPlot($zzdata);

$bplot->SetFillColor('red');

//$graph->Add($bplot);

// Add the plot to the graph
$graph->Add($lineplot);
$graph->xaxis->SetTickLabels($xdata);

$lineplot2=new LinePlot($zdata);
//$graph->Add($lineplot2);
$lineplot2->SetWeight(1);

$lineplot2->SetColor('green');
$lineplot2->SetStyle("dashed");
$lineplot2->SetLegend("MD203");

$graph->legend->SetLayout(LEGEND_HOR);
$graph->legend->Pos(0.4,0.95,"center","bottom");

// Display the graph
$graph->Stroke();

?>
