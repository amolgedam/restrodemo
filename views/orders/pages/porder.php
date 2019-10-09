<style type="text/css">
  .star
  {
    color: red; font-size: 15px;
  }
</style>

<!--< ?php echo error_reporting(0); // error_reporting(E_ERROR | E_PARSE); ?>-->
<?php
  $table = $this->model_parcel->getTableData($id);
  // echo "Table<pre>"; print_r($table); exit();
  // echo "<pre>"; print_r($gst); exit();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <?php echo validation_errors(); ?>

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

 

  <!-- Main content -->
  <section class="content">

    <?php echo form_open('order/createParcel'); ?>
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <span style="padding-left: 11px; font-size: 28px"><i class="fa fa-plus-square"></i> &nbsp; Add Order</span>
            </h3>
          </div>
          <!-- /.box-header -->
              <div class="box-body" style="margin-top: 40px">


                <!-- <div class="form-group">
                  <label for="product_image">Image</label>
                  <div class="kv-avatar">
                      <div class="file-loading">
                          <input id="product_image" name="product_image" type="file">
                      </div>
                  </div>
                </div> -->
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_name">Invoice No.</label>
                    <input type="hidden" class="form-control" value="<?php echo $tran_type; ?>" name="tran_type" readonly />
                    <input type="text" class="form-control" value="<?php echo $bill_no; ?>" name="invoice" readonly />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_name">Parcel</label>
                    <input type="hidden" class="form-control" name="table_id" value="<?php echo $table['id'] ?>" readonly=""/>
                    <input type="text" class="form-control" name="table_name" value="<?php echo "Parcel" ?>" readonly=""/>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Date Time</label>
                    <div style="margin-top: 7px">
                        <span style="font-weight: bold;">
                          <?php echo date('d F Y')." &nbsp;"; ?> <span id="myTime">
                        </span>
                      </span><br><br>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Customer Name</label>
                    <input type="text" name="cname" class="form-control" autofocus placeholder="Customer Name"/>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Mobile</label>
                    <input type="text" class="form-control" name="mobile" placeholder="Mobile"/>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Waiter</label> <span class="star">&nbsp; </span>
                    <input type="hidden" name="emp" id="empid" class="form-control" readonly>

                      <input list="test_1" class="form-control" id="empname"  name="empname[]" autofocus autocomplete="off">
                        <datalist id="test_1">
                        <?php foreach ($waiter as $k => $v): ?>
                          <option value="<?php echo $v->name ?>"><?php echo $v->name ?></option>
                        <?php endforeach ?>
                      </datalist>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Sales Type</label> <span class="star">* </span>
                    <select name="salestype" class="form-control">
                      <option value="0">Select Option</option>
                      <?php
                        foreach ($sales_type as $key => $value) {
                      ?>
                          <option value="<?php echo $value->id; ?>"><?php echo ucwords($value->name); ?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Payment Type</label> <span class="star">&nbsp; </span>
                    <select name="paymenttype" class="form-control" id="ptype">
                      <option value="0">Select Option</option>
                      <?php
                        foreach ($payment_type as $key => $value) {
                      ?>
                          <option value="<?php echo $value->id; ?>"><?php echo ucwords($value->name); ?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Gross Amount</label>  <span class="star">&nbsp; </span>
                    <input type="text" class="form-control" id="finalgprice" name="finalgprice" placeholder="Gross Price" autocomplete="off" readonly />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Discount</label>  <span class="star">&nbsp; </span>
                    <input type="text" class="form-control" id="finaldiscount" name="finaldiscount" placeholder="Discount" autocomplete="off" readonly />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">GST</label>  <span class="star">&nbsp; </span>
                    <input type="text" class="form-control" id="finalGst" name="finalGst" placeholder="GST" autocomplete="off" readonly="" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Adjustment</label>  <span class="star">&nbsp; </span>
                    <input type="text" class="form-control" name="adj" id="adj" placeholder="Adjustment" value="0" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Net Amount</label>  <span class="star">&nbsp; </span>
                    <input type="hidden" class="form-control" id="finalnetAmt2" name="finalnetAmtAdj" placeholder="Net Amount" autocomplete="off" readonly="" />
                    <input type="text" class="form-control" id="finalnetAmt" name="finalnetAmt" placeholder="Net Amount" autocomplete="off" readonly="" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Paid Status</label>  <span class="star">&nbsp; </span>
                    <select name="billstatus" class="form-control" id="paidStatus">
                      <option value="2">Unpaid</option>
                      <option value="1">Paid</option>
                    </select>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                  <div style="float: right; padding-right: 12px">
                    <!-- back to dashboard after create order -->
                    <a href="<?php echo base_url('dashboard/') ?>" class="btn btn-danger">Back</a>
                    
                    <button type="submit" class="btn btn-success">Create Order</button>
                  </div>
              </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">

                 <div class="row">
                
                      <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="col-md-4">
                            <div>
                              <label>Search Product Name</label>                              

                              <input list="test_2" class="form-control" id="pname"  name="pname[]" autofocus autocomplete="off">
                                <datalist id="test_2">
                                <?php foreach ($products as $k => $v): ?>
                                  <option value="<?php echo $v['name'] ?>"><?php echo $v['name'] ?></option>
                                <?php endforeach ?>
                              </datalist>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div>
                              <label>Search Product Code</label>

                              <input list="test_3" class="form-control" id="pcode"  name="pcode[]" autofocus autocomplete="off">
                                <datalist id="test_3">
                                <?php foreach ($products as $k => $v): ?>
                                  <option value="<?php echo $v['sr_no'] ?>"><?php echo $v['sr_no'] ?></option>
                                <?php endforeach ?>
                              </datalist>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div>
                              <br>
                                <a href="javascript:void(0);" id="find" style="margin-top: 5px;" class="btn btn-success"><i class="fa fa-plus"></i></a>
                             
                            </div>
                        </div>

                      </div>
                        
                        
                </div>
                
                <br><br>

                 <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Unit</th>
                                <th>Gst</th>

                                <th>Quantity</th>
                                <th>MRP</th>
                                <th>Dis. %</th>
                                <th>Dis. Amt</th>
                                <th>Gross Price</th>
                                <th>GST Amount</th>
                                <th>Net Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id='productData'> 
                            
                        </tbody>
                    </table>
                </div>

            </div>
          </div>
        </div>
      </div>
    
      <?php echo form_close(); ?>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script type="text/javascript">

  var base_url = "<?php echo base_url(); ?>";


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
            $('#empid').val(response.id);
           
          } // /success
        }); // /ajax function to fetch the product data 
  });
 
