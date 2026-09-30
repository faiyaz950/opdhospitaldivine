<link rel="stylesheet" href="css/topmenu-styles.css">

 <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hms-brand" href="index.html">
                    <span class="hms-brand-mark"><i class="fa fa-plus"></i></span>
                    <span class="hms-brand-text"><?php echo $site_name; ?><small>Hospital Management</small></span>
                </a>
            </div>

            <div class="hms-topbar-user">
                <span class="hms-user-meta"><?php echo $_SESSION['user_login']['email']; ?><small>Signed in</small></span>
                <span class="hms-avatar"><i class="fa fa-user-md"></i></span>
            </div>
            <!-- Top Menu Items -->
            
           <?php
if($_SESSION['user_login']['email'] == 'admin')
{
?>
           
           <div id='cssmenu'>
<ul>
   <li style="width:30%;">&nbsp;</li>
   <li class='active has-sub'><a href='#'><span>All Reports</span></a>
      <ul>
         <li class='has-sub'><a href='opd-report.php'><span>OPD Report</span></a>
            <!--<ul>
               <li><a href='#'><span>Sub Product</span></a></li>
               <li class='last'><a href='#'><span>Sub Product</span></a></li>
            </ul>-->
         </li>
		 
		    <li class='has-sub'><a href='investigation-report.php'><span>Investigation Report</span></a>
         </li>
         
		 
         <li class='has-sub'><a href='ipd-report.php'><span>IPD Report</span></a>
            <!--<ul>
               <li><a href='#'><span>Sub Product</span></a></li>
               <li class='last'><a href='#'><span>Sub Product</span></a></li>
            </ul>-->
         
         <li class='has-sub'><a href='outinv-report.php'><span>OutInvestigation Report</span></a>
         </li>
         
      </ul>
   </li>
   
   <li class='active has-sub'><a href='#'><span>Billing Master</span></a>
      <ul>
         <li><a href='show_bills.php'><span>All Bills</span></a>
            
         </li>
         <li><a href='get-patients-bill.php'><span>Patient Bill</span></a>
            </li>
      </ul>
   </li>
   
   <li class='active has-sub'><a href='#'><span>Expense Master</span></a>
      <ul>
         <li><a href='show_exptype.php'><span>Expense Heads</span></a>
            
         </li>
         <li><a href='show_expenses.php'><span>Manage Expenses</span></a>
            </li>
            <li><a href='expense-report.php'><span>Expense Report</span></a>
            </li>
      </ul>
   </li>
   
   <li class='active has-sub'><a href='#'><span>Income Master</span></a>
      <ul>
         <li><a href='show_incometype.php'><span>Income Heads</span></a>
            
         </li>
         <li><a href='show_incomes.php'><span>Manage Income</span></a>
            </li>
            <li><a href='income-report.php'><span>Income Report</span></a>
            </li>
      </ul>
   </li>
   
   <!--<li><a href='#'><span>About</span></a></li>
   <li class='last'><a href='#'><span>Contact</span></a></li>
--></ul>
</div>

<?php
}
?>