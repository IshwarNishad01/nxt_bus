<?php 
require 'inc/Header.php';
?>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
    <?php require 'inc/Navbar.php';?>
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
       <?php require 'inc/Sidebar.php';?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-sm-6">
                  <h3><?php echo $lang['Analysis_Report_Data'];?></h3>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-default">
		 
            <div class="row">
             
           <div class="col-xl-4 col-lg-6 box-col-30"> 
                <div class="card our-earning">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1"> 
                        <p class=" f-w-600 header-text-primary"><?php echo $lang['User_Register_Ratio_Monthly_Current_Year_Only'];?><i class="fa fa-circle"> </i></p>
                       <div class="card-body p-0">
                    <div class="earning-chart">
                      <div id="earning-chart"></div>
                    </div>
					</div>
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
			  
			  <div class="col-xl-4 col-lg-6 box-col-30"> 
                <div class="card our-earning">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1"> 
                        <p class=" f-w-600 header-text-primary"><?php echo $lang['Agent_Register_Ratio_Monthly_Current_Year_Only'];?><i class="fa fa-circle"> </i></p>
                       <div class="card-body p-0">
                    <div class="earning-chart">
                      <div id="earning-charts"></div>
                    </div>
					</div>
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
			  
			  <div class="col-xl-4 col-lg-6 box-col-30"> 
                <div class="card our-earning">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1"> 
                        <p class=" f-w-600 header-text-primary"><?php echo $lang['Total_Booking_Monthly_Current_Year_Only'];?><i class="fa fa-circle"> </i></p>
                       <div class="card-body p-0">
                    <div class="earning-chart">
                      <div id="book-ticket"></div>
                    </div>
					</div>
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
			  
			  <div class="col-xl-4 col-lg-6 box-col-30"> 
                <div class="card our-earning">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1"> 
                        <p class=" f-w-600 header-text-primary"><?php echo $lang['Total_Earning_Monthly_Current_Year_Only'];?><i class="fa fa-circle"> </i></p>
                       <div class="card-body p-0">
                    <div class="earning-chart">
                      <div id="book-sales"></div>
                    </div>
					</div>
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
			  
			  <div class="col-xl-4 col-lg-6 box-col-30"> 
                <div class="card our-earning">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1"> 
                        <p class=" f-w-600 header-text-primary"><?php echo $lang['Total_Agent_Earning_Monthly_Current_Year_Only'];?><i class="fa fa-circle"> </i></p>
                       <div class="card-body p-0">
                    <div class="earning-chart">
                      <div id="agent-sales"></div>
                    </div>
					</div>
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
			  
			  
			  <div class="col-xl-4 col-lg-6 box-col-30"> 
                <div class="card our-earning">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1"> 
                        <p class=" f-w-600 header-text-primary"><?php echo $lang['Total_Operator_Earning_Monthly_Current_Year_Only'];?><i class="fa fa-circle"> </i></p>
                       <div class="card-body p-0">
                    <div class="earning-chart">
                      <div id="operator-sales"></div>
                    </div>
					</div>
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
			  
			  
			  <div class="col-xl-4 col-lg-6 box-col-30"> 
                <div class="card our-earning">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1"> 
                        <p class=" f-w-600 header-text-primary"><?php echo $lang['Total_Agent_Completed_Payout_Monthly_Current_Year_Only'];?><i class="fa fa-circle"> </i></p>
                       <div class="card-body p-0">
                    <div class="earning-chart">
                      <div id="com_payout"></div>
                    </div>
					</div>
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
			  
			  <div class="col-xl-4 col-lg-6 box-col-30"> 
                <div class="card our-earning">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1"> 
                        <p class=" f-w-600 header-text-primary"><?php echo $lang['Total_Operator_Completed_Payout_Monthly_Current_Year_Only'];?><i class="fa fa-circle"> </i></p>
                       <div class="card-body p-0">
                    <div class="earning-chart">
                      <div id="com_op_payout"></div>
                    </div>
					</div>
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
			  
			  
			  <div class="col-xl-6 col-lg-6 box-col-30"> 
                <div class="card our-earning">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1"> 
                        <p class=" f-w-600 header-text-primary"><?php echo $lang['Most_Booking_Bus'];?><i class="fa fa-circle"> </i></p>
                       <div class="card-body p-0">
                    <div class="earning-chart">
                      <div id="pie-chart"></div>
                    </div>
					</div>
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
			  
			  <div class="col-xl-6 col-lg-6 box-col-30"> 
                <div class="card our-earning">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1"> 
                        <p class=" f-w-600 header-text-primary"><?php echo $lang['Most_Popular_City'];?><i class="fa fa-circle"> </i></p>
                       <div class="card-body p-0">
                    <div class="earning-chart">
                      <div id="pie-city"></div>
                    </div>
					</div>
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
			  
			
            
            </div>
	
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
       
      </div>
    </div>
    <!-- latest jquery-->
   <?php require 'inc/Footer.php'; ?>
    <!-- login js-->
	<script>
	<?php
