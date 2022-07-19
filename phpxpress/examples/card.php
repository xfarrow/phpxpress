<html>
    <head>
        <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.min.css">
        <title>Card example</title>
    </head>
    <body>
        <?php
            include "../phpxpress/card.php";

            Card::beginCardGroupLayout(36);

            // Rome

            $card1 = new Card;
            $card1->setImageSource("./images/colosseum.jpg");
            $card1->setTitle("Rome");
            $card1->setSubTitle("Capital of Italy");
            $card1->setInnerText("After the foundation by Romulus according to a legend, Rome was ruled for a period of 244 years by a monarchical system, initially with sovereigns of Latin and Sabine origin, later by Etruscan kings.");
            $card1->setFooterText("Image By John");
            $card1->addField("Mayor", "Roberto Gualtieri");
            $card1->addField("Inhabitants", "2.763.804");
            $card1->AddField("Zip", "001XX");
            $card1->setButton("More info", "https://en.wikipedia.org/wiki/Rome");
            $card1->addLink("Town", "https://www.comune.roma.it/web/it/welcome.page");
            $card1->addLink("ATAC", "https://www.atac.roma.it/");
            $card1->draw();


            // Paris

            class City{
                public $Mayor;
                public $Inhabitants;
                public  $Zip;
            }

            $paris = new City;
            $paris->Mayor = "Anne Hidalgo";
            $paris->Inhabitants = "2.229.095";
            $paris->Zip = "750XX";

            $card2 = new Card;
            $card2->setImageSource("./images/paris.jpg");
            $card2->setTitle("Paris");
            $card2->setSubTitle("Capital of France");
            $card2->setInnerText("The following fields' name & data will be acquired by the datasource.");
            $card2->setDataSource($paris);
            $card2->setButton("More info", "https://en.wikipedia.org/wiki/Paris");
            $card2->addArrayToList(array("this is", "just a list"));
            $card2->addElementToList("of various sentences");
            $card2->addLink("Link1", "#");
            $card2->addLink("Link2", "#");

            $card2->onFieldDisplaying("onFieldDisplaying");

            $card2->draw();

            Card::endCardGroupLayout();

            function onFieldDisplaying(&$field , &$value){
                if($field == "Inhabitants"){
                    $value .= " (census 2019)";
                }
            }
        ?>
    </body>
</html>