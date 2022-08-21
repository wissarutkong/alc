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
                            <h1> <i class="fas fa-sitemap"></i> เพิ่ม / แก้ไข Site</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard/">Dashboard</a></li>
                                <li class="breadcrumb-item active"><a href="#">ตั้งค่า Site</a></li>
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
                                        <?php if ($_SESSION['AD_PERMISSION'] == 1) {  ?>
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
                                                <button type="button" class="btn btn-info col-md-4 col-sm-12 float-right open-modal-site" data-toggle="modal" data-id="">
                                                    <i class="fas fa-user-plus"></i> เพิ่ม Site
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-info col-md-3 col-sm-12 float-right open-modal-site" data-toggle="modal" data-id="">
                                                    <i class="fas fa-user-plus"></i> เพิ่ม Site
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col-12">
                                            <table id="tables_site" class="table table-hover" width="100%">
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
                                <form id="formDatasite">
                                    <input type="hidden" id="site_id" name="site_id" value="">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="site_desc">ชื่อ Site</label>
                                                <input type="text" class="form-control" name="site_desc" placeholder="ชื่อ site" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12" id="div_company_hide">
                                            <div class="form-group">
                                                <label for="select_ddl_company">บริษัท</label>
                                                <select id="select_ddl_company" name="select_ddl_company" class="form-control select2bs4" style="width: 100%;" required>
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
                <!-- <input type="hidden" id="permission" name="permission" value="<?php echo $_SESSION['AD_PERMISSION']; ?>"> -->
            </section>
            <!-- /.content -->
        </div>


        <?php include '../layout/footer.php'; ?>

        <script type="text/javascript">
            $(function() {

                let permissions = <?php echo $_SESSION['AD_PERMISSION']; ?>

                if (permissions == 1) {
                    getddl("select_ddl_search_company", "company").then(() => {
                        getDatatable('')
                    })

                    $(document).on('change', '#select_ddl_search_company', function() {
                        getDatatable($(this).val())
                    });
                } else {
                    getDatatable('')
                }


                $(document).on("click", ".open-modal-site", function() {
                    var siteId = $(this).data('id');
                    $('#site_id').val('');
                    $('#site_modal').modal({
                        show: true
                    });

                    if (permissions == 1) {
                        // console.log("admin");
                        getddl("select_ddl_company", "company").then(() => {
                            if (siteId != "") {
                                $('#txt_title_site').text("แก้ไขข้อมูล Site")
                                $('#site_id').val(siteId);
                                getDatainfo(siteId)
                            } else {
                                $('#txt_title_site').text("เพิ่ม Site")
                                $('input[name="site_desc"]').val('')
                            }
                        })
                    } else {
                        // console.log("user");
                        var element = document.getElementById("div_company_hide");
                        if (typeof(element) != 'undefined' && element != null) {
                            element.remove();
                        }
                        if (siteId != "") {
                            $('#txt_title_site').text("แก้ไขข้อมูล Site")
                            $('#site_id').val(siteId);
                            getDatainfo(siteId)
                        } else {
                            $('#txt_title_site').text("เพิ่ม Site")
                            $('input[name="site_desc"]').val('')
                        }
                    }


                })

                $('#formDatasite').on('submit', function(e) {
                    e.preventDefault()
                    $siteId = $('#site_id').val()
                    if ($siteId != "") {
                        var formData = $('#formDatasite').serialize() + '&id=' + $siteId
                    } else {
                        var formData = $('#formDatasite').serialize()
                    }
                    CallAPI('POST', $siteId != "" ? '../../service/site/update.php' : '../../service/site/create.php',
                        formData
                    ).then((data) => {
                        toastr.success(data.message)
                        $('#site_modal').modal('hide');
                        $('#select_ddl_search_company').val('').trigger('change')
                        // getDatatable()
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                });

                function getDatainfo(id) {
                    CallAPI('GET', '../../service/site/info.php', {
                        id: id
                    }).then((data) => {
                        let obj = data.response[0]
                        $('input[name="site_desc"]').val(obj.site_desc)
                        $('#select_ddl_company').val(obj.company_id).trigger('change')
                        // if (<?php echo $_SESSION['AD_PERMISSION']; ?> == 1) {
                        //     $('#select_ddl_company').val(obj.company_id).trigger('change')
                        // }
                    }).catch((error) => {
                        toastr.error(error.status)
                    })
                }

                function getDatatable(company_id) {
                    hidePage()
                    CallAPI('GET', '../../service/site/store.php', {
                        company_id: company_id
                    }).then((data) => {
                        let tableData = []

                        data.response.forEach(function(item, index) {
                            tableData.push([
                                ++index,
                                item.site_desc,
                                item.created_by,
                                item.created_date,
                                item.updated_by,
                                item.updated_date,
                                `<div class="btn-group" role="group">
                                <a href="#" type="button" class="btn btn-warning text-white open-modal-site" data-toggle="modal" data-id="${item.id}">
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
                    var $table = $('#tables_site').DataTable({
                        data: tableData,
                        dom: 'Bfrtip',
                        "info": false,
                        "destroy": true,
                        "processing": true,
                        buttons: [{
                                extend: 'copy',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5]
                                }
                            },
                            {
                                extend: 'print',
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5],

                                },
                                title: 'รายการ Site',
                            }, {
                                extend: 'csv'
                            }, {
                                extend: 'excel',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5],
                                    text: 'รายการ Site',
                                }
                            }
                        ],
                        columns: [{
                                title: "ลำดับ",
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
                                title: "ชื่อผู้แก้ไขล่าสุด",
                                className: "align-middle"
                            },
                            {
                                title: "วันที่แก้ไขล่าสุด",
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
                                        CallAPI('POST', '../../service/site/delete.php', {
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
                                        return 'site: ' + data[1]
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