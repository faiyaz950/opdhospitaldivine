<ul class="nav navbar-nav side-nav">
                    <li class="hms-nav-section">Clinical</li>
                    <li>
                        <a href="show_patients.php"><i class="fa fa-fw fa-users"></i> Patient Master</a>
                    </li>
                    
                    <li>
                        <a href="show_opd1.php"><i class="fa fa-fw fa-stethoscope"></i> OPD - Rajat</a>
                    </li>
                   
				   <li>
                        <a href="show_opd2.php"><i class="fa fa-fw fa-stethoscope"></i> OPD - Suresh</a>
                    </li>
				   
                    <li>
                        <a href="show_investigate1.php"><i class="fa fa-fw fa-flask"></i> Investigation - Rajat</a>
                    </li>
					
					<li>
                        <a href="show_investigate2.php"><i class="fa fa-fw fa-flask"></i> Investigation - Suresh</a>
                    </li>
					
                   
                    <li>
                        <a href="show_ipd1.php"><i class="fa fa-fw fa-hospital-o"></i> IPD Management</a>
                    </li>



<?php
if($_SESSION['user_login']['email'] == 'admin')
{
?>

<li class="hms-nav-section">Masters</li>

<li>
                        <a href="show_reports.php"><i class="fa fa-fw fa-list-alt"></i> Investigation Master</a>
                    </li>
					
					   <li>
                        <a href="show_ipd.php"><i class="fa fa-fw fa-medkit"></i> IPD Master</a>
                    </li>


                    <li>
                        <a href="show_outinv_reports.php"><i class="fa fa-fw fa-file-text-o"></i> OutInvestigation Master</a>
                    </li>
                 
                    
                    <li>
                        <a href="show_admin.php"><i class="fa fa-fw fa-shield"></i> Admin Master</a>
                    </li>

                  
<?php
}
?>
<li class="hms-nav-section">Operations</li>
<li>
                        <a href="show_doctors.php"><i class="fa fa-fw fa-user-md"></i> Doctor Master</a>
                    </li>
<li>
                        <a href="show_appointment.php"><i class="fa fa-fw fa-calendar"></i> Add Appointment</a>
                    </li>
					
					 
<li>
                        <a href="show_outinvestigate.php"><i class="fa fa-fw fa-ambulance"></i> OutInv Management</a>
                    </li>
                    

<li class="hms-nav-section">Account</li>
<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-user"></i> Log-In User Info <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Login ID : <?php echo $_SESSION['user_login']['email']; ?></a>
                            </li>
                            <li>
                                <a href="logout.php"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                     <li class="hms-nav-footer">
                     <a>&copy;2026 ESW HMS . All Rights Reserved. (Developed By : Brolytics Technologies)</a>
                            </li>
                </ul>
