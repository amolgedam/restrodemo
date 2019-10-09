
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

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

          
   
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> <span style="padding-left: 0px; font-size: 28px"><i class="fa fa-edit" aria-hidden="true"></i> Update Admin</h3>
            </div>
            <form role="form" action="<?php base_url('useradmin/editAdmin') ?>" method="post">
              <div class="box-body" style="margin-top: 40px">

                <?php echo validation_errors(); ?>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="username">Full Name</label>
                    <input type="hidden" class="form-control" name="id" value="<?php echo $allData['id'] ?>">
                    <input type="text" class="form-control" name="fname" placeholder="Full Name" autocomplete="off" value="<?php echo $allData['firstname'] ?>">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="username">Phone</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $allData['phone'] ?>" placeholder="Phone" autocomplete="off">
                  </div>
                </div>

              <!--   <div class="col-md-4">
                  <div class="form-group">
                    <label for="username">Gender</label><br>
                   <div style="padding-top: 15px">
                       <input type="radio" name="gender" value="1" checked=""> Male
                    <input type="radio" name="gender" value="2"> Female
                  </div>
                  </div>
                </div> -->

                

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cpassword">Validity Start From</label>
                    <input type="date" name="datefrom" class="form-control" value="<?php echo $allData['validitystartdate'] ?>" placeholder="Start Date">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cpassword">Validity (In Month)</label>
                    <input type="number" name="validity" class="form-control" value="<?php echo $allData['validity'] ?>" placeholder="Enter Validity" autocomplete="off" min="0">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cpassword">Active</label>
                    <select class="form-control" name="status">
                      <option value="1" <?php echo $allData['loginstatus'] == 1 ? "selected" : ""; ?> >Active</option>
                      <option value="0" <?php echo $allData['loginstatus'] == 0 ? "selected" : ""; ?> >Inactive</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" value="<?php echo $allData['username'] ?>" name="username" placeholder="Username" readonly autocomplete="off">
                  </div>
                </div>

                 <div class="col-md-12">
                <div class="form-group">
                  <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      Leave the password field empty if you don't want to change.
                  </div>
                </div>
              </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cpassword">Confirm password</label>
                    <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" autocomplete="off">
                  </div>
                </div>


                

              </div>
              <!-- /.box-body -->

              <div class="box-footer" style="text-align: right; padding-right: 23px">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="<?php echo base_url('superadmin/manageAdmin') ?>" class="btn btn-danger">Back</a>
              </div>
            </form>
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

