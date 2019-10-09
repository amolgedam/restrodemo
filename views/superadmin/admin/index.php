
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <div id="messages"></div>

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

          
             <?php echo validation_errors(); ?>  

                  <?php if(!empty($errors)) {
                    echo $errors;
                  } 
              ?>

           <?php
                if($feedback = $this->session->flashdata('feedback'))
                {
                    $feedback_class = $this->session->flashdata('feedback_class');
            ?>
                    <div class="form-group col-12">
                        <div class="">
                            <div class="alert <?= $feedback_class?>">
                                <?= $feedback ?>
                            </div>
                        </div>
                    </div>
            <?php }?>
            
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><span style="padding-left: 0px; font-size: 28px"><i class="fa fa-address-book" aria-hidden="true"></i> Manage Admin</h3>

            <!-- <a href="< ?php echo base_url(); ?>superadmin/createAdmin" class="btn pull-right" style="background-color: #428bca; color: white"><i class="fa fa-plus"></i></a> -->

            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top: 15px">
                <div class="table-responsive">
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr style="background-color: #428bca; color: white">
                  <th width="9%">Sr. No.</th>
                  <th>Username</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Status</th>
                  <th width="15%">Action</th>
                </tr>
                </thead>
                <tbody>

                  <?php
                    $no=1;
                    foreach ($allData as $key => $value) {

                      $status = $value['loginstatus'] == 1 ? "Active" : "Inactive";
                  ?>
                    <tr>
                        <td>&nbsp; <?php echo $no; ?></td>
                        <td>&nbsp; <?php echo $value['username']; ?></td>
                        <td>&nbsp; <?php echo ucwords($value['firstname']); ?></td>
                        <td>&nbsp; <?php echo $value['phone']; ?></td>
                        <td>&nbsp; <?php echo $status; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>superadmin/editAdmin/<?php echo $value['id']; ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                            <!-- <a href="< ?php echo base_url(); ?>superadmin/deleteAdmin/< ?php echo $value['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('You Want to Delete Record?');"><i class="fa fa-trash"></i></a> -->
                        </td>
                    </tr>
                  <?php
                    }
                  ?>


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


  <!-- MODAL Edit-->
  <form role="form" action="<?php echo base_url('waiter/deleteWaiter') ?>" method="post" id="deleteForm">
      <div class="modal fade" id="deleteWaiterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-trash"></i> Delete Record</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
              <div class="modal-body">
                <input type="hidden" id="waiter_id_edit" name="waiter_id_edit" >

                <strong>Are you sure to delete this record?</strong>
                
               
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Delete</button>
              </div>
          </div>
        </div>
      </div>
  </form>


<script type="text/javascript">
  
    $(document).ready(function() {
      $('#example').DataTable( {
      } );
  } );
</script>


