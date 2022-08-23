<?php
include_once '../authen.php';

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
              <h1>หน้าหลัก</h1>
            </div>
            <div class="col-sm-6">
              <?php if ($_SESSION['AD_PERMISSION'] == 1) {  ?>
                <div class="form-group float-sm-right col-md-5 col-sm-12">
                  <!-- <label for="select_ddl_search_company"></label> -->
                  <select id="select_ddl_search_company" name="select_ddl_search_company" class="form-control select2bs4" style="width: 100%;">
                    <option value="">เลือกบริษัท</option>
                  </select>
                </div>
              <?php }  ?>
              <!-- </ol> -->
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
              <div class="card">
                <div class="card-body">
                  <!-- Table row -->
                  <div class="row">
                    <div class="col-12 table-responsive">
                      <table id="table_dashboard" class="table table-hover table-bordered" width="100%">
                        <thead>
                          <tr class="table-primary">
                            <th>จุดติดตั้ง</th>
                            <th class="text-center">P out</th>
                            <th class="text-center">Flow</th>
                            <th class="text-center">วันเวลาอัพเดต</th>
                          </tr>
                        </thead>
                        <tbody>

                          <!-- <tr data-node-id="1">
                            <td>Site A</td>
                          </tr>
                          <tr data-node-id="1.1" data-node-pid="1">
                            <td>5511022-SL-DMA-14</td>
                            <td><span class="5511022-SL-DMA-14-pressure"></span></td>
                            <td><span class="5511022-SL-DMA-14-flow"></span></td>
                            <td><span class="5511022-SL-DMA-14-datetime"></span></td>
                          </tr>
                          <tr data-node-id="1.2" data-node-pid="1">
                            <td>5522015-SL-PRV-01</td>
                            <td><span class="5522015-SL-PRV-01-pressure"></span></td>
                            <td><span class="5522015-SL-PRV-01-flow"></span></td>
                            <td><span class="5522015-SL-PRV-01-datetime"></span></td>
                          </tr>
                          <tr data-node-id="2">
                            <td>Site B</td>
                          </tr>
                          <tr data-node-id="2.1" data-node-pid="2">
                            <td>5521025-SL-MM-03</td>
                            <td><span class="5521025-SL-MM-03-pressure"></span></td>
                            <td><span class="5521025-SL-MM-03-flow"></span></td>
                            <td><span class="5521025-SL-MM-03-datetime"></span></td>
                          </tr>
                          <tr data-node-id="2.2" data-node-pid="2">
                            <td>5512020-SL-MM-08</td>
                            <td><span class="5512020-SL-MM-08-pressure"></span></td>
                            <td><span class="5512020-SL-MM-08-flow"></span></td>
                            <td><span class="5512020-SL-MM-08-datetime"></span></td>
                          </tr> -->

                        </tbody>
                      </table>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content -->

    <?php include '../layout/footer.php'; ?>
    <script src="../../assets/plugins/mqtt/paho-mqtt-min.js"></script>
    <script src="../../assets/plugins/tabletree/jquery-simple-tree-table.js"></script>

    <script type="text/javascript">
      $(function() {

        var topic
        let permissions = <?php echo $_SESSION['AD_PERMISSION']; ?>


        if (permissions == 1) {
          getddl("select_ddl_search_company", "company").then(() => {
            // getDatatable('')
          })

          $(document).on('change', '#select_ddl_search_company', function() {
            getDatatable($(this).val())
          });
        } else {
          getDatatable('')
        }

        function getDatatable(company_id) {
          hidePage()
          CallAPI('GET', '../../service/dashboard/store.php', {
            company_id: company_id
          }).then((data) => {
            let tableData = []

            var tableRef = document.getElementById('table_dashboard').getElementsByTagName('tbody')[0];

            device_topic = []
            html_table = "";

            Object.keys(data.response).forEach(key => {
              // console.log(key, data.response[key]);
              Object.keys(data.response[key]).forEach(key_1 => {
                html_table += "<tr data-node-id='" + key + "'><td>" + key_1 + "</td></tr> "
                Object.keys(data.response[key][key_1]).forEach(key_2 => {
                  // console.log(key_1);
                  var data_temp = data.response[key][key_1][key_2]
                  // console.log(data_temp);
                  html_table += "<tr data-node-id='" + data_temp.key + "' data-node-pid='" + key + "'>"
                  html_table += "<td>" + data_temp.device_id + "</td>"
                  html_table += "<td class='text-center'><span class='" + data_temp.device_id + "-p_out'></span></td>"
                  html_table += "<td class='text-center'><span class='" + data_temp.device_id + "-flow'></span></td>"
                  html_table += "<td class='text-center'><span class='" + data_temp.device_id + "-datetime'></span></td>"
                  html_table += "</tr>"
                  device_topic.push(data_temp.device_id)
                })
              })

            });

            // console.log(device_topic);

            tableRef.innerHTML = html_table;

            // $('#table_dashboard_tbody').html(html_table)

            // console.log(html_table);

            // console.log(tableRef);

            $('#table_dashboard').simpleTreeTable({
              expander: $('#expander'),
              collapser: $('#collapser'),
              store: 'session',
              storeKey: 'simple-tree-table-basic'
            });

            inialize(device_topic)
            showPage()

          }).catch((error) => {
            toastr.error("ไม่สามารถเรียกดูข้อมูลได้").then(() => {
              console.log(error);
            })
          })
        }



        function inialize(device_topic) {
          topic = device_topic

          // const hostname = "dmama2.pwa.co.th";
          // const port = "443";
          // const clientId = "dma" + parseInt(Math.random() * 100000, 10);
          // const path = "/mqtt";

          const hostname = "127.0.0.1";
          // const hostname = "35.187.251.120";
          const port = "8083";
          const clientId = "st" + parseInt(Math.random() * 100000, 10);
          const path = "/mqtt";

          client = new Paho.MQTT.Client(hostname, Number(port), path, clientId , transport='websockets');
          client.onConnectionLost = onConnectionLost;
          client.onMessageArrived = onMessageArrived;

          client.connect({
            onSuccess: onConnect,
            reconnect: true,
          });
        }



        function onConnect() {
          console.log("mqttConnect");
          $.each(topic, function(index, value) {
            client.subscribe("relogger/" + value + "");
          })
        }

        function onConnectionLost(responseObject) {
          if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
          }
        }

        function onMessageArrived(message) {
          console.log("onMessageArrived:" + message.payloadString);
          var message_mqtt = JSON.parse(message.payloadString)

          if (message_mqtt.flow === undefined || message_mqtt.p_out === undefined) {
            message_mqtt.flow = "-"
            message_mqtt.p_out = "-"
          }

          $('.' + message_mqtt.id + '-p_out').text(String(message_mqtt.p_out))
          $('.' + message_mqtt.id + '-flow').text(String(message_mqtt.flow))
          $('.' + message_mqtt.id + '-datetime').text(String(message_mqtt.datetime))
        }

      })
    </script>

</body>

</html>