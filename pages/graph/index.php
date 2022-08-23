<?php
require_once '../authen.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../layout/header.php'; ?>
    <!-- InputMask -->
    <script src="../../assets/plugins/moment/moment.min.js"></script>
    <!-- daterange picker -->
    <link rel="stylesheet" href="../../assets/plugins/daterangepicker/daterangepicker.css">

    <script src="../../assets/plugins/amcharts_4/core.js"></script>
    <script src="../../assets/plugins/amcharts_4/charts.js"></script>
    <script src="../../assets/plugins/amcharts_4/themes/animated.js"></script>
    <script src="../../assets/plugins/amcharts_4/lang/de_DE.js"></script>
    <script src="../../assets/plugins/amcharts_4/fonts/notosans-sc.js"></script>
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <?php include '../layout/sidebar.php'; ?>
        <!-- Content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><i class="fas fa-chart-area"></i> Graph Analysis</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard/">Dashboard</a></li>
                                <li class="breadcrumb-item active"><a href="#">Graph Analysis</a></li>
                                <!-- <li class="breadcrumb-item active">Collapsed Sidebar</li> -->
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="d-flex justify-content-between">
                                                        <h3 class="card-title">การวิเคราะห์ขั้นพื้นฐาน</h3>
                                                    </div>
                                                </div>
                                                <div class="card-body pb-0 pt-1">
                                                    <form id="formGraphsearch">
                                                        <div class="row">
                                                            <div class="col-lg-6 border-right">
                                                                <div class="row">
                                                                    <?php if ($_SESSION['AD_PERMISSION'] == 1) {  ?>
                                                                        <div class="form-group col-md-4 col-sm-12">
                                                                            <label for="select_ddl_company">บริษัท</label>
                                                                            <select id="select_ddl_company" name="select_ddl_company" class="form-control select2bs4" style="width: 100%;">
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-4 col-sm-12">
                                                                            <label for="select_ddl_site">Site</label>
                                                                            <select id="select_ddl_site" name="select_ddl_site" class="form-control select2bs4" style="width: 100%;">
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-4 col-sm-12">
                                                                            <label for="select_ddl_devices">อุปกรณ์</label>
                                                                            <select id="select_ddl_devices" name="select_ddl_devices" class="form-control select2bs4" style="width: 100%;" required>
                                                                            </select>
                                                                        </div>
                                                                    <?php } else {  ?>
                                                                        <div class="form-group col-md-6 col-sm-12">
                                                                            <label for="select_ddl_site">Site</label>
                                                                            <select id="select_ddl_site" name="select_ddl_site" class="form-control select2bs4" style="width: 100%;">
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6 col-sm-12">
                                                                            <label for="select_ddl_devices">อุปกรณ์</label>
                                                                            <select id="select_ddl_devices" name="select_ddl_devices" class="form-control select2bs4" style="width: 100%;" required>
                                                                            </select>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <!-- Date and time range -->
                                                                        <div class="form-group">
                                                                            <label>ช่วงเวลาที่ค้นหา :</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                                                </div>
                                                                                <input type="text" autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control float-right" id="search_daterange" required>
                                                                            </div>
                                                                            <!-- /.input group -->
                                                                        </div>
                                                                        <!-- /.form group -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <button type="submit" name="search_btn" class="btn btn-info btn-lg btn-block" width="100%" height="100%"><i class="fas fa-search"></i> ค้นหา</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">ข้อมูล</h3>
                                        <a href="javascript:void(0);">View Report</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="tab_graph_id" data-toggle="pill" href="#tab_graph" role="tab" aria-controls="tab_graph" aria-selected="true">กราฟข้อมูล</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab_table_data_id" data-toggle="pill" href="#tab_table_data" role="tab" aria-controls="tab_table_data" aria-selected="false">ข้อมูล</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="tab_graph" role="tabpanel" aria-labelledby="tab_graph_id">
                                            <div class="overlay-wrapper">

                                                <div id="loading" style="display: none;" class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                                    <div class="text-bold pt-2">กำลังโหลดข้อมูล...</div>
                                                </div>

                                                <div id="chartdiv"></div>

                                                <!-- <div class="d-flex">
                                                    <p class="d-flex flex-column">
                                                        <span class="text-bold text-lg">820</span>
                                                        <span>Visitors Over Time</span>
                                                    </p>
                                                    <p class="ml-auto d-flex flex-column text-right">
                                                        <span class="text-success">
                                                            <i class="fas fa-arrow-up"></i> 12.5%
                                                        </span>
                                                        <span class="text-muted">Since last week</span>
                                                    </p>
                                                </div>


                                                <div class="position-relative mb-4">
                                                    <canvas id="visitors-chart" height="200"></canvas>
                                                </div>

                                                <div class="d-flex flex-row justify-content-end">
                                                    <span class="mr-2">
                                                        <i class="fas fa-square text-primary"></i> This Week
                                                    </span>

                                                    <span>
                                                        <i class="fas fa-square text-gray"></i> Last Week
                                                    </span>
                                                </div> -->
                                            </div>

                                        </div>
                                        <div class="tab-pane fade show active" id="tab_table_data" role="tabpanel" aria-labelledby="tab_table_data_id">
                                            <div class="overlay-wrapper">

                                                <div id="loading" style="display: none;" class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                                    <div class="text-bold pt-2">กำลังโหลดข้อมูล...</div>
                                                </div>



                                                <!-- <div class="d-flex">
                                                    <p class="d-flex flex-column">
                                                        <span class="text-bold text-lg">820</span>
                                                        <span>Visitors Over Time</span>
                                                    </p>
                                                    <p class="ml-auto d-flex flex-column text-right">
                                                        <span class="text-success">
                                                            <i class="fas fa-arrow-up"></i> 12.5%
                                                        </span>
                                                        <span class="text-muted">Since last week</span>
                                                    </p>
                                                </div>


                                                <div class="position-relative mb-4">
                                                    <canvas id="visitors-chart" height="200"></canvas>
                                                </div>

                                                <div class="d-flex flex-row justify-content-end">
                                                    <span class="mr-2">
                                                        <i class="fas fa-square text-primary"></i> This Week
                                                    </span>

                                                    <span>
                                                        <i class="fas fa-square text-gray"></i> Last Week
                                                    </span>
                                                </div> -->
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <?php include '../layout/footer.php'; ?>
        <!-- date-range-picker -->
        <script src="../../assets/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="../../assets/js/pages/dashboard3.js"></script>

        <script type="text/javascript">
            var startDate;
            var endDate;
            $(function() {

                $('#search_daterange').daterangepicker({
                        // startDate: moment().subtract('days', 2),
                        // endDate: moment(),
                        autoUpdateInput: false,
                        timePicker: true,
                        timePicker24Hour: true,
                        timePickerIncrement: 5,
                        applyClass: 'btn-small btn-success',
                        cancelClass: 'btn-small',
                        showDropdowns: false,
                        locale: {
                            applyLabel: 'เลือก',
                            cancelLabel: 'ยกเลิก',
                            fromLabel: 'จาก',
                            toLabel: 'ถึง',
                            customRangeLabel: 'Custom Range',
                            daysOfWeek: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ', 'ศ.', 'ส.'],
                            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
                            firstDay: 1,
                            format: 'DD/MM/YYYY H:mm'
                        }
                    },
                    function(start, end, label) {
                        console.log("Callback has been called!");
                        // console.log(start.format('YYYY-MM-DD HH:mm:ss') + ' - ' + end.format('YYYY-MM-DD HH:mm:ss'));
                        startDate = start;
                        endDate = end;
                    })


                let permissions = <?php echo $_SESSION['AD_PERMISSION']; ?>

                if (permissions == 1) {
                    getddl("select_ddl_company", "company").then(() => {})

                    $("#select_ddl_company").on('change', function() {
                        if ($(this).val() != '') {
                            getddlbyId("select_ddl_site", "site", $(this).val()).then(() => {})
                        }
                    })

                    $("#select_ddl_site").on('change', function() {
                        if ($(this).val() != '') {
                            getddlbyId("select_ddl_devices", "device", $(this).val()).then(() => {})
                        }
                    })
                } else {
                    getddlbyId("select_ddl_site", "site", $(this).val()).then(() => {})
                    $("#select_ddl_site").on('change', function() {
                        if ($(this).val() != '') {
                            getddlbyId("select_ddl_devices", "device", $(this).val()).then(() => {})
                        }
                    })
                }

                // $('button[name=search_btn]').click(function() {
                //     console.log(startDate.format('YYYY-MM-DD HH:mm:ss'));
                // })

                // console.log(startDate);

                $('#search_daterange').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
                });


                $('#formGraphsearch').on('submit', function(e) {
                    e.preventDefault()
                    document.getElementById('loading').style.display = 'flex'
                    var formData = $('#formGraphsearch').serialize() + '&datetime=' + $('#search_daterange').val()
                    setTimeout(() => {
                        document.getElementById('loading').style.display = 'none'
                        generategraph()
                    }, 2000)
                    // console.log($('#search_daterange').val());
                    // console.log(startDate.format('YYYY-MM-DD HH:mm:ss'));
                    // console.log(endDate.format('YYYY-MM-DD HH:mm:ss'));
                    // CallAPI('POST', $company_id != "" ? '../../service/company/update.php' : '../../service/company/create.php',
                    //     formData
                    // ).then((data) => {
                    //     toastr.success(data.message)
                    //     $('#company_modal').modal('hide');
                    //     getDatatable()
                    // }).catch((error) => {
                    //     toastr.error(error.status)
                    // })
                });


                function generategraph() {
                    // Themes begin
                    am4core.useTheme(am4themes_animated);
                    // Themes end

                    // Create chart instance
                    var chart = am4core.create("chartdiv", am4charts.XYChart);

                    //

                    // Increase contrast by taking evey second color
                    chart.colors.step = 2;

                    // Add data
                    chart.data = generateChartData();

                    // Create axes
                    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                    dateAxis.renderer.minGridDistance = 50;

                    // Create series
                    function createAxisAndSeries(field, name, opposite) {
                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        if (chart.yAxes.indexOf(valueAxis) != 0) {
                            valueAxis.syncWithAxis = chart.yAxes.getIndex(0);
                        }

                        var color_random = getRandomColor();

                        var series = chart.series.push(new am4charts.LineSeries());
                        series.dataFields.valueY = field;
                        series.dataFields.dateX = "date";
                        series.strokeWidth = 1.8;
                        series.yAxis = valueAxis;
                        series.fill = am4core.color(color_random);
                        series.stroke = am4core.color(color_random);
                        series.name = name;
                        series.tooltipText = "{name}: [bold]{valueY}[/]";
                        // series.tensionX = 0.8;
                        series.showOnInit = true;

                        valueAxis.renderer.line.strokeOpacity = 0.3;
                        valueAxis.renderer.line.strokeWidth = 0.5;
                        valueAxis.renderer.line.stroke = series.stroke;
                        valueAxis.renderer.labels.template.fill = am4core.color("#000000");
                        valueAxis.title.text = series.name;
                        valueAxis.renderer.opposite = opposite;
                    }

                    createAxisAndSeries("visits", "Pressure", false);
                    createAxisAndSeries("views", "Flow", true);
                    createAxisAndSeries("hits", "CSQ", true);

                    // Add legend
                    chart.legend = new am4charts.Legend();

                    // Add cursor
                    chart.cursor = new am4charts.XYCursor();
                    chart.scrollbarX = new am4core.Scrollbar();

                    // generate some random data, quite different range
                    function generateChartData() {
                        var chartData = [];
                        var firstDate = new Date();
                        firstDate.setDate(firstDate.getDate() - 100);
                        firstDate.setHours(0, 0, 0, 0);

                        var visits = 1600;
                        var hits = 2900;
                        var views = 8700;

                        for (var i = 0; i < 60; i++) {
                            // we create date objects here. In your data, you can have date strings
                            // and then set format of your dates using chart.dataDateFormat property,
                            // however when possible, use date objects, as this will speed up chart rendering.
                            var newDate = new Date(firstDate);
                            newDate.setDate(newDate.getDate() + i);

                            visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
                            hits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
                            views += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);

                            chartData.push({
                                date: newDate,
                                visits: visits,
                                hits: hits,
                                views: views
                            });
                        }
                        return chartData;
                    }

                    function getRandomColor() {
                        var letters = '0123456789ABCDEF';
                        var color = '#';
                        for (var i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }

                    function random_rgba() {
                        var o = Math.round,
                            r = Math.random,
                            s = 255;
                        return 'rgba(' + o(r() * s) + ',' + o(r() * s) + ',' + o(r() * s) + ',' + r().toFixed(1) + ')';
                    }
                }

            })
        </script>

        <script>
            // am4core.ready(function() {

            //     // Themes begin
            //     am4core.useTheme(am4themes_animated);
            //     // Themes end

            //     // Create chart instance
            //     var chart = am4core.create("chartdiv", am4charts.XYChart);

            //     //

            //     // Increase contrast by taking evey second color
            //     // chart.colors.step = 2;

            //     // Add data
            //     chart.data = generateChartData();

            //     // Create axes
            //     var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            //     dateAxis.renderer.minGridDistance = 50;

            //     // Create series
            //     function createAxisAndSeries(field, name, opposite, bullet) {
            //         var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            //         if (chart.yAxes.indexOf(valueAxis) != 0) {
            //             valueAxis.syncWithAxis = chart.yAxes.getIndex(0);
            //         }

            //         var series = chart.series.push(new am4charts.LineSeries());
            //         series.dataFields.valueY = field;
            //         series.dataFields.dateX = "date";
            //         series.strokeWidth = 1.5;
            //         series.yAxis = valueAxis;
            //         // series.fill = am4core.color(random_rgba());
            //         series.stroke = am4core.color(random_rgba());
            //         // series.yAxis.color = 
            //         series.name = name;
            //         series.tooltipText = "{name}: [bold]{valueY}[/]";
            //         // series.tensionX = 0.8;
            //         series.showOnInit = true;

            //         valueAxis.renderer.line.strokeOpacity = 0.3;
            //         valueAxis.renderer.line.strokeWidth = 0.5;
            //         valueAxis.renderer.line.stroke = series.stroke;
            //         valueAxis.renderer.labels.template.fill = am4core.color("#000000");
            //         valueAxis.renderer.opposite = opposite;
            //     }

            //     createAxisAndSeries("visits", "Visits", false);
            //     createAxisAndSeries("views", "Views", true);
            //     createAxisAndSeries("hits", "Hits", true);

            //     // Add legend
            //     chart.legend = new am4charts.Legend();

            //     // Add cursor
            //     chart.cursor = new am4charts.XYCursor();
            //     chart.scrollbarX = new am4core.Scrollbar();

            //     // generate some random data, quite different range
            //     function generateChartData() {
            //         var chartData = [];
            //         var firstDate = new Date();
            //         firstDate.setDate(firstDate.getDate() - 100);
            //         firstDate.setHours(0, 0, 0, 0);

            //         var visits = 1600;
            //         var hits = 2900;
            //         var views = 8700;

            //         for (var i = 0; i < 60; i++) {
            //             // we create date objects here. In your data, you can have date strings
            //             // and then set format of your dates using chart.dataDateFormat property,
            //             // however when possible, use date objects, as this will speed up chart rendering.
            //             var newDate = new Date(firstDate);
            //             newDate.setDate(newDate.getDate() + i);

            //             visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
            //             hits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
            //             views += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);

            //             chartData.push({
            //                 date: newDate,
            //                 visits: visits,
            //                 hits: hits,
            //                 views: views
            //             });
            //         }
            //         return chartData;
            //     }

            //     function getRandomColor() {
            //         var letters = '0123456789ABCDEF';
            //         var color = '#';
            //         for (var i = 0; i < 6; i++) {
            //             color += letters[Math.floor(Math.random() * 16)];
            //         }
            //         return color;
            //     }

            //     function random_rgba() {
            //         var o = Math.round,
            //             r = Math.random,
            //             s = 255;
            //         return 'rgba(' + o(r() * s) + ',' + o(r() * s) + ',' + o(r() * s) + ',' + r().toFixed(1) + ')';
            //     }

            // }); // end am4core.ready()
        </script>
    </div>
</body>

</html>