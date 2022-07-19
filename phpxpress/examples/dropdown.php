<html>
    <head>
        <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.min.css">
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