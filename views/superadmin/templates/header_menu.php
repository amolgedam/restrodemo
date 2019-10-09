<?php 
// echo "<pre>"; print_r($_SESSION); EXIT; 
?>

<!-- <style type="text/css">

    #header_data{
      display: none;
    }

    @media (max-width: 523px){

      #headerDesktop{
        display: none;
      }

      #header_data{
        margin-top: 3px;
        color: white;
        display: block;
        font-size: 15px; 
        text-transform: uppercase;
      }

    }
</style> -->


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

           <li class="dropdown notifications-menu ">
            <a href="#">
              <span style="font-size: 15px; text-transform: uppercase; font-weight: bold;">Welcome : <?php echo ucwords($this->session->userdata['company_name']) ?></span>
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
  