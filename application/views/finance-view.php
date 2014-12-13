<?php

$chart = '';
$month = (int)date('m');
$year = (int)date('Y');
$monthDay = (int)date('t');

$date = array();
$db_date = array();


if(!empty($balanceCredit)){
    foreach ($balanceCredit as $cr) {
        $ami = $date[(int)$cr->dates] = $cr->amount;
    }
}
if(!empty($balanceDebit)){
    foreach ($balanceDebit as $db) {
        $ami = $db_date[(int)$db->dates] = $db->amount;
    }
}

for ($i = 1; $i <= $monthDay; $i++) {
    $chart .= '["'.$i.' '.date('M').'",';
    if (isset($date[$i])) {
        $chart .= $date[$i] . ',';
    } else {
        $chart .= '0,';
    }
    if (isset($db_date[$i])) {
        $chart .= $db_date[$i] . ',';
    } else {
        $chart .= '0,';
    }
    $chart .= "],\n";
}



?>

<!doctype html>
<html lang="en-US">
<head>
    <?php $this->load->view('include/head.php'); ?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

</head>
<body>

<?php $this->load->view('include/header-loggedIn.php'); ?>
<?php $this->load->view('include/mainMenu-bar-loggedIn.php'); ?>


<section class="dashboard">
    <div class="container">
        <div class="toogleButton">
            <div class="col-md-10 col-md-offset-1 noPadding">
                <button data-content="Show Balance Performance" class="btn btn-primary pull-right show_balance_performance">Hide Balance Performance</button>
            </div>
        </div>
        <div style="width: 100%;" class="balance_graph">
            <div id="chart_div" style="width: 100%; height: 400px;"></div>
        </div>
        <?php $this->load->view('include/finance_content'); ?>
    </div>
</section>


<?php $this->load->view('include/footer.php'); ?>



</body>
<script>
    google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(drawChart);


    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Date', 'Credit','Debit'],

            <?php echo $chart; ?>
        ]);



        // Balance format
        var formatter = new google.visualization.NumberFormat(
            {prefix: '$'});
        formatter.format(data, 1);
        formatter.format(data, 2);


        var options = {
            title: 'Balance Performance',
            hAxis: {title: '<?php echo date('M - Y') ?>', titleTextStyle: {color: 'red'}, textPosition: 'out', maxAlternation: 1, textStyle: {fontSize: 10}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

    $(".show_balance_performance").on('click', function() {
        var name = $('.show_balance_performance').attr('data-content');
        if(name == "Show Balance Performance"){
            $('.show_balance_performance').attr('data-content', 'Hide Balance Performance');
        } else {
            $('.show_balance_performance').attr('data-content', 'Show Balance Performance');
        }
        $('.show_balance_performance').html(name);
        $(".balance_graph").stop().toggle(500);
    });

</script>
</html>