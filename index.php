<html>

<head>
    <title>Employee Page</title>
    <!-- Bootstrap for css styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <h1 class="text-primary text-center">Employee Form</h1>
    <!-- Notification for form completion -->
    <?php if ($_GET['message']) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $_GET['message']; ?>
        </div>
    <?php } ?>
  
    <div class="container">
        <div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controller.php">
                <h2>Find an Employee</h2>
                <div class="mb-3">
                    <label for="ssn">Social Security Number:</label>
                    <input type="text" class="form-control" name="ssn" value="<?= $_GET['employee']['ssn'] ?? ''; ?>">
                </div>
                <?php if ($employee = $_GET['employee']) { ?>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="lname">Last Name:</label>
                            <input type="text" class="form-control" name="lname" value="<?= $employee['lname']; ?>">
                        </div>
                        <div class=" col mb-3">
                            <label for="fname">First Name:</label>
                            <input type="text" class="form-control" name="fname" value="<?= $employee['fname']; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" name="address" value="<?= $employee['address']; ?>">
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="salary">Salary:</label>
                            <input type="text" class="form-control" name="salary" value="<?= $employee['salary']; ?>">
                        </div>
                        <div class="col mb-3">
                            <label for="dno">Department Number:</label>
                            <input type="text" class="form-control" name="dno" value="<?= $employee['dno']; ?>">
                        </div>
                        <div class="col mb-3">
                            <label for="bdate">Birth Day:</label>
                            <input type="date" class="form-control" name="bdate" value="<?= $employee['bdate']; ?>">
                        </div>
                    </div>
                <?php } ?>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
        </div>
    </div>
  
  	<!-- Print all the employees within the employee table -->	
	<div class="container">
        <div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controller.php">
                <h2>Print All Employee</h2>

                <?php if ($employee = $_GET['employee']) { 
                        /* Attempt MySQL server connection. Assuming you are running MySQL
                        server with default setting (user 'root' with no password) */
                        $link = mysqli_connect("localhost", "wang1ut", "12345678Ab!!", "wang1ut_Employee");

                        // Check connection
                        if($link === false){
                            die("ERROR: Could not connect. " . mysqli_connect_error());
                        }

                        // Attempt select query execution
                        $sql = "SELECT * FROM EMPLOYEE";
                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<th>Fname</th>";
                                        echo "<th>Lname</th>";
                                        echo "<th>Ssn</th>";
                                        echo "<th>Bdate</th>";
                            			echo "<th>Address</th>";
                              			echo "<th>Salary</th>";
                              			echo "<th>Dno</th>";
                                    echo "</tr>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Fname'] . "</td>";
                                        echo "<td>" . $row['Lname'] . "</td>";
                                        echo "<td>" . $row['Ssn'] . "</td>";
                                        echo "<td>" . $row['Bdate'] . "</td>";
                                  		echo "<td>" . $row['Address'] . "</td>";
                                  		echo "<td>" . $row['Salary'] . "</td>";
                                  		echo "<td>" . $row['Dno'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                            } else{
                                echo "No records matching your query were found.";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link);
               		
				} ?>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
        </div>
    </div>
  
  	<!-- Form for Creating Employee -->
    <!-- Change "action" to the name of your controller file -->
    <form class="container border" method="post" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controller.php">
        <h2>Add an Employee</h2>
        <div class="mb-3">
            <label for="ssn">Enter Employee Social Security Number:</label>
            <input type="text" class="form-control" name="ssn">
        </div>
        <div class="mb-3">
            <label for="lname">Employee Last name is:</label>
            <input type="text" class="form-control" name="lname">
        </div>
        <div class="mb-3">
            <label for="fname">Employee First name is:</label>
            <input type="text" class="form-control" name="fname">
        </div>
        <div class="mb-3">
            <label for="address">Employee Address is:</label>
            <input type="text" class="form-control" name="address">
        </div>
        <div class="mb-3">
            <label for="salary">Employee Salary is:</label>
            <input type="text" class="form-control" name="salary">
        </div>
        <div class="mb-3">
            <label for="dno">Department Number is:</label>
            <input type="text" class="form-control" name="dno">
        </div>
        <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
    </form>
	
  	<!-- Find the Dependent of an Employee -->
  	<div class="container">
        <div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controllerDependent.php">
                <h2>Find the Dependent of an Employee</h2>
                <div class="mb-3">
                    <label for="essn">Social Security Number Of The Employee:</label>
                    <input type="text" class="form-control" name="essn" value="<?= $_GET['dependent']['essn'] ?? ''; ?>">
                </div>
                <?php if ($dependent= $_GET['dependent']) { ?>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="dependent_name">Dependent Name:</label>
                            <input type="text" class="form-control" name="dependent_name" value="<?= $dependent['dependent_name']; ?>">
                        </div>
                        <div class=" col mb-3">
                            <label for="sex">Gender:</label>
                            <input type="text" class="form-control" name="sex" value="<?= $dependent['sex']; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="bdate">Birthday:</label>
                        <input type="date" class="form-control" name="bdate" value="<?= $dependent['bdate']; ?>">
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="relationship">Relationship:</label>
                            <input type="text" class="form-control" name="relationship" value="<?= $dependent['relationship']; ?>">
                        </div>
                    </div>
                <?php } ?>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
        </div>
    </div>
  
  	<!-- Print all the dependents within the dependent table -->	
	<div class="container">
        <div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controllerDependent.php">
                <h2>Print All Dependents Of Each Employee</h2>

                <?php if ($dependent = $_GET['dependent']) { 
                        /* Attempt MySQL server connection. Assuming you are running MySQL
                        server with default setting (user 'root' with no password) */
                        $link = mysqli_connect("localhost", "wang1ut", "12345678Ab!!", "wang1ut_Employee");

                        // Check connection
                        if($link === false){
                            die("ERROR: Could not connect. " . mysqli_connect_error());
                        }

                        // Attempt select query execution
                        $sql = "SELECT * FROM DEPENDENT";
                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<th>Essn</th>";
                                        echo "<th>Dependent_name</th>";
                                        echo "<th>Sex</th>";
                                        echo "<th>Bdate</th>";
                            			echo "<th>Relationship</th>";
                                    echo "</tr>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Essn'] . "</td>";
                                        echo "<td>" . $row['Dependent_name'] . "</td>";
                                        echo "<td>" . $row['Sex'] . "</td>";
                                        echo "<td>" . $row['Bdate'] . "</td>";
                                  		echo "<td>" . $row['Relationship'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                            } else{
                                echo "No records matching your query were found.";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link);
               		
				} ?>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
        </div>
    </div>
  
  	<!-- Form for Creating Dependent -->
    <!-- Change "action" to the name of your controller file -->
    <form class="container border" method="post" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controllerDependent.php">
        <h2>Add a Dependent For an Employee</h2>
        <div class="mb-3">
            <label for="essn">Enter Employee Social Security Number:</label>
            <input type="text" class="form-control" name="essn">
        </div>
        <div class="mb-3">
            <label for="dependent_name">Enter Dependent's Full Name (Example: FirstName LastName):</label>
            <input type="text" class="form-control" name="dependent_name">
        </div>
        <div class="mb-3">
            <label for="sex">Dependent's Gender:</label>
            <input type="text" class="form-control" name="sex">
        </div>
        <div class="mb-3">
            <label for="bdate">Birthday Of The Dependent:</label>
            <input type="date" class="form-control" name="bdate">
        </div>
        <div class="mb-3">
            <label for="relationship">Relationship With The Employee:</label>
            <input type="text" class="form-control" name="relationship">
      </div>
        <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
    </form>
  	
  	<!-- Find department -->
  	<div class="container">
        <div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controllerDepartment.php">
                <h2>Find Department By Department Number</h2>
                <div class="mb-3">
                    <label for="dnumber">Department Number:</label>
                    <input type="text" class="form-control" name="dnumber" value="<?= $_GET['department']['dnumber'] ?? ''; ?>">
                </div>
                <?php if ($department= $_GET['department']) { ?>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="dname">Dependent Name:</label>
                            <input type="text" class="form-control" name="dname" value="<?= $department['dname']; ?>">
                   		</div>
                      	<div class="col mb-3">
                            <label for="mgr_ssn">Manager Social Security Number:</label>
                            <input type="text" class="form-control" name="mgr_ssn" value="<?= $department['mgr_ssn']; ?>">
                   		</div>
                    </div>
              		<div class="row">
                      	<div class="col mb-3">
                            <label for="mgr_start_date">Department Start Date:</label>
                            <input type="text" class="form-control" name="mgr_start_date" value="<?= $department['mgr_start_date']; ?>">
                   		</div>
                    </div>
                <?php } ?>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
        </div>
    </div>
  
  	<!-- Print all the departments within the department table -->	
	<div class="container">
        <div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controllerDepartment.php">
                <h2>Print All Departments</h2>

                <?php if ($department = $_GET['department']) { 
                        /* Attempt MySQL server connection. Assuming you are running MySQL
                        server with default setting (user 'root' with no password) */
                        $link = mysqli_connect("localhost", "wang1ut", "12345678Ab!!", "wang1ut_Employee");

                        // Check connection
                        if($link === false){
                            die("ERROR: Could not connect. " . mysqli_connect_error());
                        }

                        // Attempt select query execution
                        $sql = "SELECT * FROM DEPARTMENT";
                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<th>Dname</th>";
                                        echo "<th>Dnumber</th>";
                                        echo "<th>Mgr_ssn</th>";
                                        echo "<th>Mgr_start_date</th>";
                                    echo "</tr>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Dname'] . "</td>";
                                        echo "<td>" . $row['Dnumber'] . "</td>";
                                        echo "<td>" . $row['Mgr_ssn'] . "</td>";
                                        echo "<td>" . $row['Mgr_start_date'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                            } else{
                                echo "No records matching your query were found.";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link);
               		
				} ?>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
        </div>
    </div>
	
	<!-- Find department location -->
  	<div class="container">
        <div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controllerLocations.php">
                <h2>Find Department Location</h2>
                <div class="mb-3">
                    <label for="dnumber">Department Number:</label>
                    <input type="text" class="form-control" name="dnumber" value="<?= $_GET['locations']['dnumber'] ?? ''; ?>">
                </div>
                <?php if ($dept_locations= $_GET['locations']) { ?>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="dlocation">Dependent Location:</label>
                            <input type="text" class="form-control" name="dlocation" value="<?= $dept_locations['dlocation']; ?>">
                   		</div>
                    </div>
                <?php } ?>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
        </div>
    </div>
  
  	<!-- Print all the department locations within the dept_locations table -->	
	<div class="container">
        <div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controllerLocations.php">
                <h2>Print All Department Locations</h2>

                <?php if ($dept_locations = $_GET['locations']) { 
                        /* Attempt MySQL server connection. Assuming you are running MySQL
                        server with default setting (user 'root' with no password) */
                        $link = mysqli_connect("localhost", "wang1ut", "12345678Ab!!", "wang1ut_Employee");

                        // Check connection
                        if($link === false){
                            die("ERROR: Could not connect. " . mysqli_connect_error());
                        }

                        // Attempt select query execution
                        $sql = "SELECT * FROM DEPT_LOCATIONS";
                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<th>Dnumber</th>";
                                        echo "<th>Dlocation</th>";
                                    echo "</tr>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Dnumber'] . "</td>";
                                        echo "<td>" . $row['Dlocation'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                            } else{
                                echo "No records matching your query were found.";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link);
               		
				} ?>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
        </div>
    </div>
  	
 	<!-- Find project by department number -->
    <div class="container">
        <div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controllerProject.php">
                <h2>Find Project By Department Number</h2>
                <div class="mb-3">
                    <label for="dnum">Department Number:</label>
                    <input type="text" class="form-control" name="dnum" value="<?= $_GET['project']['dnum'] ?? ''; ?>">
                </div>
                <?php if ($project= $_GET['project']) { ?>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="pname">Project Name:</label>
                            <input type="text" class="form-control" name="pname" value="<?= $project['pname']; ?>">
                        </div>
                        <div class=" col mb-3">
                            <label for="pnumber">Project Number:</label>
                            <input type="text" class="form-control" name="pnumber" value="<?= $project['pnumber']; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="plocation">Project Location:</label>
                        <input type="text" class="form-control" name="plocation" value="<?= $project['plocation']; ?>">
                    </div>
                <?php } ?>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
        </div>
    </div>
  	
  	<!-- Print all the projects within the project table -->	
	<div class="container">
        <div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controllerProject.php">
                <h2>Print All Projects</h2>

                <?php if ($project = $_GET['project']) { 
                        /* Attempt MySQL server connection. Assuming you are running MySQL
                        server with default setting (user 'root' with no password) */
                        $link = mysqli_connect("localhost", "wang1ut", "12345678Ab!!", "wang1ut_Employee");

                        // Check connection
                        if($link === false){
                            die("ERROR: Could not connect. " . mysqli_connect_error());
                        }

                        // Attempt select query execution
                        $sql = "SELECT * FROM PROJECT";
                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<th>Pname</th>";
                                        echo "<th>Pnumber</th>";
                                        echo "<th>Plocation</th>";
                                        echo "<th>Dnum</th>";
                                    echo "</tr>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Pname'] . "</td>";
                                        echo "<td>" . $row['Pnumber'] . "</td>";
                                        echo "<td>" . $row['Plocation'] . "</td>";
                                        echo "<td>" . $row['Dnum'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                            } else{
                                echo "No records matching your query were found.";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link);
               		
				} ?>
                <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
            </form>
        </div>
    </div>

	<!-- Finds all projects worked on by an employee whose social security number is given -->
  	<div class="container">
    	<div class="row">
        	<form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>viewProject.php">
                <h2>Find Project worked by an Employee</h2>
                <div class="mb-3">
                        <label for="ssn">Social Security Number:</label>
                        <input type="text" class="form-control" name="ssn" value="<?= $_GET['dcode']['ssn'] ?? ''; ?>">
                </div>	
              	<?php if ($employee = $_GET['dcode'] and $project = $_GET['dcode']) { ?>
              		<div class="row">
                    	<div class="col mb-3">
                            <label for="dno">Departmenet number:</label>
                            <input type="text" class="form-control" name="dno" value="<?= $employee['dno']; ?>">
                        </div>
                    </div>
              		
              			<div class="row">
                    		<div class="col mb-3">
                              	<label for="pname">Project Name:</label>
                            	<input type="text" class="form-control" name="pname" value="<?= $project['pname']; ?>">
                        	</div>
                          	<div class="col mb-3">
                              	<label for="pnumber">Project Number:</label>
                            	<input type="text" class="form-control" name="pnumber" value="<?= $project['pnumber']; ?>">
                        	</div>
                          	<div class="col mb-3">
                              	<label for="plocation">Project Location:</label>
                            	<input type="text" class="form-control" name="plocation" value="<?= $project['plocation']; ?>">
                          	</div>
                   		 </div>
              		
              	<?php } ?>
              	<button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
          	</form>
       	</div>
    </div>


	<!-- Find an Employee Working Hours -->
  	<div class="container">
		<div class="row">
            <form class="container border" method="get" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>viewHour.php">
                <h2>Find an Employee Working Hours</h2>
                <div class="mb-3">
                    <label for="ssn">Social Security Number:</label>
                    <input type="text" class="form-control" name="essn" value="<?= $_GET['Proessn']['essn'] ?? ''; ?>">
                </div>
                <?php if ($works_on = $_GET['Proessn']) { ?>
					 <div class="row">
                        <div class="col mb-3">
                            <label for="essn">Essn:</label>
                            <input type="text" class="form-control" name="essn" value="<?= $works_on['essn']; ?>">
                        </div>
                        <div class=" col mb-3">
                            <label for="pno">Pno:</label>
                            <input type="text" class="form-control" name="pno" value="<?= $works_on['pno']; ?>">
                        </div>                   
                    	<div class="mb-3">
                        	<label for="hours">Hours:</label>
                        	<input type="text" class="form-control" name="hours" value="<?= $works_on['hours']; ?>">
                    	</div>
                    </div>
				<?php } ?>
                <button type="submit" class="btn btn-primary mb-3" name="view">View</button>
              	<a href="index.php">
                	<button class="btn btn-primary mb-3">Clear</button>
              	</a>
            </form>
        </div>
    </div>
	
    <footer class="bg-secondary py-3 text-center">
        <a class="text-light" href="./index.html">Go back to main menu</a>
    </footer>
</body>

</html>