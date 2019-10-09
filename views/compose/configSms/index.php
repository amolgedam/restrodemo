

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SMS Configuration
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">SMS Configuration</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!--<br>-->
            <!--<div style="float:right">-->
            <!--     <a href="javascript:void(0);" data-toggle="modal" data-target="#Modal_addSmsConfig" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add SMS Config</a>-->
            <!--</div>-->
            <!--<br><br>-->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Auth Key </th>
                    <th>Route </th>
                    <th>SMS URL </th>
                    <th>Set Default </th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>aaa@gmail.com</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td width="200px">
                         <a href="javascript:void(0);" data-toggle="modal" data-target="#Modal_editSmsConfig" class="btn btn-sm btn-info">
                          <i style="color: white" class="fa fa-edit"></i> Edit
                        </a>
                        <!--<a href="#" class="btn btn-sm btn-danger"><i style="color: white" class="fa fa-trash"></i> Delete</a>-->
                      </td>
                    </tr>
                  </tbody>
                </table>
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
 <!--  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer> -->

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>

<!--  Modals -->

 <!-- Add Modal -->
      <form method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="Modal_addSmsConfig" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                    Add SMS
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="col-lg-12 col-md-12">
                      <div>
                          <div>
                            <label>Name</label>
                          </div>
                          <div>
                            <input type="text" name="name" class="form-control">
                          </div>
                      </div>
                      <div>
                          <div>
                            <label>Route</label>
                          </div>
                          <div>
                            <input type="text" name="route" class="form-control">
                          </div>
                      </div>
                      <div>
                          <div>
                            <label>Auth Key</label>
                          </div>
                          <div>
                            <input type="text" name="authKey" class="form-control">
                          </div>
                      </div>
                      <div>
                          <div>
                            <label>Sender Id</label>
                          </div>
                          <div>
                            <input type="text" name="sender" class="form-control">
                          </div>
                      </div>
                      <div>
                          <div>
                            <label>SMS Url</label>
                          </div>
                          <div>
                            <input type="text" name="sms_url" class="form-control">
                          </div>
                      </div>
                     
                       <div>
                          <div>
                            <label>Set default</label>
                          </div>
                          <div>
                            <input type="checkbox" name="default" value="default">
                          </div>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="save" value="Submit" class="btn btn-success">
                </div>
              </div>
            </div>
          </div>
      </form>

      <!-- Edit Modal -->
      <form method="POST" enctype="multipart/form-data">
          <div class="modal fade" id="Modal_editSmsConfig" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit SMS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      
                      <div class="col-lg-12 col-md-12">
                      <div>
                          <div>
                            <label>Name</label>
                          </div>
                          <div>
                            <input type="text" name="name" class="form-control">
                          </div>
                      </div>
                      <div>
                          <div>
                            <label>Route</label>
                          </div>
                          <div>
                            <input type="text" name="route" class="form-control">
                          </div>
                      </div>
                      <div>
                          <div>
                            <label>Auth Key</label>
                          </div>
                          <div>
                            <input type="text" name="authKey" class="form-control">
                          </div>
                      </div>
                      <div>
                          <div>
                            <label>Sender Id</label>
                          </div>
                          <div>
                            <input type="text" name="sender" class="form-control">
                          </div>
                      </div>
                      <div>
                          <div>
                            <label>SMS Url</label>
                          </div>
                          <div>
                            <input type="text" name="sms_url" class="form-control">
                          </div>
                      </div>
                     
                       <div>
                          <div>
                            <label>Set default</label>
                          </div>
                          <div>
                            <input type="checkbox" name="default" value="default">
                          </div>
                      </div>
                  </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" type="submit" id="btn_adsUpdate" class="btn btn-primary">Update</button>
                  </div>
                </div>
              </div>
            </div>
      </form>
      <!--END MODAL EDIT-- >