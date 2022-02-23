# phpxpress
The following code
```
            $employees = array($employee1,$employee2,$employee3);

            $table = new Table;
            $table->setDataSource($employees);
            $table->setCustomCaptions(array("Name", "Surname", "Date of Birth", "Social Security Number"));
            $table->setStripedRows(true);
            $table->setBordered(true);
            $table->setHoverAnimation(true);
            $table->draw();
```

Produces the following output
<img src="/phpxpress/examples/demoTable.jpg" alt="Demo">