</script>

<script type="text/javascript">
  $(document).ready(function(){

      var base_url = '<?php echo base_url() ?>';

      $('#find').on('click', function(){

          var pname = $('#pname').val();

          if(pname != '')
          {
              $.ajax({
                url: base_url + 'products/getDataByName',
                type: 'post',
                data: {product_name : pname},
                dataType:'JSON',
                success:function(response) {
                
                  // console.log(response);
                  $('#pname').val('');
                  productData(response);

                 
                } // /success
              }); // /ajax function to fetch the product data 
          }
          else
          {
            var pcode = $('#pcode').val();
            // console.log(pcode);

              $.ajax({
                url: base_url + 'products/getDataByCode',
                type: 'post',
                data: {pcode : pcode},
                dataType:'JSON',
                success:function(response) {
                
                  // console.log(response);
                  $('#pcode').val('');
                  productData(response);
                 
                } // /success
              }); // /ajax function to fetch the product data 
          }
      });


      function productData(response){


        var table = $("#productData");
        var count_table_tbody_tr = $("#productData tr").length;
        var row_id = count_table_tbody_tr + 1;

          // console.log(response);

          $.ajax({
            
            url: base_url + 'unit_type/fecthAllData/',
            type: 'post',
            dataType: 'json',
            success:function(responseUnit){

                    // console.log(responseUnit);


                $.ajax({
            
                  url: base_url + 'gst/fecthAllData/',
                  type: 'post',
                  dataType: 'json',
                  success:function(responseGst){

                    // console.log(responseGst);


                    $.ajax({
            
                      url: base_url + 'gst/fecthAllDataByID',
                      type: 'post',
                      data: {gst_id : response.gst_id},
                      dataType:'JSON',
                      success:function(responseGst1) {

                          var cgst = parseFloat(responseGst1.cgst);
                          var sgst = parseFloat(responseGst1.sgst);
                          var igst = parseFloat(responseGst1.igst);
                          var totgst = cgst + sgst + igst;

                          var mrp = parseFloat(response.price);

                          var mytot = (mrp * totgst);
                          var tot = 100 + totgst;
                          var gstvalue = mytot / tot;

                          var gst = (gstvalue).toFixed(3); 

                          var gprice = mrp - gst; 




                          


                          var html = '';
                                            
                          html += '<tr id="row_'+row_id+'">';

                              html += '<td>';
                                html += '<input type="hidden" name="product_id[]" id="productid_'+row_id+'" value="'+response.id+'"/>';
                                html += '<input type="hidden" name="product_name[]" id="productname_'+row_id+'" value="'+response.name+'"/>';

                                html += '<span>'+response.name+'</span>';
                              html += '</td>';

                              html += '<td>';
                                html += '<select name="unit[]" id="unit_'+row_id+'" disabled="">';
                                  html += '<option value="0">---Select One---</option>';
                                                                        
                                      $.each(responseUnit, function(index, value) {
                                                                            
                                        html += '<option value="'+value.id+'">'+value.name+'</option>';
                                      });
                                html += '</select>';
                              html += '</td>';

                              html += '<td>';

                                html += '<input type="hidden" name="gstID[]" id="gst_'+row_id+'" value="'+response.gst_id+'" />';

                                  html += '<select name="gst[]" id="gst1_'+row_id+'"  onchange="getGstData('+row_id+')" disabled>';
                                        
                                        html += '<option value="0">---Select One---</option>';
                                                                        
                                          $.each(responseGst, function(index, value) {
                                                                            
                                              html += '<option value="'+value.gst_id+'">'+value.name+'</option>';
                                                                        });
                                  html += '</select>';
                              html += '</td>';

                              html += '<td>';
                                html += '<input type="text" name="quantity[]" id="quantity_'+row_id+'" value="1" style="width: 60px" onchange="getConversionData('+row_id+')"  />';
                              html += '</td>';

                              
                              html += '<td>';
                                html += '<input type="text" name="mrp[]" onchange="mrpChange1('+row_id+')"  id="baseprice_'+row_id+'" value="'+response.price+'" style="width: 60px"/>';
                              html += '</td>';
                              

                              html += '<td>';
                                html += '<input type="text" name="discount[]" id="discount_'+row_id+'" value="0" style="width: 60px" onchange="getDiscount('+row_id+')" />';
                              html += '</td>';

                              html += '<td>';
                                html += '<input type="text" name="discountAmt[]" id="disvalue_'+row_id+'" value="0" class="dislist" readonly style="width: 60px"/>';
                              html += '</td>';

                              html += '<td>';
                                html += '<input type="text" name="grossprice[]" id="grossprice_'+row_id+'" value="'+gprice+'" class="gpricelist" readonly style="width: 100px"/>';

                                html += '<input type="hidden" name="hgrossprice[]" id="hgrossprice_'+row_id+'" value="'+gprice+'" readonly>';
                                                    
                                html += '<input type="hidden" name="hgrossprice1[]" id="hgrossprice1_'+row_id+'" value="'+gprice+'" readonly>';
                                                    
                                // for cal gst on discount
                                html += '<input type="hidden" name="baseprice[]" id="hiddenbaseprice_'+row_id+'" value="'+gprice+'" class="bpclass" readonly>';

                                html += '<input type="hidden" name="hiddenbaseprice1[]" id="hiddenbaseprice1_'+row_id+'" value="'+gprice+'" readonly>';

                              html += '</td>';

                              

                              html += '<td>';

                                html += '<input type="text" name="gstAmt[]" id="gstamt_'+row_id+'" value="'+gst+'" readonly class="gstAmtList" style="width: 90px"/>';

                                html += '<input type="hidden" name="hgstamt[]" id="hgstamt_'+row_id+'" readonly value="'+gst+'">';
                                                    
                                html += '<input type="hidden" name="hgstamt1[]" id="hgstamt1_'+row_id+'" readonly value="'+gst+'">';

                              html += '</td>';

                              html += '<td>';
                                
                                html += '<input type="text" name="netAmt[]" id="finalprice_'+row_id+'" value="'+response.price+'" class="netAmtList" readonly style="width: 90px"/>';

                                html += '<input type="hidden" name="hfinalprice[]" id="hfinalprice_'+row_id+'" value="'+response.price+'" readonly>';
                                                    
                                html += '<input type="hidden" name="hfinalprice1[]" id="hfinalprice1_'+row_id+'" value="'+response.price+'" readonly>';

                              html += '</td>';

                              html += '<td>';
                                  html += '<a href="javascript:void(0);" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></a>';
                              html += '</td>';


                          html += '</tr>';


                          $('#productData').append(html);

                          $('#unit_'+row_id).val(response.unit_id);
                          $('#gst_'+row_id).val(response.gst_id);
                          $('#gst1_'+row_id).val(response.gst_id);

                          loadCount();

                      }
                    });                        

                  }
                });

            }
          });
      }

  });


  function getConversionData(row_id)
  {  
      var qty = $('#quantity_'+row_id).val();
      // var con = $('#conversion_'+row_id).val();
        
      // // alert(qty); alert(conversion);
        
        // $.ajax({
                    
        //     url: base_url + 'unit/fecthUnitDataByID/',
        //     type: 'post',
        //     dataType: 'json',
        //     data : {unit_id:con},
        //     success:function(response){
            
        //         result = parseFloat(qty, 10) / parseFloat(response.conversion, 10);
                
        //         $('#conversionvalue_'+row_id).val(result);
                
        //         cal(row_id);
        //     }
        // });
        
        qtyChange(row_id);
        
        // loadCount();
    }

    function qtyChange(row_id) {
      
        var qty = $('#quantity_'+row_id).val();
        var gprice = $('#hgrossprice1_'+row_id).val();
        
        var gprice = qty * gprice;
        gprice = (gprice).toFixed(3);
        
        $('#grossprice_'+row_id).val(gprice);
        $('#hgrossprice_'+row_id).val(gprice);
        
        // for Discount
        $('#hiddenbaseprice_'+row_id).val(gprice);
        $('#hiddenbaseprice1_'+row_id).val(gprice);
        
        var gstValue = $('#hgstamt1_'+row_id).val();


        gstValue = qty * gstValue;
        gstValue = (gstValue).toFixed(3);
        // console.log(gstValue);

        
        $('#gstamt_'+row_id).val(gstValue);
        $('#hgstamt_'+row_id).val(gstValue);
        
        var fprice = $('#hfinalprice1_'+row_id).val();
        
        var fprice1 = qty * fprice;
        fprice1 = (fprice1).toFixed(3);
        
        $('#finalprice_'+row_id).val(fprice1);
        $('#hfinalprice_'+row_id).val(fprice1);

        loadCount();

        mrpChange1(row_id);

    }


    function mrpChange1(row_id) {
      
        var baseprice = $('#baseprice_'+row_id).val();
        
        // console.log(baseprice);

        // $('#grossprice_'+row_id).val(baseprice);
        // $('#hgrossprice_'+row_id).val(baseprice);

        // getGstData(row_id);
        
        var gst_id = $('#gst_'+row_id).val();
        // alert(gst_id);
        
        $.ajax({
                    
            url: base_url + 'gst/fecthAllDataByID/',
            type: 'post',
            dataType: 'json',
            data : {gst_id:gst_id},
            success:function(response){
            
                // console.log(response);
                var sgst = parseFloat(response.sgst);
                var cgst = parseFloat(response.cgst);
                var igst = parseFloat(response.igst);
                var totgst = sgst + cgst + igst;
                // console.log(totgst);
                
                var qty = $('#quantity_'+row_id).val();
                
                var mrp = parseFloat($('#baseprice_'+row_id).val());
                
                var newmrp = mrp * qty;

                var mytot = (newmrp * totgst);
                var tot = 100 + totgst;
                var gstvalue = mytot / tot;

                var gst = (gstvalue).toFixed(3); 
                

                var gprice = newmrp - gst; 
                
                // console.log("mrp "+newmrp+" gst"+gst+" gprice "+gprice);

                $('#gstamt_'+row_id).val(gst);
                $('#hgstamt_'+row_id).val(gst);


                // cal(row_id);
                gprice = (gprice).toFixed(3);
                $('#grossprice_'+row_id).val(gprice);
                $('#hgrossprice_'+row_id).val(gprice);


                $('#hiddenbaseprice_'+row_id).val(gprice);
                $('#hiddenbaseprice1_'+row_id).val(gprice);

                var grossprice = parseFloat($('#grossprice_'+row_id).val());
                var gstamt = parseFloat($('#hgstamt_'+row_id).val());
                
                var finalamt = gstamt + grossprice;
            
                finalamt = (finalamt).toFixed(3);
                $('#finalprice_'+row_id).val(finalamt);
                $('#hfinalprice_'+row_id).val(finalamt);

                getDiscount(row_id);

                loadCount();
            }
        });
    }

    function getDiscount(row_id)
    {
        var discount = parseFloat($('#discount_'+row_id).val());
        var grossprice = parseFloat($('#hiddenbaseprice1_'+row_id).val());
        
        var discount = (grossprice * discount) / 100;

        var discountValue = (discount).toFixed(3);
        
        $('#disvalue_'+row_id).val(discountValue);
        
        var newpricevalue =  grossprice - discountValue;

        var newprice = (newpricevalue).toFixed(3);
        
        $('#grossprice_'+row_id).val(newprice);
        // $('#finalprice_'+row_id).val(newprice);

        // var oldGst = parseFloat($('#hgstamt_'+row_id).val());
        
        // var newGst = (oldGst * discount) / 100;
        // var gstvalue = oldGst - newGst;

        // var gstamount = (gstvalue).toFixed(3);

        // console.log(newprice);
        // $('#gstamt_'+row_id).val(gstamount);

        // var oldFprice = parseFloat($('#hfinalprice_'+row_id).val());
        // var newFprice = (oldFprice * discount) /100;
        // var fprice = oldFprice - newFprice;

        // $('#finalprice_'+row_id).val(fprice);
        // $('#hfinalprice_'+row_id).val(fprice);

        var gst_id = $('#gst_'+row_id).val();
        // console.log(gst_id);


        $.ajax({
                    
            url: base_url + 'gst/fecthAllDataByID/',
            type: 'post',
            dataType: 'json',
            data : {gst_id:gst_id},
            success:function(response){
            
                // console.log(response);
                var sgst = parseFloat(response.sgst);
                var cgst = parseFloat(response.cgst);
                var igst = parseFloat(response.igst);
                var totgst = sgst + cgst + igst;
                // console.log(totgst);

                // var mrp = parseFloat($('#baseprice_'+row_id).val());
                // var mytot = (newprice * totgst);
                // var tot = 100 + totgst;
                // var gstvalue = mytot / tot;
                
                
                var gstvalue = newprice * totgst / 100;
                // console.log(gst);
                var gst = (gstvalue).toFixed(3); 
                
                // console.log("gprice"+ newprice+" gst "+totgst+"= "+gst);


                $('#gstamt_'+row_id).val(gst);
                $('#hgstamt_'+row_id).val(gst);

                var final = parseFloat(gst) + parseFloat(newprice);
                // console.log(final);
                $('#finalprice_'+row_id).val(final);
                $('#hfinalprice_'+row_id).val(final);

                loadCount();
            }
        });


        loadCount();
    }

    $(document).on('click', '.remove', function(){
      $(this).closest('tr').remove();
        
        loadCount();
    });
    
