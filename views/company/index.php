<style type="text/css">
  .star
  {
    color: red; font-size: 15px;
  }
</style>

<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        Manage
        <small>Company</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">company</li>
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

                <?php echo validation_errors(); ?>
            
          <?php endif; ?>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          


          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><span style="padding-left: 0px; font-size: 28px"><i class="fa fa-edit" aria-hidden="true"></i> Manage Company Information</span></h3>
            </div>
            <form role="form" action="<?php base_url('company/index') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body" style="margin-top: 40px">


                <div class="col-md-4">
                  <div class="form-group">
                    <label for="company_name">Company Name</label> <span class="star">* </span>
                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter company name" value="<?php echo $company_data['company_name'] ?>" autocomplete="off" required>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="address">Address</label> <span class="star">* </span>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="<?php echo $company_data['address'] ?>" autocomplete="off" required>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="state">State</label> <span class="star">* </span>
                    <input type="text" class="form-control" id="state" name="state" placeholder="Enter State" value="<?php echo $company_data['state'] ?>" autocomplete="off" required>


                   <!--  <select class="form-control select_group" id="state" name="state">
                      <option value="maharastra" < ?php if($company_data['state'] == 'maharastra') { echo "selected";} ?> >Maharastra</option>
                      
                    </select> -->
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="state">City</label> <span class="star">* </span>

                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" value="<?php echo $company_data['city'] ?>" autocomplete="off" required>



                    <!-- <select class="form-control select_group" id="city" name="city">
                      <option value="nagpur" < ?php if($company_data['state'] == 'nagpur') { echo "selected";} ?>>Nagpur</option>
                      <option value="mumbai" < ?php if($company_data['state'] == 'mumbai') { echo "selected";} ?>>Mumbai</option>
                      <option value="pune" < ?php if($company_data['state'] == 'pune') { echo "selected";} ?>>Pune</option>
                    </select> -->
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">Postal Code</label> <span class="star">* </span>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" value="<?php echo $company_data['postal_code'] ?>" autocomplete="off" required>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">GSTIN</label> <span class="star">&nbsp; </span>
                    <input type="text" class="form-control" id="gstin" name="gstin" placeholder="GSTIN Number" value="<?php echo $company_data['gstin'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">PAN</label> <span class="star">&nbsp; </span>
                    <input type="text" class="form-control" id="pan" name="pan" placeholder="PAN Number" value="<?php echo $company_data['pan'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">Email</label> <span class="star">&nbsp; </span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" value="<?php echo $company_data['email'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">Phone</label> <span class="star">&nbsp; </span>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone" value="<?php echo $company_data['phone'] ?>" autocomplete="off">
                  </div>
                </div>
                
                <!-- <div class="form-group">
                  <label for="currency">Currency</label>
                  < ?php ?>
                  <select class="form-control" id="currency" name="currency">
                    <option value="">~~SELECT~~</option>

                    < ?php foreach ($currency_symbols as $k => $v): ?>
                      <option value="< ?php echo trim($k); ?>" < ?php if($company_data['currency'] == $k) {
                        echo "selected";
                      } ?>>< ?php echo $k ?></option>
                    < ?php endforeach ?>
                  </select>
                </div> -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="currency">Image</label>
                    <?php ?>
                    <input type="file" name="img" class="form-control">
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <div class="pull-right" style="padding-right: 20px">
                  <a href="<?php echo base_url() ?>dashboard" class="btn btn-danger">Close</a>
                
                  <button type="submit" class="btn btn-success">Save</button>
                </div>
                
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
    $("#companyMainNav").addClass('active');
    $("#message").wysihtml5();
  });
</script>

