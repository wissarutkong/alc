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
                            <h1> <i class="fas fa-cogs"></i>รายการอุปกรณ์ของบริษัท</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard/">Dashboard</a></li>
                                <li class="breadcrumb-item active"><a href="#">ตั้งค่ารายการอุปกรณ์ของบริษัท</a></li>
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
                                                        <h3 class="card-title">ค้นหาอุปกรณ์</h3>
                                                    </div>
                                                </div>
                                                <div class="card-body pb-0">
                                                    <div class="form-group col-md-8 col-sm-12">
                                                        <label for="select_ddl_site">รายชื่อ Site</label>
                                                        <select id="select_ddl_site" name="select_ddl_site" class="form-control select2bs4" style="width: 100%;">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <!-- small card -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3 id="count_device_all">2,500</h3>

                                                    <p>จำนวนอุปกรณ์ทั้งหมด</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-cogs"></i>
                                                </div>
                                                <!-- <a href="#" class="small-box-footer">
                                                    More info <i class="fas fa-arrow-circle-right"></i>
                                                </a> -->
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <!-- small card -->
                                            <div class="small-box bg-info">
                                                <div class="inner">
                                                    <h3 id="count_device_insite">150</h3>

                                                    <p class="mb-0 pb-0">จำนวนอุปกรณ์ใน Site</p>
                                                    <p class="mt-0 pt-0" id="text_device_insite"></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-cog"></i>
                                                </div>
                                                <!-- <a href="#" class="small-box-footer">
                                                    More info <i class="fas fa-arrow-circle-right"></i>
                                                </a> -->
                                            </div>
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
                                    <input type="hidden" id="devices_id" name="devices_id" value="">
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
                                                <label for="select_ddl_site_id">Site</label>
                                                <select id="select_ddl_site_id" name="select_ddl_site_id" class="form-control select2bs4" style="width: 100%;" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-6">
                                            <h5 for="m_usereditor"><i class="fas fa-user-check"></i>ผู้แก้ไขล่าสุด</h5>
                                            <label name="m_usereditor">xxx</label>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6">
                                            <h5 for="m_lastupdate"><i class="fas fa-user-clock"></i>วันที่แก้ไขล่าสุด</h5>
                                            <label name="m_lastupdate">xxx</label>
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
            </section>
            <!-- /.content -->


        </div>
        <?php include '../layout/footer.php'; ?>

        <script type="text/javascript">
            $(function() {

                getddl("select_ddl_site", "site").then(() => {
                    getDatatable('')
                })

                getCountAlldata()

                $(document).on("click", ".open-modal-device", function() {
                    var deviceId = $(this).data('id');
                    $('#devices_id').val('');
                    $('#device_modal').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                    getddl("select_ddl_site_id", "site").then(() => {
                        $('#txt_title_device').text("แก้ไขข้อมูลอุปกรณ์")
                        $('#devices_id').val(deviceId);
                        getDatainfo(deviceId)
                    })

                })

                $(document).on('change', '#select_ddl_site', function() {
                    getDatatable($(this).val())
                    if ($(this).val() != '') {
                        $('#text_device_insite').text(" - " + $("option:selected", this).text())
                    } else {
                        $('#text_device_insite').text('')
                    }

                });

                function getCountAlldata() {
                    CallAPI('GET', '../../service/devicecustomer/counter.php', '').then((data) => {
                        let obj = data.response[0]
                        // console.log(obj);
                        $('#count_device_all').text(obj.count)
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                }

                function getDatainfo(id) {
                    CallAPI('GET', '../../service/devicecustomer/info.php', {
                        id: id
                    }).then((data) => {
                        let obj = data.response[0]
                        $('input[name="device_desc"]').val(obj.device_desc)
                        $('#select_ddl_site_id').val(obj.site_id).trigger('change')
                        $('label[name="m_usereditor"]').text(obj.updated_by)
                        $('label[name="m_lastupdate"]').text(obj.updated_date)
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                }

                $('#formDatadevice').on('submit', function(e) {
                    e.preventDefault()
                    $devices_id = $('#devices_id').val()
                    var formData = $('#formDatadevice').serialize() + '&id=' + $devices_id
                    CallAPI('POST', '../../service/devicecustomer/update.php',
                        formData
                    ).then((data) => {
                        toastr.success(data.message)
                        $('#device_modal').modal('hide');
                        $('#select_ddl_site').val('').trigger('change')
                        // getDatatable('')
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                });

                function getDatatable(site_id) {
                    hidePage()
                    CallAPI('GET', '../../service/devicecustomer/store.php', {
                        site_id: site_id
                    }).then((data) => {
                        let tableData = []

                        data.response.forEach(function(item, index) {
                            tableData.push([
                                ++index,
                                item.device_desc,
                                item.site_desc,
                                item.device_id,
                                item.serial,
                                item.series_desc,
                                `<div class="btn-group" role="group">
                                <a href="#" type="button" class="btn btn-warning btn-lg text-white open-modal-device" data-toggle="modal" data-id="${item.id}">
                                    <i class="far fa-edit"></i> แก้ไข
                                </a>
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
                                columns: [0, 1, 2, 3, 4, 5, 6, 7],

                            },
                            title: 'รายการอุปกรณ์',
                        }, {
                            extend: 'csv'
                        }, {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7],
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
                                title: "ชื่อ Site",
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

                            $('#count_device_insite').text(this.api().data().length)
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
            })
        </script>

    </div>

</body>

</html>