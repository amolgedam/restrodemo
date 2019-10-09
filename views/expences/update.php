<style type="text/css">
  .star
  {
    color: red; font-size: 15px;
  }
</style>

<!--< ?php print_r($expencesData); exit(); ?>-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <!--  <section class="content-header">
      <h1>
      <i class="fa fa-plus-square"></i> Update Expences

      </h1>
      <ol class="breadcrumb">
        <li><a href="< ?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Expences</li>
      </ol>
    </section>
 -->

    <?php echo validation_errors(); ?>
    
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <div class="box-header">
              <h3 class="box-title">
              <span style="padding-left: 0px; font-size: 28px"><i class="fa fa-edit"></i> &nbsp; Update Expenses</span>
            </h3>
          </div>

            <div class="box-body" style="margin-top: 40px">
              <!--  -->
              <div class="row">
  <div class="col-md-12">


    <form role="form" action="<?php echo base_url('expences/updateExpences') ?>" enctype="multipart/form-data" method="post">
          <div class="tile">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="form-group">
                      <label for="exampleInputEmail1">Name</label> <span class="star">* </span>
                      <input type="text" class="form-control" name="expensename" value="<?php echo set_value('expensename', $expencesData['name']); ?>" placeholder="Enter full name">

                      <input type="hidden" name="id" value="<?php echo set_value('id', $expencesData['id']); ?>">
                    </div>
                 </div>

                 <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="form-group">
                      <label for="exampleInputEmail1">Employee Name </label>
                      <!-- <select name="emp" class="form-control">
                         <option value="0">Select Option</option>
                          < ?php 
                            foreach ($waiter as $key => $value) {
                          ?>
                              <option value="< ?php echo $value->id ?>" < ?php echo $expencesData['users_id'] == $value->id ? "Selected" : ""; ?>>< ?php echo $value->name ?></option>
                          < ?php
                          } ?>
                      </select> -->

                      <?php
                      $waiterData = $this->model_waiter->fecthAllDataById($expencesData['users_id']);
                    ?>

                    <input type="hidden" name="emp" id="emp" value="<?php echo $expencesData['users_id'] ?>" class="form-control" readonly>

                    <input list="test_1" class="form-control" id="empname" value="<?php echo $waiterData['name']; ?>" name="empname[]" autofocus autocomplete="off">
                      <datalist id="test_1">
                      <?php foreach ($waiter as $k => $v): ?>
                        <option value="<?php echo $v->name ?>"><?php echo $v->name ?></option>
                      <?php endforeach ?>
                    </datalist>

                    </div>
                 </div>
                 
                 <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="form-group">
                      <label for="exampleInputEmail1">Date</label> <span class="star">* </span>
                      <input type="date" class="form-control" name="date" value="<?php echo set_value('date', $expencesData['date']); ?>" placeholder="Enter email address">
                    </div>
                 </div>

                 <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="form-group">
                      <label for="exampleInputEmail1">Amount</label> <span class="star">* </span>
                      <input type="text" min="1" class="form-control" id="amt" name="amount" value="<?php echo set_value('amount', $expencesData['amount']); ?>" placeholder="Enter Amount" readonly>
                    </div>
                 </div>

                 <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="form-group">
                      <label for="exampleInputEmail1">Paid Amount </label> <span class="star">* </span>
                      <input type="text" min="1" class="form-control" name="paidamount" value="<?php echo set_value('amount', $expencesData['pamt']); ?>" id="pamt" placeholder="Enter Amount">
                    </div>
                 </div>

                 <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="form-group">
                      <label for="exampleInputEmail1">Balance Amount </label> <span class="star">* </span>
                      <input type="text" min="1" class="form-control" name="balamount" value="<?php echo set_value('balamount', $expencesData['bamt']); ?>" id="balamt" readonly placeholder="Enter Balance Amount">
                    </div>
                 </div>

                 <div class="col-lg-4 col-md-4 col-sm-12" >
                  <div class="form-group">
                  <label class="control-label">Paid Status</label>  <span class="star">* </span>
                  <select name="pstatus" class="form-control" id="pstatusDiv">
                      <option value="0">Select Option</option>
                      <option value="paid" <?php echo $expencesData['pstatus'] == "paid" ? "Selected" : ""; ?> >Paid</option>
                      <option value="unpaid" <?php echo $expencesData['pstatus'] == "unpaid" ? "Selected" : ""; ?> >Unpaid</option>
                      <option value="partial" <?php echo $expencesData['pstatus'] == "partial" ? "Selected" : ""; ?> >Partial</option>

                  </select>
                  </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12" id="pdateDiv">
                  <div class="form-group">
                  <label class="control-label">Paid Date</label> </label>  <span class="star">* </span>
                  <input type="date" name="pdate" value="<?php echo set_value('pdate', $expencesData['pdate']); ?>" class="form-control">
                  </div>
                </div>
                 
                 <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="form-group">
                    <label class="control-label">Expences Category</label> <span class="star">* </span>
                    <select name="expences_cat" class="form-control">
                      <option value="0">Select Option</option>

                      <?php foreach($exp_cat as $rows): ?>
                        <option value="<?php echo $rows->id; ?>" <?php echo $expencesData['expcat_id'] == $rows->id ? "Selected" : ""; ?> ><?php echo $rows->name; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <!-- <input type="text" name="methodname" id="methodname"> -->
                  </div>
                 </div>

                 <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="form-group">
                    <label class="control-label">Payment Type</label> </label>  <span class="star">&nbsp</span>
                    <select name="payment_method" id="payment_method" class="form-control">
                      <option value="0">Select Option</option>
                      
                      <?php foreach($paymentmethod as $rows): ?>
                        <option value="<?php echo $rows->id; ?>" <?php echo $expencesData['payment_method'] ==  $rows->id ? "selected" : "" ; ?> ><?php echo $rows->name; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                 </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12" id="chequeDiv" style="<?php echo ($expencesData['cheque_no'] == "" ?  '".display: none."' : ""); ?>">
                  <div class="form-group">
                  <label class="control-label">Cheque No/Cash</label>  <span class="star">&nbsp</span>
                <input type="text" name="cheque_no" placeholder="Cheque No" value="<?php echo set_value('cheque_no', $expencesData['cheque_no']) ?>" class="form-control">
                </div>
              </div>
                <div class="col-lg-4 col-md-4 col-sm-12" style="display: none;">

                <div class="form-group">
                  <label class="control-label">Reference</label> <span class="star">&nbsp</span>
                <input type="text" name="reference" value="<?php echo set_value('cheque_no', $expencesData['reference']) ?>" class="form-control">
                </div>
              </div>
              
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label class="control-label">Attachment</label> <span class="star">&nbsp</span>
                  <input type="file" name="file">
                </div>
              </div>
        

             <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="form-group">
                  <label for="exampleInputEmail1">Description</label> <span class="star">&nbsp</span>
                  <textarea class="form-control" name="description" placeholder="Enter Description"><?php echo set_value('description', $expencesData['description']); ?></textarea>
                </div>
             </div>
            </div>
          </div>
              <br><br>
            <hr>
            <div style="float: right;">
            <a href="<?php echo base_url() ?>expences" class="btn btn-danger">Close</a>
              
              <button type="submit" name="submit" id="demoNotify" class="btn btn-success">Save</button>
            </div>
        </div>
      </form> 
            </div>

            <div class="col-md-12">
                  
                      <div class="col-md-4">
                          <a target="_blank" href="<?php echo base_url() ?>assets/images/exp_img/<?php echo $expencesData['file']; ?>">
                              <img src="<?php echo base_url() ?>assets/images/exp_img/<?php echo $expencesData['file']; ?>">
                          </a>
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
 
 <!--  <div class="control-sidebar-bg"></div>