</script>

<script type="text/javascript">
    
    function loadCount() {
        
        var gprice = discount = gstAmt = netAmt = 0;

        $('.gpricelist').each(function() {
            
            gprice += parseFloat($(this).val(), 10);
        });
        gprice = (gprice).toFixed(3);
        $('#finalgprice').val(gprice);

        $('.dislist').each(function() {
            
            discount += parseFloat($(this).val(), 10);
        });
        discount = (discount).toFixed(3);
        $('#finaldiscount').val(discount);

        $('.gstAmtList').each(function() {
            
            gstAmt += parseFloat($(this).val(), 10);
        });
        gstAmt = (gstAmt).toFixed(3);
        $('#finalGst').val(gstAmt);

         $('.netAmtList').each(function() {
            
            netAmt += parseFloat($(this).val(), 10);
        });
         netAmt = (netAmt).toFixed(3);
        $('#finalnetAmt').val(netAmt);
        $('#finalnetAmt2').val(netAmt);



        // finalgprice
        // finaldiscount
        // finalGst
        // finalnetAmt
        // finalnetAmt2
    }

    $('#adj').on('keyup', function(){

        var adj = parseFloat($(this).val());
        var netAmt = parseFloat($('#finalnetAmt2').val());
        
        var amt = netAmt - adj;
        amt = (amt).toFixed(3);
        $('#finalnetAmt').val(amt);
    });

    $('#paidStatus').on('blur', function(){

        var status = $(this).val();

        var ptype = $('#ptype').val();
        if(status == 1 && ptype == 0)
        {
            alert("Select Payment Type");

        }
    });

</script>