function fetchDataAndEncode($variableName, $type, $year, $bus, $dateColumn, $tblname)
{
    $vname = $variableName;
    $query = "SELECT MONTH($dateColumn) as month, COUNT(*) as user_count FROM `$tblname` WHERE YEAR($dateColumn) = $year";
    
    if ($type !== '') {
        $query .= " AND user_type = '$type'";
    }

    $query .= " GROUP BY MONTH($dateColumn)";
    
    $result = $bus->query($query);

    if (!$result) {
        die("Error in query: " . $bus->error);
    }

    $monthNames = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
    ];

    $variableName = array_fill_keys(array_values($monthNames), 0);

    while ($data = $result->fetch_assoc()) {
        $numericMonth = $data['month'];
        $monthName = $monthNames[$numericMonth];
        $variableName[$monthName] = $data['user_count'];
    }

    return 'var ' . $vname . ' = ' . json_encode($variableName) . ';';
}

$year = date('Y');

// Fetch and encode user data with variable name 'yearlyData'
echo fetchDataAndEncode('yearlyData', 'USER', $year, $bus, 'rdate', 'tbl_user');

// Fetch and encode agent data with variable name 'agentData'
echo fetchDataAndEncode('agentData', 'AGENT', $year, $bus, 'rdate', 'tbl_user');

// Fetch and encode book data with variable name 'bookData'
echo fetchDataAndEncode('bookData', '', $year, $bus, 'book_date', 'tbl_book');



$query = "SELECT MONTH(book_date) as month, sum((subtotal+tax_amt) -(cou_amt+wall_amt)) as total_earning FROM `tbl_book` WHERE YEAR(book_date) = $year and book_status='Completed' GROUP BY MONTH(book_date)";
$result = $bus->query($query);
$monthNames = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
    ];
	$totalsales = array_fill_keys(array_values($monthNames), 0);

    while ($data = $result->fetch_assoc()) {
        $numericMonth = $data['month'];
        $monthName = $monthNames[$numericMonth];
        $totalsales[$monthName] = $data['total_earning'].$set['currency'];
    }
	echo 'var totalsales'. ' = ' . json_encode($totalsales) . ';';
	
	
	$query = "SELECT MONTH(book_date) as month, sum(commission) as total_earning FROM `tbl_book` WHERE YEAR(book_date) = $year and book_status='Completed' GROUP BY MONTH(book_date)";
$result = $bus->query($query);
$monthNames = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
    ];
	$totalsales = array_fill_keys(array_values($monthNames), 0);

    while ($data = $result->fetch_assoc()) {
        $numericMonth = $data['month'];
        $monthName = $monthNames[$numericMonth];
        $totalsales[$monthName] = $data['total_earning'].$set['currency'];
    }
	echo 'var totalagentsales'. ' = ' . json_encode($totalsales) . ';';
	
	$query = "SELECT MONTH(book_date) as month, sum(subtotal-cou_amt * ope_commission/100) as total_earning FROM `tbl_book` WHERE YEAR(book_date) = $year and book_status='Completed' GROUP BY MONTH(book_date)";
$result = $bus->query($query);
$monthNames = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
    ];
	$totalsales = array_fill_keys(array_values($monthNames), 0);

    while ($data = $result->fetch_assoc()) {
        $numericMonth = $data['month'];
        $monthName = $monthNames[$numericMonth];
        $totalsales[$monthName] = $data['total_earning'].$set['currency'];
    }
	echo 'var totaloperatorsales'. ' = ' . json_encode($totalsales) . ';';
	
	
	$query = "SELECT MONTH(r_date) as month, sum(amt) as total_payout FROM `payout_setting` WHERE YEAR(r_date) = $year and status='completed' GROUP BY MONTH(r_date)";
$result = $bus->query($query);
$monthNames = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
    ];
	$totalsales = array_fill_keys(array_values($monthNames), 0);

    while ($data = $result->fetch_assoc()) {
        $numericMonth = $data['month'];
        $monthName = $monthNames[$numericMonth];
        $totalsales[$monthName] = $data['total_payout'];
    }
	echo 'var totalpayout'. ' = ' . json_encode($totalsales) . ';';
	
	$query = "SELECT MONTH(r_date) as month, sum(amt) as total_payout FROM `bus_payout_setting` WHERE YEAR(r_date) = $year and status='completed' GROUP BY MONTH(r_date)";
$result = $bus->query($query);
$monthNames = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
    ];
	$totalsales = array_fill_keys(array_values($monthNames), 0);

    while ($data = $result->fetch_assoc()) {
        $numericMonth = $data['month'];
        $monthName = $monthNames[$numericMonth];
        $totalsales[$monthName] = $data['total_payout'];
    }
	echo 'var totaloppayout'. ' = ' . json_encode($totalsales) . ';';
