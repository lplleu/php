<?php

//jedenfalls
//24-Feb-2019
//eia table and graphs

include '4.php';

$sql = "SELECT eia.id,year,title,eia_areas.name,eia_types.name,eia_villages.name,eia_practitioners.name FROM `eia` LEFT JOIN eia_types ON type = eia_types.id LEFT JOIN eia_villages ON village = eia_villages.id LEFT JOIN eia_practitioners ON practitioner = eia_practitioners.id  LEFT JOIN eia_areas ON area = eia_areas.id ";
$lookup = mysqli_query($connd,$sql);

echo '<!DOCTYPE html>
<html lang="en">
<head>
  <title>EIA page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
</head>
<body>

<div class="jumbotron text-center">
  <h1>EIA</h1>
  <p>under construction</p> 
</div>
  
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h3>EIAs</h3>';
      
echo '<table id="example" class="display table-striped compact" style="width:100%">';
echo '<thead><tr><th>id</th><th>year</th><th>title</th><th>area</th><th>type</th><th>village</th><th>practioner</th></tr></thead><tbody>';

while($row = mysqli_fetch_array($lookup,MYSQLI_NUM)){
    printf ('<tr><td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> </tr>',$row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6]);
}
echo '</tbody>';

echo '<tfoot><tr><th>id</th><th>year</th><th>title</th><th>area</th><th>type</th><th>village</th><th>practioner</th></tr></tfoot>';

echo '</table>';

echo '</div>
  </div>
  
    <div class="row">
        <div id="containerType" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12" style="min-width: 310px; height: 400px; margin: 0 auto">type</div><!--ends-type-div-->
        <div id="containerYear" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12" style="min-width: 310px; height: 400px; margin: 0 auto">year</div><!--ends-type-div-->
        <div id="containerVillage" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12" style="min-width: 310px; height: 400px; margin: 0 auto">village</div><!--ends-type-div-->
        <div id="containerPractitioner" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12" style="min-width: 310px; height: 400px; margin: 0 auto">practitioner</div><!--ends-type-div-->
        <div id="containerArea" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12" style="min-width: 310px; height: 400px; margin: 0 auto">area</div><!--ends-type-div-->
    </div><!--ends-row-->
</div>

</body>';

echo '
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/data.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  ';
  
echo "
	<script type='text/javascript' language='javascript' class='init'>
        $(document).ready(function() {
        	$('#example').DataTable();
        } );
	</script>
	
	<script type='text/javascript' language='javascript' class='init'>
        $(document).ready(function() {
        
        
        Highcharts.chart('containerYear', {
            data: {
                table: 'byYear'
            },
            chart: {
                type: 'column'
            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false  
            },
            title: {
                text: 'by year'
            },
            xAxis: {
                allowDecimals: false,
                title: {
                    text: 'year'
                }
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'reports'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.point.y + ' in ' + this.point.name.toLowerCase();
                }
            }
        });
        
        Highcharts.chart('containerVillage', {
            data: {
                table: 'byVillage'
            },
            chart: {
                type: 'bar'
            },
            legend: {
                enabled: false  
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'top 10 villages'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'reports'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.point.y + ' in ' + this.point.name();
                }
            }
        });
        
        Highcharts.chart('containerPractitioner', {
            data: {
                table: 'byPractitioner'
            },
            chart: {
                type: 'bar'
            },
            legend: {
                enabled: false  
            },
            title: {
                text: 'top 10 practitioners'
            },
            credits: {
                enabled: false
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'reports'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.point.y + ' in ' + this.point.name();
                }
            }
        });       
        
        Highcharts.chart('containerArea', {
            data: {
                table: 'byArea'
            },
            chart: {
                type: 'bar'
            },
            title: {
                text: 'top 10 areas'
            },
            legend: {
                enabled: false  
            },
            credits: {
                enabled: false
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'reports'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.point.y + ' by ' + this.point.name();
                }
            }
        });



        } );
	</script>
	
    <script language = 'JavaScript'>
         $(document).ready(function() {
            var data = {
               table: 'byType'
            };
            var chart = {
               type: 'bar'
            };
            var title = {
               text: 'by type'   
            }; 
            var yAxis = {
               allowDecimals: false,
               title: {
                  text: 'reports'
               }
            };
            var tooltip = {
               formatter: function () {
                  return '<b>' + this.series.name + '</b><br/>' +
                     this.point.y + ' ' + this.point.name.toLowerCase();
               }
            };
            var credits = {
               enabled: false
            };  
            var legend = {
               enabled: false
            };  
            var json = {};   
            json.chart = chart; 
            json.legend = legend; 
            json.title = title; 
            json.data = data;
            json.yAxis = yAxis;
            json.credits = credits;  
            json.tooltip = tooltip;  
            $('#containerType').highcharts(json);
         });
    </script>";

