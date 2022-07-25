<html>
  <head>
    <!-- Load file CSS Bootstrap offline -->
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/bootstrap/css/bootstrap.min.css">
    <script src="<?php echo base_url()?>/assets/bootstrap/js/jquery-3.3.1.min.js"></script>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
        // pie chart data sales channel
        var PieChartData='<?php echo $PieChartData;?>'

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows(JSON.parse(PieChartData));

        var options = {'title':'<?php echo $PieChartTitle;?>',
                       'width':0,
                       'height':0};

        var pie_chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        pie_chart.draw(data, options);


        // line chart data penjualan
        var LineChartData='<?php echo $LineChartData;?>';
        var line_data = google.visualization.arrayToDataTable(JSON.parse(LineChartData));

        var line_options = {
          title: '<?php echo $LineChartTitle; ?>',
          legend: { position: 'bottom' }
        };

        var line_chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        line_chart.draw(line_data, line_options);

        //bar chart akumulasi penjualan perbulan
        var BarChartData='<?php echo $BarChartData;?>';
        var bar_data = google.visualization.arrayToDataTable(JSON.parse(BarChartData));

        var Bar_options = {
          title: '<?php echo $BarChartTitle; ?>',
          legend: { position: 'bottom' }
        };
        var bar_chart = new google.visualization.ColumnChart(document.getElementById('bar_chart'));
        bar_chart.draw(bar_data, Bar_options);

        
        // pie chart data customer country
        var PieChartData2='<?php echo $PieChartData2;?>'

        var data2 = new google.visualization.DataTable();
        data2.addColumn('string', 'Topping');
        data2.addColumn('number', 'Slices');
        data2.addRows(JSON.parse(PieChartData2));

        var options2 = {'title':'<?php echo $PieChartTitle2;?>',
                       'width':0,
                       'height':0};

        var pie_chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
        pie_chart2.draw(data2, options2);
      }

    </script>
  </head>
  <body>
    <div id="chart_div"></div>
    <div id="chart_div2"></div>
    <div id="curve_chart" ></div><br>
    <div id="bar_chart"></div>   
  </body>
</html>