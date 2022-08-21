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
                            <h1> <i class="fas fa-building"></i> เพิ่ม / แก้ไขบริษัท</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard/">Dashboard</a></li>
                                <li class="breadcrumb-item active"><a href="#">ตั้งค่าบริษัท</a></li>
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
                                        <div class="col-12">
                                            <button type="button" class="btn btn-info col-md-2 col-sm-12 float-right open-modal-company" data-toggle="modal" data-id="">
                                                <i class="fas fa-user-plus"></i> เพิ่มบริษัท
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col-12">
                                            <table id="tables_company" class="table table-hover" width="100%">
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

                <div class="modal fade" id="company_modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="txt_title_company" class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formDatacompany">
                                    <input type="hidden" id="company_id" name="company_id" value="">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="username">ชื่อบริษัท</label>
                                                <input type="text" class="form-control" name="company" placeholder="ชื่อบริษัท" required>
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
            </section>
            <!-- /.content -->

        </div>

        <?php include '../layout/footer.php'; ?>

        <script type="text/javascript">
            $(function() {

                getDatatable()

                $(document).on("click", ".open-modal-company", function() {
                    var companyId = $(this).data('id');
                    $('#company_id').val('');
                    $('#company_modal').modal({
                        show: true
                    });
                    if (companyId != "") {
                        $('#txt_title_company').text("แก้ไขบริษัท")
                        $('#company_id').val(companyId);
                        getDatainfo(companyId)
                    } else {
                        $('#txt_title_company').text("เพิ่มบริษัท")
                        $('input[name="company"]').val('')
                    }
                })


                $('#formDatacompany').on('submit', function(e) {
                    e.preventDefault()
                    $company_id = $('#company_id').val()
                    if ($company_id != "") {
                        var formData = $('#formDatacompany').serialize() + '&id=' + $company_id
                    } else {
                        var formData = $('#formDatacompany').serialize()
                    }
                    CallAPI('POST', $company_id != "" ? '../../service/company/update.php' : '../../service/company/create.php',
                        formData
                    ).then((data) => {
                        toastr.success(data.message)
                        $('#company_modal').modal('hide');
                        getDatatable()
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                });

                function getDatainfo(id) {
                    CallAPI('GET', '../../service/company/info.php', {
                        id: id
                    }).then((data) => {
                        let obj = data.response[0]
                        $('input[name="company"]').val(obj.company_desc)
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                }


                function getDatatable() {
                    hidePage()
                    CallAPI('GET', '../../service/company/store.php',
                        ''
                    ).then((data) => {
                        let tableData = []

                        data.response.forEach(function(item, index) {
                            tableData.push([
                                ++index,
                                item.company_desc,
                                item.created_by,
                                item.created_date,
                                `<div class="btn-group" role="group">
                                <a href="#" type="button" class="btn btn-warning text-white open-modal-company" data-toggle="modal" data-id="${item.id}">
                                    <i class="far fa-edit"></i> แก้ไข
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

                    var $table = $('#tables_company').DataTable({
                        data: tableData,
                        dom: 'Bfrtip',
                        "info": false,
                        "destroy": true,
                        "processing": true,
                        buttons: [{
                                extend: 'copy',
                                exportOptions: {
                                    columns: [0, 1, 2, 3]
                                }
                            },
                            {
                                extend: 'print',
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: [0, 1, 2, 3],

                                },
                                title: 'รายการบริษัท',
                            }, {
                                extend: 'csv'
                            }, {
                                extend: 'excel',
                                exportOptions: {
                                    columns: [0, 1, 2, 3],
                                    text: 'รายการบริษัท',
                                }
                            }
                        ],
                        columns: [{
                                title: "ลำดับ",
                                className: "align-middle"
                            },
                            {
                                title: "ชื่อบริษัท",
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
                                        CallAPI('POST', '../../service/company/delete.php', {
                                            id: id
                                        }).then((data) => {
                                            toastr.success(data.message)
                                            getDatatable()
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


            })
        </script>
    </div>
</body>

</html>