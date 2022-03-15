<html>
    <head>
        <title>Dropdown example</title>

    </head>
    <body>
        <?php
            include "../phpxpress/dropdown.php";

            $dropdown = new Dropdown;

            $dropdown->setTitle("Title");
            $dropdown->setDataSource(array("AA" => "#" , "BB" => "#"));
            $dropdown->setSize("large");
            $dropdown->draw();
        ?>
    </body>
</html>