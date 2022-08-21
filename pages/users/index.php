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
              <h1> <i class="fas fa-users"></i> เพิ่ม / แก้ไขผู้ใช้งานระบบ</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">ตั้งค่าผู้ใช้งานระบบ</a></li>
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
                      <button type="button" class="btn btn-info col-md-2 col-sm-12 float-right open-modal-users" data-toggle="modal" data-id="">
                        <i class="fas fa-user-plus"></i> เพิ่มผู้ใช้งานระบบ
                      </button>
                    </div>
                  </div>
                  <div class="row pt-4">
                    <div class="col-12">
                      <table id="tables_user" class="table table-hover" width="100%">
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

        <div class="modal fade" id="users_modal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 id="txt_title_user" class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="formDatauser">
                  <input type="hidden" id="user_id" name="user_id" value="">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้งานระบบ" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" id="div_password">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="รหัสผ่านผู้ใช้งานระบบ">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8 col-sm-12">
                      <div class="form-group">
                        <label for="select_ddl_company">บริษัท</label>
                        <select id="select_ddl_company" name="select_ddl_company" class="form-control select2bs4" style="width: 100%;" required>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label for="select_ddl_permission">สิทธิ์การเข้าถึง</label>
                        <select id="select_ddl_permission" name="select_ddl_permission" class="form-control select2bs4" style="width: 100%;" required>
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
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content -->

    <?php include '../layout/footer.php'; ?>

    <script type="text/javascript">
      $(function() {

        getDatatable()

        $(document).on("click", ".open-modal-users", function() {
          $('#user_id').val('');
          var userId = $(this).data('id');
          var element = document.getElementById("div_password");
          var element_password = document.getElementById("password");
          $('#users_modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
          });
          getddl("select_ddl_company", "company").then(() => {
            getddl("select_ddl_permission", "permission").then(() => {
              if (userId != "") {
                $('#txt_title_user').text("แก้ไขผู้ใช้งานระบบ")
                $('#user_id').val(userId)
                element.style.visibility = "hidden";
                element_password.removeAttribute('required');
                getDatainfo(userId)
              } else {
                element.style.visibility = "none";
                element_password.setAttribute('required', '');
                $('#txt_title_user').text("เพิ่มผู้ใช้งาน")
                $('input[name="username"]').val('')
                $('input[name="password"]').val('')
              }
            })
          })

        });

        $('#formDatauser').on('submit', function(e) {
          e.preventDefault()
          $user_id = $('#user_id').val()
          var NameCompanyselected = $('#select_ddl_company option:selected').text()
          if ($user_id != "") {
            var formData = $('#formDatauser').serialize() + '&select_ddl_company_name=' + NameCompanyselected + '&id=' + $user_id
          } else {
            var formData = $('#formDatauser').serialize() + '&select_ddl_company_name=' + NameCompanyselected
          }
          CallAPI('POST', $user_id != "" ? '../../service/users/update.php' : '../../service/users/create.php',
            formData
          ).then((data) => {
            toastr.success(data.message)
            $('#users_modal').modal('hide');
            getDatatable()
          }).catch((error) => {
            toastr.error(error.status)
          })
        });

        function getDatainfo(userId) {
          CallAPI('GET', '../../service/users/info.php', {
            id: userId
          }).then((data) => {
            let obj = data.response[0]
            $('input[name="username"]').val(obj.username)
            // $('input[name="password"]').val(obj.password)
            $('#select_ddl_company').val(obj.company_id).trigger('change');
            $('#select_ddl_permission').val(obj.permission_id).trigger('change');
          }).catch((error) => {
            toastr.error(error.status)
          })
        }

        function getDatatable() {
          hidePage()
          CallAPI('GET', '../../service/users/store.php',
            ''
          ).then((data) => {
            let tableData = []

            data.response.forEach(function(item, index) {
              tableData.push([
                ++index,
                item.username,
                item.NAME,
                item.company_desc,
                item.permission_desc,
                item.created_at,
                item.updated_at,
                `<div class="btn-group" role="group">
                          <a href="#" type="button" class="btn btn-warning text-white open-modal-users" data-toggle="modal" data-id="${item.id}">
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

          var $table = $('#tables_user').DataTable({
            data: tableData,
            dom: 'Bfrtip',
            "info": false,
            "destroy": true,
            "processing": true,
            buttons: [{
                extend: 'copy',
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6]
                }
              },
              {
                extend: 'print',
                orientation: 'landscape',
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6]
                },
                title: 'รายการผู้ใช้งานระบบ',
              }, {
                extend: 'csv'
              }, {
                extend: 'excel',
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6],
                  text: 'User Report',
                }
              }
            ],
            columns: [{
                title: "ลำดับ",
                className: "align-middle"
              },
              {
                title: "Username",
                className: "align-middle"
              },
              {
                title: "ชื่อผู้ใช้งาน",
                className: "align-middle"
              },
              // { title: "PID", className: "align-middle"},
              {
                title: "บริษัท",
                className: "align-middle"
              },
              {
                title: "สิทธิ์การใช้งาน",
                className: "align-middle"
              },
              {
                title: "วันที่สร้าง",
                className: "align-middle"
              },
              {
                title: "วันที่เข้าใช้งานล่าสุด",
                className: "align-middle"
              },
              {
                title: "จัดการ",
                className: "align-middle"
              },
            ],
            initComplete: function() {
              $(document).on("click", ".btndelete", function() {
                var userId = $(this).data('id');
                Swal.fire({
                  text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'ใช่! ลบเลย',
                  cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                  if (result.isConfirmed) {
                    let id = $(this).data('id')
                    CallAPI('POST', '../../service/users/delete.php', {
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
                    return 'username: ' + data[1]
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

</body>

</html>