<?php
require_once '../authen.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../layout/header.php'; ?>
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
                            <h1><i class="fas fa-chart-area"></i> รายงานการจ่ายน้ำผ่านมาตร 1 วัน รายชั่วโมง</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard/">Dashboard</a></li>
                                <li class="breadcrumb-item active"><a href="#">รายงานการจ่ายน้ำผ่านมาตร 1 วัน รายชั่วโมง</a></li>
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
                                                        <h3 class="card-title">ค้นหา</h3>
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
                                                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                                                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" />
                                                                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" name="search_btn" class="btn btn-info btn-lg btn-block col-lg-1" width="100%" height="100%"><i class="fas fa-search"></i> ค้นหา</button>
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
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="tab_table_data" role="tabpanel" aria-labelledby="tab_table_data_id">
                                            <div class="overlay-wrapper">

                                                <div id="loading" style="display: none;" class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                                    <div class="text-bold pt-2">กำลังโหลดข้อมูล...</div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <table id="tables_datawithgraph" class="table table-hover" width="100%">
                                                        </table>
                                                    </div>
                                                </div>
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

        <script type="text/javascript">
            $(function() {

                $('#reservationdatetime').datetimepicker({
                    icons: {
                        time: 'far fa-clock'
                    }
                });

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

            })
        </script>
    </div>
</body>

</html>