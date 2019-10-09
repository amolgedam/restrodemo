<?php 
// echo "<pre>"; print_r($_SESSION); EXIT; 
?>


<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?php echo "ZEON ERP"; ?></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo "ZEON ERP" ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">

        

        <ul class="nav navbar-nav" id="headerDesktop">

          <!-- <li>
            <img src="<?php echo base_url() ?>assets/images/profile/blue1.jpg" style="width: 58px"> &nbsp;
            
          </li> -->

           <li class="dropdown notifications-menu ">
            <a href="#">
            <img src="<?php echo base_url() ?>assets/images/profile/blue1.jpg" style="width: 20px"> &nbsp;

              <span style="font-size: 14px; text-transform: uppercase;"> Welcome : <?php echo ucwords($this->session->userdata['company_name']); ?></span>
            </a>
          </li>

         
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <div class="profile_img"> 
                <!-- <span class="prfil-img"><img src="images/a.png" alt=""> </span>  -->
                <div class="user-name">
                  <i class="fa fa-user-circle" aria-hidden="true"></i>
                </div>
              </div>  
            </a>

            <ul class="dropdown-menu drp-mnu" style="width: 100px;">
              <li> <a href="<?php echo base_url(); ?>company/" style="color: black"><i class="fa fa-cog"></i> Company Profile</a> </li> 
              
              <li> <a href="<?php echo base_url(); ?>users/setting/" style="color: black"><i class="fa fa-user"></i> User Profile</a> </li> 
              <li> <a href="<?php echo base_url(); ?>auth/logout" onclick="return confirm('Are You Sure you want to Logout?');" style="color: black"><i class="fa fa-sign-out"></i>Logout</a> </li>
            </ul>





           <!--  <a href="< ?php echo base_url('auth/logout') ?>" onclick="return confirm('Are You Sure you want to Logout?');">
              <span style="font-size: 15px; text-transform: uppercase;"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
            </a> -->
          </li>

        </ul>
      </div>


    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  