<?php
require_once '../authen.php';
require_once '../permission.php';
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
                            <h1> <i class="fas fa-cogs"></i> เพิ่ม / แก้ไขรายการอุปกรณ์</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard/">Dashboard</a></li>
                                <li class="breadcrumb-item active"><a href="#">ตั้งค่ารายการอุปกรณ์</a></li>
                                <!-- <li class="breadcrumb-item active">Collapsed Sidebar</li> -->
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <div class="d-flex justify-content-center">
                <div id="loader" class="spinner-border text-primary" style="width: 8rem; height: 8rem;" role="status">
                </div>
            </div>
            <!-- Main content -->
            <section style="display:none;" id="div_load" class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="d-flex justify-content-between">
                                                        <h3 class="card-title">ค้นหาบริษัท</h3>
                                                    </div>
                                                </div>
                                                <div class="card-body pb-0">
                                                    <div class="form-group col-md-8 col-sm-12">
                                                        <label for="select_ddl_search_company">รายชื่อบริษัท</label>
                                                        <select id="select_ddl_search_company" name="select_ddl_search_company" class="form-control select2bs4" style="width: 100%;">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-danger btn-lg col-md-4 col-sm-12 ml-2 float-right open-modal-series" data-toggle="modal" data-id="">
                                                <i class="fas fa-user-plus"></i> เพิ่มรุ่นอุปกรณ์
                                            </button>
                                            <button type="button" class="btn btn-outline-primary btn-lg col-md-4 col-sm-12 float-right open-modal-device" data-toggle="modal" data-id="">
                                                <i class="fas fa-user-plus"></i> เพิ่มอุปกรณ์
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col-12">
                                            <table id="tables_device" class="table table-hover" width="100%">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="series_modal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">รุ่น</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formDataseries">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="series_desc">เพิ่มรุ่นของอุปกรณ์</label>
                                                                <input type="text" class="form-control" name="series_desc" placeholder="ชื่อรุ่น" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <button type="submit" class="btn btn-primary col-sm-12 btn-block"><i class="fas fa-plus"></i> เพิ่ม</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="col-12">
                                                        <table id="tables_series" class="table table-hover" width="100%">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <div class="modal fade" id="device_modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="txt_title_device" class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formDatadevice">
                                    <!-- <input type="hidden" id="devices_id" name="devices_id" value=""> -->
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="serial">Serial อุปกรณ์</label>
                                                <input type="text" class="form-control" name="serial" placeholder="serial" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="serial">Remote ID</label>
                                                <input type="text" class="form-control" name="device_id" placeholder="Remote ID" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="select_ddl_series">รุ่นของอุปกรณ์</label>
                                                <select id="select_ddl_series" name="select_ddl_series" class="form-control select2bs4" style="width: 100%;" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="select_ddl_company_modal_device">บริษัทที่ซื้ออุปกรณ์</label>
                                                <select id="select_ddl_company_modal_device" name="select_ddl_company_modal_device" class="form-control select2bs4" style="width: 100%;" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary col-md-4 col-sm-12 btn-block">บันทึก</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <div class="modal fade" id="site_modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="txt_title_site" class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formDatasiteedit">
                                    <!-- <input type="hidden" id="devices_id" name="devices_id" value=""> -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="device_desc">ชื่อจุดติดตั้ง</label>
                                                <input type="text" class="form-control" name="device_desc" placeholder="ชื่อจุดติดตั้ง" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="select_ddl_company_modal_site">รายชื่อบริษัท</label>
                                                <select id="select_ddl_company_modal_site" name="select_ddl_company_modal_site" class="form-control select2bs4" style="width: 100%;">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="select_ddl_site_modal_site">Site</label>
                                                <select id="select_ddl_site_modal_site" name="select_ddl_site_modal_site" class="form-control select2bs4" style="width: 100%;" required>
                                                    <option value="">กรุณาเลือกบริษัท</option>
                                                </select>
                                            </div>
                                            <!-- <span class="text-red">* กรณีเปลี่ยน Site ข้ามบริษัทกรุณาแก้ไขบริษัทที่ผูกกับอุปกรณ์เสียก่อน</span> -->
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary col-md-4 col-sm-12 btn-block">บันทึก</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </section>
            <!-- /.content -->
            <input type="hidden" id="devices_id" name="devices_id" value="">
        </div>
        <?php include '../layout/footer.php'; ?>

        <script type="text/javascript">
            $(function() {

                getddl("select_ddl_search_company", "company").then(() => {
                    getDatatable('')
                })

                // getDatatable()

                //#region series ======================================

                $(document).on("click", ".open-modal-series", function() {
                    var deviceId = $(this).data('id');
                    $('#series_modal').modal({
                        show: true
                    });
                    getDatatable_series()
                })

                function getDatatable_series() {
                    CallAPI('GET', '../../service/series/store.php',
                        ''
                    ).then((data) => {
                        let tableData = []

                        data.response.forEach(function(item, index) {
                            tableData.push([
                                ++index,
                                item.series_desc,
                                item.created_by,
                                item.created_date,
                                `<div class="btn-group" role="group">
                                <button type="button" class="btn btn-danger btndelete" data-id="${item.id}" data-index="${index}">
                                    <i class="far fa-trash-alt"></i> ลบ
                                </button>
                            </div>`
                            ])
                        })

                        initDataTables_series(tableData).then((data) => {
                            data.clear().rows.add(tableData).draw(true)
                        })

                    }).catch((error) => {
                        toastr.error("ไม่สามารถเรียกดูข้อมูลได้").then(() => {
                            console.log(error);
                        })
                    })
                }

                function initDataTables_series(tableData) {
                    var $table = $('#tables_series').DataTable({
                        data: tableData,
                        "info": false,
                        "destroy": true,
                        "processing": true,
                        columns: [{
                                title: "ลำดับ",
                                className: "align-middle"
                            },
                            {
                                title: "รุ่น",
                                className: "align-middle"
                            },
                            {
                                title: "ชื่อผู้สร้าง",
                                className: "align-middle"
                            },
                            {
                                title: "วันที่สร้าง",
                                className: "align-middle"
                            },
                            {
                                title: "จัดการ",
                                className: "align-middle"
                            },
                        ],
                        initComplete: function() {
                            $(document).on("click", ".btndelete", function() {
                                Swal.fire({
                                    text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่! ลบเลย',
                                    cancelButtonText: 'ยกเลิก'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        let id = $(this).data('id')
                                        CallAPI('POST', '../../service/series/delete.php', {
                                            id: id
                                        }).then((data) => {
                                            toastr.success(data.message)
                                            getDatatable_series()
                                        }).catch((error) => {
                                            toastr.error(error.responseJSON.message)
                                        })
                                    }
                                })
                            });
                        },
                        responsive: {
                            details: {
                                display: $.fn.dataTable.Responsive.display.modal({
                                    header: function(row) {
                                        var data = row.data()
                                        return 'company: ' + data[1]
                                    }
                                }),
                                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                    tableClass: 'table'
                                })
                            }
                        },
                        language: {
                            "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                            "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                            "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                            "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                            "infoFiltered": "(filtered from _MAX_ total records)",
                            "search": 'ค้นหา',
                            "paginate": {
                                "previous": "ก่อนหน้านี้",
                                "next": "หน้าต่อไป"
                            }
                        },
                    })

                    return Promise.resolve($table)
                }

                $('#formDataseries').on('submit', function(e) {
                    e.preventDefault()
                    CallAPI('POST', '../../service/series/create.php',
                        $('#formDataseries').serialize()
                    ).then((data) => {
                        toastr.success(data.message)
                        getDatatable_series()
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                });

                //#endregion


                //#region device =========================================

                $(document).on("click", ".open-modal-device", function() {
                    var deviceId = $(this).data('id');
                    $('#devices_id').val('');
                    $('#device_modal').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                    getddl("select_ddl_company_modal_device", "company").then(() => {
                        getddl("select_ddl_series", "series").then(() => {
                            if (deviceId != "") {
                                $('#txt_title_device').text("แก้ไขข้อมูลอุปกรณ์")
                                $('#devices_id').val(deviceId);
                                getDatainfo(deviceId)
                            } else {
                                $('#txt_title_device').text("เพิ่มอุปกรณ์")
                                $('input[name="serial"]').val('')
                                $('input[name="device_id"]').val('')
                            }
                        })

                    })

                })

                $(document).on('change', '#select_ddl_search_company', function() {
                    getDatatable($(this).val())
                });

                function getDatainfo(id) {
                    CallAPI('GET', '../../service/device/info.php', {
                        id: id
                    }).then((data) => {
                        let obj = data.response[0]
                        $('input[name="serial"]').val(obj.serial)
                        $('input[name="device_id"]').val(obj.device_id)
                        $('#select_ddl_series').val(obj.series_id).trigger('change')
                        $('#select_ddl_company_modal_device').val(obj.company_id).trigger('change')
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                }


                $('#formDatadevice').on('submit', function(e) {
                    e.preventDefault()
                    $devices_id = $('#devices_id').val()
                    if ($devices_id != "") {
                        var formData = $('#formDatadevice').serialize() + '&id=' + $devices_id
                    } else {
                        var formData = $('#formDatadevice').serialize()
                    }
                    CallAPI('POST', $devices_id != "" ? '../../service/device/update.php' : '../../service/device/create.php',
                        formData
                    ).then((data) => {
                        toastr.success(data.message)
                        $('#device_modal').modal('hide');
                        $('#select_ddl_search_company').val('').trigger('change')
                        // getDatatable('')
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                });

                function getDatatable(company_id) {
                    hidePage()
                    CallAPI('GET', '../../service/device/store.php', {
                        company_id: company_id
                    }).then((data) => {
                        let tableData = []

                        data.response.forEach(function(item, index) {
                            tableData.push([
                                ++index,
                                item.device_desc,
                                item.device_id,
                                item.serial,
                                item.series_desc,
                                item.company_desc,
                                item.site_desc,
                                item.created_by,
                                item.created_date,
                                `<div class="btn-group" role="group">
                                <a href="#" type="button" class="btn btn-warning text-white open-modal-device" data-toggle="modal" data-id="${item.id}">
                                    <i class="far fa-edit"></i> แก้ไข
                                </a>
                                <a href="#" type="button" class="btn btn-success text-white open-modal-site" data-toggle="modal" data-id="${item.id}">
                                    <i class="far fa-edit"></i> แก้ไข Site
                                </a>
                                <button type="button" class="btn btn-danger btndelete" data-id="${item.id}" data-index="${index}">
                                    <i class="far fa-trash-alt"></i> ลบ
                                </button>
                            </div>`
                            ])
                        })

                        initDataTables(tableData).then((data) => {
                            data.clear().rows.add(tableData).draw(true)
                            showPage()
                        })

                    }).catch((error) => {
                        toastr.error("ไม่สามารถเรียกดูข้อมูลได้").then(() => {
                            console.log(error);
                        })
                    })
                }

                function initDataTables(tableData) {

                    var $table = $('#tables_device').DataTable({
                        data: tableData,
                        dom: 'Bfrtip',
                        "info": false,
                        "destroy": true,
                        "processing": true,
                        buttons: [{
                            extend: 'print',
                            orientation: 'landscape',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],

                            },
                            title: 'รายการอุปกรณ์',
                        }, {
                            extend: 'csv'
                        }, {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                                text: 'รายการอุปกรณ์',
                            }
                        }],
                        columns: [{
                                title: "ลำดับ",
                                className: "align-middle"
                            },
                            {
                                title: "ชื่อจุดติดตั้ง",
                                className: "align-middle"
                            },
                            {
                                title: "Remote ID",
                                className: "align-middle"
                            },
                            {
                                title: "Serial อุปกรณ์",
                                className: "align-middle"
                            },
                            {
                                title: "รุ่น",
                                className: "align-middle"
                            },
                            {
                                title: "บริษัท",
                                className: "align-middle"
                            },
                            {
                                title: "ชื่อ Site",
                                className: "align-middle"
                            },
                            {
                                title: "ชื่อผู้สร้าง",
                                className: "align-middle"
                            },
                            {
                                title: "วันที่สร้าง",
                                className: "align-middle"
                            },
                            {
                                title: "จัดการ",
                                className: "align-middle"
                            },
                        ],
                        initComplete: function() {
                            $(document).on("click", ".btndelete", function() {
                                Swal.fire({
                                    text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่! ลบเลย',
                                    cancelButtonText: 'ยกเลิก'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        let id = $(this).data('id')
                                        CallAPI('POST', '../../service/device/delete.php', {
                                            id: id
                                        }).then((data) => {
                                            toastr.success(data.message)
                                            getDatatable('')
                                        }).catch((error) => {
                                            toastr.error(error.responseJSON.message)
                                        })
                                    }
                                })
                            });
                        },
                        responsive: {
                            details: {
                                display: $.fn.dataTable.Responsive.display.modal({
                                    header: function(row) {
                                        var data = row.data()
                                        return 'device: ' + data[1]
                                    }
                                }),
                                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                    tableClass: 'table'
                                })
                            }
                        },
                        language: {
                            "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                            "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                            "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                            "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                            "infoFiltered": "(filtered from _MAX_ total records)",
                            "search": 'ค้นหา',
                            "paginate": {
                                "previous": "ก่อนหน้านี้",
                                "next": "หน้าต่อไป"
                            }
                        },
                    })

                    return Promise.resolve($table)
                }

                //#endregion

                $(document).on("click", ".open-modal-site", function() {
                    var deviceId = $(this).data('id');
                    $('#devices_id').val('');
                    $('#site_modal').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                    getddl("select_ddl_company_modal_site", "company").then(() => {
                        $('#txt_title_site').text("แก้ไขข้อมูลจุดติดตั้งและ Site")
                        $('#devices_id').val(deviceId);
                        $('#select_ddl_site_modal_site').prop('disabled', true);
                        getDatainfomodalSite(deviceId)
                    })
                })

                // $(document).on('change', '#select_ddl_company_modal_site', function(e) {
                //     e.preventDefault();
                //     console.log("1.1 ==> " + $(this).val());
                //     if ($(this).val() != '') {
                //         $('#select_ddl_site_modal_site').removeAttr('disabled');
                //         getddlbyId("select_ddl_site_modal_site", "site", $(this).val()).then(() => {
                //             console.log("1");
                //         })
                //     } else {
                //         $('#select_ddl_site_modal_site').prop('disabled', true);
                //         $('#select_ddl_site_modal_site').html("<option value=''>กรุณาเลือกบริษัท</option>").trigger('change');
                //     }

                // });

                $("#select_ddl_company_modal_site").on('change', function() {
                    if ($(this).val() != '') {
                        $('#select_ddl_site_modal_site').removeAttr('disabled');
                        getddlbyId("select_ddl_site_modal_site", "site", $(this).val()).then(() => {})
                    } else {
                        $('#select_ddl_site_modal_site').prop('disabled', true);
                        $('#select_ddl_site_modal_site').html("<option value=''>กรุณาเลือกบริษัท</option>").trigger('change');
                    }
                });

                function getDatainfomodalSite(id) {
                    CallAPI('GET', '../../service/device/info.php', {
                        id: id
                    }).then((data) => {
                        let obj = data.response[0]
                        // console.log(obj);
                        $('input[name="device_desc"]').val(obj.device_desc)
                        $('#select_ddl_company_modal_site').val(obj.company_id).trigger('change')
                        // inialddlsite_thendate(obj).then(() => {
                        //     console.log("[then]");
                        //     // $('#select_ddl_site_modal_site').val(obj.site_id).trigger('change')
                        // })
                        // $('#select_ddl_company_modal_site').val(obj.company_id).trigger('change')
                        // $.when($('#select_ddl_company_modal_site').val(obj.company_id).change()).then(() => {
                        //     getddlbyId("select_ddl_site_modal_site", "site", $(this).val()).then(() => {
                        //         console.log("2");
                        //         $('#select_ddl_site_modal_site').val(obj.site_id).trigger('change')
                        //     })
                        // })
                    }).catch((error) => {
                        toastr.error(error.status)
                    }).finally((data) => {
                        // console.log();
                    });



                }


                $('#formDatasiteedit').on('submit', function(e) {
                    e.preventDefault()
                    $devices_id = $('#devices_id').val()
                    var formData = $('#formDatasiteedit').serialize() + '&id=' + $devices_id
                    CallAPI('POST','../../service/device/updatesite.php',
                        formData
                    ).then((data) => {
                        toastr.success(data.message)
                        $('#site_modal').modal('hide');
                        $('#select_ddl_search_company').val('').trigger('change')
                        // getDatatable('')
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                });

                // function inialddlsite_thendate(object) {
                //     $('#select_ddl_company_modal_site').val(object.company_id).trigger('change')
                //     return Promise.resolve()
                // }




            })
        </script>
    </div>
</body>

</html>