echo '</html>';
// Free result set
mysqli_free_result($lookup);

$sql2 = mysqli_query($connd,"SELECT name, COUNT(eia.id) AS count FROM eia LEFT JOIN eia_types ON type = eia_types.id GROUP BY type ORDER BY `count` DESC"); //type
echo '<table id="byType" class="hidden" style="display:none;"><tr><th>type</th><th>count</th></tr>';
while($row = mysqli_fetch_array($sql2,MYSQLI_NUM)){
    printf ('<tr><td>%s</td> <td>%s</td> </tr>',$row[0],$row[1]);
}
echo '</table>';
mysqli_free_result($sql2);

$sql3 = mysqli_query($connd,"SELECT year, COUNT(id) AS count FROM eia GROUP BY year ORDER BY `year` ASC"); //year
echo '<table id="byYear" style="display:none;"><tr><th>year</th><th>count</th></tr>';
while($row = mysqli_fetch_array($sql3,MYSQLI_NUM)){
    printf ('<tr><td>%s</td> <td>%s</td> </tr>',$row[0],$row[1]);
}
echo '</table>';
mysqli_free_result($sql3);

$sql4 = mysqli_query($connd,"SELECT name, COUNT(eia.id) AS count FROM eia LEFT JOIN eia_villages ON village = eia_villages.id  WHERE village != 1 GROUP BY village ORDER BY `count` DESC LIMIT 0,10"); //village
echo '<table id="byVillage" style="display:none;"><tr><th>village</th><th>count</th></tr>';
while($row = mysqli_fetch_array($sql4,MYSQLI_NUM)){
    printf ('<tr><td>%s</td> <td>%s</td> </tr>',$row[0],$row[1]);
}
echo '</table>';
mysqli_free_result($sql4);

$sql5 = mysqli_query($connd,"SELECT name, COUNT(eia.id) AS count FROM eia LEFT JOIN eia_practitioners ON practitioner = eia_practitioners.id WHERE practitioner != 1 GROUP BY practitioner ORDER BY `count` DESC LIMIT 0,10"); //practitioner
echo '<table id="byPractitioner" style="display:none;"><tr><th>practitioner</th><th>count</th></tr>';
while($row = mysqli_fetch_array($sql5,MYSQLI_NUM)){
    printf ('<tr><td>%s</td> <td>%s</td> </tr>',$row[0],$row[1]);
}
echo '</table>';
mysqli_free_result($sql5);

$sql6 = mysqli_query($connd,"SELECT name, COUNT(eia.id) AS count FROM eia LEFT JOIN eia_areas ON area = eia_areas.id  GROUP BY area ORDER BY `count` DESC LIMIT 0,10"); //area
echo '<table id="byArea" style="display:none;"><tr><th>area</th><th>count</th></tr>';
while($row = mysqli_fetch_array($sql6,MYSQLI_NUM)){
    printf ('<tr><td>%s</td> <td>%s</td> </tr>',$row[0],$row[1]);
}
echo '</table>';
mysqli_free_result($sql6);

mysqli_close($connd);

?>
