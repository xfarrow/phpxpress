<html>
    <head>
        <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.min.css">
        <title>Card example</title>
    </head>
    <body>
        <?php
            include "../phpxpress/breadcrumb.php";

            $links["Github"] = "https://www.github.com";
            $links["xfarrow"] = "https://www.github.com/xfarrow";
            $links["PhpXpress"] = "https://www.github.com/xfarrow/phoxpress";

            $breadcrumb = new BreadCrumb;

            $breadcrumb->setDataSource($links);
            $breadcrumb->draw();

            ?>
        </body>
    </html>