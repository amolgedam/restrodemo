<!-- < ?php print_r($user_data); exit(); echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?> -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <!--  <section class="content-header">
      <h1>
        User
        <small>Setting</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Setting</li>
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">


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

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><span style="padding-left: 0px; font-size: 28px"><i class="fa fa-edit" aria-hidden="true"></i> Update Information</span></h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php base_url('users/setting') ?>" method="post">
              <div class="box-body" style="margin-top: 40px">

                <?php echo validation_errors(); ?>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $user_data['username'] ?>" autocomplete="off">
                  </div>
                </div>

                <!-- <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="< ?php echo $user_data['email'] ?>" autocomplete="off">
                  </div> 
                </div>    -->            

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="fname">Name </label>
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" value="<?php echo $user_data['firstname'] ?>" autocomplete="off">
                  </div>
                </div>

               <!--  <div class="col-md-4">
                  <div class="form-group">
                    <label for="lname">Last name</label>
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" value="< ?php echo $user_data['lastname'] ?>" autocomplete="off">
                  </div>
                </div> -->

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">Mobile</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo $user_data['phone'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="gender">Gender</label>
                    <div class="radio">
                      <label>
                        <input type="radio" name="gender" id="male" value="1" <?php if($user_data['gender'] == 1) {
                          echo "checked";
                        } ?>> 
                        Male
                      </label>
                      <label>
                        <input type="radio" name="gender" id="female" value="2" <?php if($user_data['gender'] == 2) {
                          echo "checked";
                        } ?>>
                        Female
                      </label>
                    </div>
                  </div>
                </div>

                <?php
                  if($user_data != 0)
                  {
                    $empData = $this->model_waiter->fecthAllDataById($user_data['emp_id']);
                    $address = $empData['address'];
                  }
                  else
                  {
                    $address = '';
                  }
                ?>

                <?php if($user_data['emp_id'] != 0){ ?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="phone">Address</label>
                      <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" autocomplete="off">
                    </div>
                  </div>
                <?php } ?>

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
                    <input type="text" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
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

              <div class="box-footer" >
                <div class="pull-right" style="padding-right: 20px">
                  <a href="<?php echo base_url('dashboard/') ?>" class="btn btn-danger">Close</a> 
                  <button type="submit" class="btn btn-success" >Save</button>
                  
                </div>
              
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
       
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $("#settingMainNav").addClass('active');
    });
  </script>
 
