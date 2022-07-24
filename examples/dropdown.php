<html>
    <head>
        <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.min.css">
        <script type="text/javascript" src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
        <title>Dropdown example</title>
    </head>
    <body>
        <?php

            include "../phpxpress/Dropdown.php";

            $dropdown = new PhpXpress\Dropdown;

            $dropdown->setTitle("Bank Account");
            $dropdown->setDataSource(array("Unicredit" => "#" , "United Bank" => "#" , "National Bank" => "#"));
            $dropdown->draw();
        ?>
    </body>
</html>
