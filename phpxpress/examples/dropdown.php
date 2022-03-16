<html>
    <head>
        <title>Dropdown example</title>

    </head>
    <body>
        <?php
            include "../phpxpress/dropdown.php";

            $dropdown = new Dropdown;

            $dropdown->setTitle("Bank Account");
            $dropdown->setDataSource(array("Unicredit" => "#" , "United Bank" => "#" , "National Bank" => "#"));
            $dropdown->draw();
        ?>
    </body>
</html>