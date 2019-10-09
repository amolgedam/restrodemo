
  <footer class="main-footer" style="height: 53px; background-color: white; color: #1F618D; ">
   <!--  <div class="pull-right hidden-xs">
      <img src="< ?php echo base_url() ?>assets/images/duresys.jpg" alt="Duresys" style="width: 100px; ">
    </div> -->
    <center>
    <span style="font-size: 18px">ZEON Restro 1.0 Powered by <a href="http://duresys.com/" style="color: #1F618D" target="_blank">DURESYS TECHNOLOGIES</a>
      </span>
    </center>
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>

<script src="<?php echo base_url() ?>assets/admin_assets/dist/js/exportToExcel.js"></script>
<script src="<?php echo base_url() ?>assets/admin_assets/dist/js/excel-gen.js"></script>
<script src="<?php echo base_url() ?>assets/admin_assets/dist/js/demo.js"></script>

<!-- ./wrapper -->

    <script>
        
        showTime();
    function showTime(){
    	
    	var dt = new Date();
		var time = dt.getHours() + " : " + dt.getMinutes() + " : " + dt.getSeconds();
		
		$('#myTime').text(time);
    }

    setInterval(function(){

    	showTime();
   	},100);

    
        
        
    </script>

</body>
</html>