</div> -->

<!-- FOR SHIPPING MODAL OPEN -->

<!-- < ?php
  $this->load->view('admin_view/includes/modals/shippingType');
  $this->load->view('admin_view/includes/modals/createLedger');
?> -->


<script type="text/javascript">

  var base_url = "<?php echo base_url(); ?>";

  $('#payment_method').on('change', function(){

      var pmethod_id = $(this).val();
      
      $.ajax({

          url: base_url + 'paymentor/fecthDataByID',
          type: 'post',
          data: {pmethod_id : pmethod_id},
          dataType:'json',
          success:function(response) {

            if(response.name == 'cheque')
            {
                $('#chequeDiv').show();
            }
            else
            {
                $('#chequeDiv').hide();

            }
          }
      });
  });


  $('#empname').on('focusout', function(){

      var empname = $(this).val();    
      console.log(empname);

      var base_url = '<?php echo base_url() ?>';

        $.ajax({
          url: base_url + 'waiter/getDataByName',
          type: 'post',
          data: {empname : empname},
          dataType:'JSON',
          success:function(response) {
          
            console.log(response);
            $('#emp').val(response.id);
           
          } // /success
        }); // /ajax function to fetch the product data 
  });

  $('#pdateDiv').hide();

  $('#pstatusDiv').on('blur', function(){

      var status = $(this).val();
      // alert(status);
      if(status == "paid")
      {
          $('#pdateDiv').show();
      }
      else
      {
        $('#pdateDiv').hide();
      }
  });


  showPDate();

  function showPDate() {
    

    var status = $('#pstatusDiv').val();
      // alert(status);
      if(status == "paid")
      {
          $('#pdateDiv').show();
      }
      else
      {
        $('#pdateDiv').hide();
      }
  }

  $('#pamt').on('keyup', function(){

      var amt = parseFloat($('#amt').val());
      var pamt = parseFloat($(this).val());
      var bal = amt - pamt;
      // console.log(amt + " "+ pamt+" "+bal);

      $('#balamt').val(bal);
  });
 
</script>