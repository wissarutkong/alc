<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALC System || St_design</title>
    <link rel="icon" type="image/x-icon" href="/assets/img/logo_500x500.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="bg"></header>
<section class="d-flex align-items-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <section class="col-lg-6">
        <div class="card shadow p-3 p-md-4">
          <img class="img-responsive" src="assets/img/logo.png" alt="st design">
          <h1 class="text-center text-primary font-weight-bold">ALC System</h1>
          <!-- <h4 class="text-center">ST_Design</h4>  -->
          <div class="card-body">
            <!-- HTML Form Login --> 
            <form id="formLogin">
              <div class="form-group col-sm-12">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text px-2">ชื่อผู้ใช้งาน</div>
                  </div>
                  <input type="text" class="form-control" name="username" placeholder="username" required>
                </div>
              </div>
              <div class="form-group col-sm-12">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text px-3">รหัสผ่าน</div>
                  </div>
                  <input type="password" class="form-control" name="password" placeholder="password " required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block"> เข้าสู่ระบบ</button>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>
</section>

<!-- script -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/toastr/toastr.min.js"></script>
<script>

  $(function() {
    // pop up center
  //   toastr.options={
  //   "positionClass": "toast-top-center"
  // }
    $("#formLogin").submit(function(e){
      e.preventDefault()
      $.ajax({
        type: "POST",
        url: "service/auth/login.php",
        data: $(this).serialize()
      }).done(function(resp) {
        window.toastr.remove()
        toastr.success('เข้าสู่ระบบเรียบร้อย')
        setTimeout(() => {
          location.href = 'pages/dashboard'
        }, 800)
      }).fail(function(resp) {
        window.toastr.remove()
        toastr.error('ไม่สามารถเข้าสู่ระบบได้กรุณาติดต่อบริษัท ST design')
        // toastr.error('ไม่สามารถเข้าสู่ระบบได้')
      })
    })
  })
</script>
</body>
</html>