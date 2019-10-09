<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        Manage
        <small>Users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section> -->

    <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>
          

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><span style="padding-left: 0px; font-size: 28px"><i class="fa fa-address-book" aria-hidden="true"></i> Users</h3>

              <?php if(in_array('createUser', $user_permission)): ?>
                <a href="<?php echo base_url('users/create') ?>" class="btn pull-right" style="background-color: #428bca; color: white"><i class="fa fa-plus"></i></a>
                <br /> <br />
              <?php endif; ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top: 15px">
                <div class="table-responsive">
              <table id="userTable" class="table table-bordered table-striped">
                <thead>
                <tr style="background-color: #428bca; color: white">
                  <th width="9%">Sr. No.</th>
                  <th>Username</th>
                  <!-- <th>Email</th> -->
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Address</th>
                  <th>Group</th>
                  <th>Active</th>

                  <?php if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                  <th width="15%">Action</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                  <?php if($user_data): ?>                  
                    <?php 
                     $no = 1; foreach ($user_data as $k => $v): ?>


                    <?php
                        $empData = $this->model_waiter->fecthAllDataById($v['user_info']['emp_id']);
                        // echo "<pre>"; print_r($empData);

                        if($v['user_info']['loginstatus'] == 1)
                        {
                          $status = '<label class="label label-success">Active</label>';
                        }
                        else
                        {
                          $status = '<label class="label label-danger">Inactive</label>';
                        }
                    ?>


                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $v['user_info']['username']; ?></td>
                        <td><?php echo $v['user_info']['firstname'] .' '. $v['user_info']['lastname']; ?></td>

                        <td><?php echo $empData['mobile'] == '' ? "None" : $empData['mobile']; ?></td>
                        <td><?php echo $empData['address'] == '' ? "None" : $empData['address']; ?></td>
                        <td><?php echo $v['user_group']['group_name']; ?></td>
                        <td><?php echo $status; ?></td>

                        <?php if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>

                        <td>
                          <?php if(in_array('updateUser', $user_permission)): ?>
                            <a href="<?php echo base_url('users/edit/'.$v['user_info']['id']) ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> </a>
                          <?php endif; ?>
                          <?php if(in_array('deleteUser', $user_permission)): ?>
                            <!-- <a href="< ?php echo base_url('users/delete/'.$v['user_info']['id']) ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </a> -->

                             <a href="javascript:void(0);" class="btn btn-sm btn-danger gstDelete" data-gst_id="<?php echo $v['user_info']['id'] ?>"><i class="fa fa-trash"></i></a>

                          <?php endif; ?>
                        </td>
                      <?php endif; ?>
                      </tr>
                    <?php $no++; endforeach ?>
                  <?php endif; ?>
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Delete Users -->

  <!-- MODAL Edit-->
  <form role="form" action="<?php echo base_url('users/delete') ?>" method="post" id="deleteForm">
      <div class="modal fade" id="deleteGstModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-trash"></i> Delete Record</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
              <div class="modal-body">
                <input type="hidden" id="gst_id_edit" name="gst_id_edit" >

          <p style="font-size: 16px;">Do you really want to Delete This Record?</p>
                
               
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
              </div>
          </div>
        </div>
      </div>
  </form>


  <script type="text/javascript">
    $(document).ready(function() {
      $('#userTable').DataTable({
        'order' : [],
        });

      $("#userMainNav").addClass('active');
      $("#manageUserSubNav").addClass('active');
    });

    $('.gstDelete').on('click', function(){

        var gst_id = $(this).data('gst_id');
         $('#deleteGstModal').modal('show');
        $('[name="gst_id_edit"]').val(gst_id);
    });
  </script>
