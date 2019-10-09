

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        Compose Email And Sms
      </h1>
      <ol class="breadcrumb">
        <li><a href="< ?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Compose Email And Sms</li>
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-7">
          <div class="box">

            <div class="box-header">
            <h3 class="box-title">
              <span style="padding-left: 0px; font-size: 28px"><i class="fa fa-address-book" aria-hidden="true"></i>
              Compose Email And Sms
              </span>
              
          </h3>
            <div class="box-body" style="margin-top: 40px">
              
                <div>
                    <div>
                      <label>SMS For</label>
                    </div>
                    <div>
                      <select name="for" class="form-control">
                          <option>---select one---</option>
                      </select>
                    </div>
                </div>
                <br>
                <div>
                    <div>
                      <label>To</label>
                    </div>
                    <div>
                      <input type="text" class="form-control" id="tokenfield" value="amol, sagar"/>
                    </div>
                </div>
                <br>
                <div>
                    <div>
                      <label>Message</label>
                    </div>
                    <div>
                      <textarea name="message" class="form-control"></textarea>
                    </div>
                </div>
                <hr>
                <div align="right">
                    <a href="#" class="btn" style="background-color: #428BCA; color: white">Send SMS</a>
                    <a href="#" class="btn" style="background-color: #428BCA; color: white">Send Email</a>
                </div>

            </div>
            <!-- /.box-body -->
          </div>

        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
