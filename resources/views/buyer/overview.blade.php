@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
{{--                <form method="POST" action="{{ route("buyer.singleVerify") }}" enctype="multipart/form-data">--}}
                    @include('buyer.single-verify-form')

            </div>



            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Verification Activity
                    </div>

                    <div class="card-body">
                        <div id="chartdiv"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Lifetime Usage Statistics
                    </div>

                    <div class="card-body">

                        <div id="totalOverview"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        #totalOverview {
            width: 100%;
            height: 500px;
        }
    </style>
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }

    </style>
@endpush
@push('script')
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <!-- Chart code -->


    <!-- Chart code -->
    <script>
        var overviews = {!! json_encode($overviews) !!};
        var total = {!! json_encode($total) !!};
        am4core.ready(function() {
// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end
            var chart = am4core.create("totalOverview", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
            chart.data = overviews;
// Add label
            if (total === 0) {
                // Create a new chart with a default value of "No data available"
                var chart = am4core.create("totalOverview", am4charts.PieChart3D);
                chart.innerRadius = 100;
                var label = chart.seriesContainer.createChild(am4core.Label);
                label.text = "No data available";
                label.horizontalCenter = "middle";
                label.verticalCenter = "middle";
                label.fontSize = 30;
                label.y = -20;
                label.multiline = true;
                label.textAlign = "center";
            }else{
                chart.innerRadius = 100;
                var label = chart.seriesContainer.createChild(am4core.Label);
                label.text = "Total\n{{ $total }}"; // use \n instead of <br>
                label.horizontalCenter = "middle";
                label.verticalCenter = "middle";
                label.fontSize = 30;
                label.y = -25; // move label 20 pixels upwards from the center
                label.multiline = true; // enable multiline text
                label.textAlign = "center"; // center-align the text within the label
            }



            chart.innerRadius = am4core.percent(45);

                chart.depth = 20;

            chart.legend = new am4charts.Legend();
            var series = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.value = "value";
            series.dataFields.depthValue = "value";
            series.dataFields.category = "category";
            series.slices.template.cornerRadius = 5;
            series.colors.step = 3;
        }); // end am4core.ready()

    </script>
    <script>
        var dateWiseEmailCheck = {!! json_encode($dateWiseEmailCheck) !!};

        am4core.ready(function() {
// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end
// Create chart instance
            var chart = am4core.create("chartdiv", am4charts.XYChart);
// Add data
            chart.data = dateWiseEmailCheck;

// Set input format for the dates
            chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = "value";
            series.dataFields.dateX = "date";
            series.tooltipText = "{value}"
            series.strokeWidth = 2;
            series.minBulletDistance = 15;

// Drop-shaped tooltips
            series.tooltip.background.cornerRadius = 20;
            series.tooltip.background.strokeOpacity = 0;
            series.tooltip.pointerOrientation = "vertical";
            series.tooltip.label.minWidth = 40;
            series.tooltip.label.minHeight = 40;
            series.tooltip.label.textAlign = "middle";
            series.tooltip.label.textValign = "middle";

// Make bullets grow on hover
            var bullet = series.bullets.push(new am4charts.CircleBullet());
            bullet.circle.strokeWidth = 2;
            bullet.circle.radius = 4;
            bullet.circle.fill = am4core.color("#fff");

            var bullethover = bullet.states.create("hover");
            bullethover.properties.scale = 1.3;

// Make a panning cursor
            chart.cursor = new am4charts.XYCursor();
            chart.cursor.behavior = "panXY";
            chart.cursor.xAxis = dateAxis;
            chart.cursor.snapToSeries = series;

// Create vertical scrollbar and place it before the value axis
            chart.scrollbarY = new am4core.Scrollbar();
            chart.scrollbarY.parent = chart.leftAxesContainer;
            chart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
            chart.scrollbarX = new am4charts.XYChartScrollbar();
            chart.scrollbarX.series.push(series);
            chart.scrollbarX.parent = chart.bottomAxesContainer;

            dateAxis.start = 0.79;
            dateAxis.keepSelection = true;


        }); // end am4core.ready()
    </script>




@endpush