?>


    function createApexChart(objectName, selectorId, seriesName, data, categories) {
		
		function formatCurrency(value) {
        // Assuming the currency symbol is "$"
        return  value + "<?php echo $set['currency'];?>";
    }
	
    var options = {
        series: [{
            name: seriesName,
            data: data
        }],
        chart: {
            type: 'bar',
            toolbar: {
                show: false
            },
            height: 270,
            stacked: true,
        },
        states: {
            hover: {
                filter: {
                    type: 'darken',
                    value: 1,
                }
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 6,
                columnWidth: '50%',
            }
        },
        responsive: [{
            breakpoint: 1199.98,
            options: {
                chart: {
                    height: 320
                },
            }
        }],
        dataLabels: {
            enabled: false
        },
        grid: {
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        xaxis: {
            categories: categories,
            offsetX: 0,
            offsetY: 0,
            axisBorder: {
                low: 0,
                offsetX: 0,
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: false,
            dataLabels: {
                enabled: true
            },
        },
        fill: {
            opacity: 1,
            colors: ['#5c61f2']
        },
        legend: {
            show: false
        },
        tooltip: {
            enabled: true,
            y: {
                formatter: function (val, { seriesIndex, dataPointIndex, w }) {
                    // Format only for saleChart, agentsaleChart, and payoutChart
                    if (objectName === 'saleChart' || objectName === 'agentsaleChart' || objectName === 'payoutChart') {
                        return formatCurrency(val);
                    }
                    return val;
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector(selectorId), options);
    chart.render();

    // Assign the created chart object to the specified variable name
    window[objectName] = chart;
}

// Example usage:
createApexChart('userChart', '#earning-chart', '<?php echo $lang['User_Register'];?>', Object.values(yearlyData), Object.keys(yearlyData));
createApexChart('agentChart', '#earning-charts', '<?php echo $lang['Agent_Register'];?>', Object.values(agentData), Object.keys(agentData));
createApexChart('bookChart', '#book-ticket', '<?php echo $lang['Total_Book_Ticket'];?>', Object.values(bookData), Object.keys(bookData));
createApexChart('saleChart', '#book-sales', '<?php echo $lang['Total_Earning'];?>', Object.values(totalsales), Object.keys(totalsales));
createApexChart('agentsaleChart', '#agent-sales', '<?php echo $lang['Total_Agent_Earning'];?>', Object.values(totalagentsales), Object.keys(totalagentsales));
createApexChart('operatorsaleChart', '#operator-sales', '<?php echo $lang['Total_Operator_Earning'];?>', Object.values(totaloperatorsales), Object.keys(totaloperatorsales));
createApexChart('payoutChart', '#com_payout', '<?php echo $lang['Total_Agent_Payout'];?>', Object.values(totalpayout), Object.keys(totalpayout));
createApexChart('oppayoutChart', '#com_op_payout', '<?php echo $lang['Total_Operator_Payout'];?>', Object.values(totaloppayout), Object.keys(totaloppayout));

</script>

<script>
        // Sample data for bus ticket distribution
	<?php 
	$buslist = $bus->query("select id,title from tbl_bus");
	$p = array();
	$busData = array();
	while($row = $buslist->fetch_assoc())
	{
		$p['busName'] = $row['title'];
		$p['bookedTickets'] = $bus->query("select * from tbl_book where bus_id=".$row['id']."")->num_rows;
		$busData[] = $p;
	}
	
	?>
        var busData = <?php echo json_encode($busData); ?>;

        // Extracting labels and values for the chart
        var busLabels = busData.map(function(bus) {
            return bus.busName;
        });

        var bookedTicketsData = busData.map(function(bus) {
            return bus.bookedTickets;
        });

        // ApexCharts configuration
        var options = {
            chart: {
                type: 'pie',
                height: 350
            },
            labels: busLabels,
            series: bookedTicketsData,
            legend: {
                position: 'right'
            }
        };

        var chart = new ApexCharts(document.querySelector("#pie-chart"), options);
        chart.render();
    </script>
	
	
	<script>
        // Sample data for bus ticket distribution
	<?php 
	$buslist = $bus->query("select id,title from tbl_city");
	$p = array();
	$busData = array();
	while($row = $buslist->fetch_assoc())
	{
		$p['busName'] = $row['title'];
		$p['bookedTickets'] = $bus->query("select * from tbl_book where boarding_city='".$row['title']."' or drop_city='".$row['title']."'")->num_rows;
		$busData[] = $p;
	}
	
	?>
        var busData = <?php echo json_encode($busData); ?>;

        // Extracting labels and values for the chart
        var busLabels = busData.map(function(bus) {
            return bus.busName;
        });

        var bookedTicketsData = busData.map(function(bus) {
            return bus.bookedTickets;
        });

        // ApexCharts configuration
        var options = {
            chart: {
                type: 'pie',
                height: 350
            },
            labels: busLabels,
            series: bookedTicketsData,
            legend: {
                position: 'right'
            }
        };

        var chart = new ApexCharts(document.querySelector("#pie-city"), options);
        chart.render();
    </script>



  </body>


</html>