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
    </section>
 -->

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

                <?php echo validation_errors(); ?>
            
          <?php endif; ?>


    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> <span style="padding-left: 0px; font-size: 28px"><i class="fa fa-address-book" aria-hidden="true"></i> Add User</h3>
            </div>
            <form role="form" action="<?php base_url('users/create') ?>" method="post">
              <div class="box-body" style="margin-top: 40px">

 
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="groups">Employee</label>
                    <!-- <select class="form-control" id="groups" name="groups"> -->
                    <!-- <select class="form-control" name="emp">
                      <option value="">Select Employee</option>
                      < ?php foreach ($emp as $k => $v): ?>
                        <option value="< ?php echo $v->id ?>">< ?php echo $v->name; ?></option>
                      < ?php endforeach ?>
                    </select>
 -->

                    <input type="hidden" name="emp" id="emp" class="form-control" readonly>

                    <input list="test_1" class="form-control" id="empname"  name="empname[]" autofocus required>
                      <datalist id="test_1">
                      <?php foreach ($emp as $k => $v): ?>
                        <option value="<?php echo $v->name ?>"><?php echo $v->name ?></option>
                      <?php endforeach ?>
                    </datalist>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="groups">Groups</label>
                    <!-- <select class="form-control" id="groups" name="groups"> -->
                    <select class="form-control" name="groups">
                      <option value="">Select Groups</option>
                      <?php foreach ($group_data as $k => $v): ?>
                        <option value="<?php echo $v['id'] ?>"><?php echo $v['group_name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="groups">Store</label>
                    <select class="form-control" id="store" name="store">
                      <option value="">Select store</option>
                      <?php foreach ($store_data as $k => $v): ?>
                        <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off">
                  </div>
                </div>

                <!-- <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off">
                </div> -->

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

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cpassword">Active</label>
                    <select class="form-control" name="status">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </div>
                </div>

                <!-- <div class="form-group">
                  <label for="fname">First name</label>
                  <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" autocomplete="off">
                </div> -->

                <!-- <div class="form-group">
                  <label for="lname">Last name</label>
                  <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" autocomplete="off">
                </div> -->

                <!-- <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" autocomplete="off">
                </div> -->

                <!-- <div class="form-group">
                  <label for="gender">Gender</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gender" id="male" value="1">
                      Male
                    </label>
                    <label>
                      <input type="radio" name="gender" id="female" value="2">
                      Female
                    </label>
                  </div>
                </div> -->

              </div>
              <!-- /.box-body -->

              <div class="box-footer" style="text-align: right; padding-right: 23px">
                <a href="<?php echo base_url('users/') ?>" class="btn btn-danger">Close</a>
                
                <button type="submit" class="btn btn-success">Save</button>
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

<script type="text/javascript">
  $(document).ready(function() {
    $("#groups").select2();

    $("#userMainNav").addClass('active');
    $("#createUserSubNav").addClass('active');
    
  });

  $('#empname').on('blur', function(){

      var empname = $(this).val();    
      // alert(empname);

      var base_url = '<?php echo base_url() ?>';


        $.ajax({
          url: base_url + 'waiter/getDataByName',
          type: 'post',
          data: {empname : empname},
          dataType:'JSON',
          success:function(response) {
          
            // console.log(response);
            $('#emp').val(response.id);
           
          } // /success
        }); // /ajax function to fetch the product data 
  });

</script>
