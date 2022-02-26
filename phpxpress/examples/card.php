<html>
    <head>
        <title>Table example</title>
    </head>
    <body>
        <?php
            include "../phpxpress/card.php";

            $card1 = new Card;
            $card1->setImageSource("colosseum.jpg");
            $card1->setTitle("Rome");
            $card1->setSubTitle("Capital of Italy");
            $card1->setInnerText("After the foundation by Romulus according to a legend, Rome was ruled for a period of 244 years by a monarchical system, initially with sovereigns of Latin and Sabine origin, later by Etruscan kings.");
            $card1->draw();

            $card2 = new Card;
            $card2->setImageSource("paris.jpg");
            $card2->setTitle("Paris");
            $card2->setSubTitle("Capital of France");
            $card2->setInnerText("The Parisii, a sub-tribe of the Celtic Senones, inhabited the Paris area from around the middle of the 3rd century BC.");
            $card2->draw();
        ?>
    </body>
</html>