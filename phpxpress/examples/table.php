<html>
    <head>
        <title>Table example</title>
    </head>
    <body>
        <?php
            include "../phpxpress/table.php";

            class Employee{
                public $name;
                public $surname;
                public $dateOfBirth;
                public $ssn;
            }

            $employee1 = new Employee;
            $employee2 = new Employee;
            $employee3 = new Employee;

            $employee1->name = 'Christopher';
            $employee1->surname = 'Anderson';
            $employee1->dateOfBirth = "01-01-1970";
            $employee1->ssn = "12345";

            $employee2->name = 'Catherine';
            $employee2->surname = 'Johnstone';
            $employee2->dateOfBirth = "02-04-1988";
            $employee2->ssn = "56789";
            
            $employee3->name = 'Anna';
            $employee3->surname = 'Brenson';
            $employee3->dateOfBirth = "10-08-1998";
            $employee3->ssn = "13579";

            $employees = array($employee1,$employee2,$employee3);

            $table = new Table;
            $table->setDataSource($employees);
            $table->setCustomCaptions(array("Name", "Surname", "Date of Birth", "Social Security Number"));

            $table->addColumn("Extra");

            $table->onValueDisplaying("onValueDisplaying");

            $table->setStripedRows(true);
            $table->setBordered(true);
            $table->setHoverAnimation(true);

            $table->draw();

            function onValueDisplaying($caption, &$value, $row){
                if($caption == "ssn"){
                    if($row["ssn"] != "12345"){
                        $value = "SSN not shown for privacy reasons";
                    }
                    else{
                        $value = $row["name"] . " " . $row["surname"] . " agreed to share their ssn (12345)" ;
                    }
                }
                else if($caption == "Extra"){
                    $value = "This column did not exist in the datasource";
                }
            }

        ?>
    </body>
</html>