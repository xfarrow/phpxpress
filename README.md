# phpxpress

PhpXpress' goal is to create a simple way to programmatically manage Bootstrap elements. 
It's similar to Microsoft's WebForms with a great layout by default (like DevExpress).

## Available components
* Table
* Card

## Example

### Table

The following code
```
$employees = array($employee1, $employee2, $employee3);

$table = new Table;
$table->setDataSource($employees);

$table->setCustomCaptions(array("Name", "Surname", "Date of Birth", "Social Security Number")); //not required. If not specified it'll use objects' property names

$table->setStripedRows(true);
$table->setBordered(true);
$table->setHoverAnimation(true);

$table->draw();
```

produces the following output
<img src="/phpxpress/examples/demoTable.jpg" alt="Demo">


### Card

The follwing code
```
Card::beginCardGroupLayout(36);

$card1 = new Card;

$card1->setImageSource("colosseum.jpg");

$card1->setTitle("Rome");
$card1->setSubTitle("Capital of Italy");

$card1->setInnerText("After the foundation by Romulus according to a legend, Rome was ruled for a period of 244 years by a monarchical system, initially with sovereigns of Latin and Sabine origin, later by Etruscan kings.");

$card1->setFooterText("Image By John");

$card1->addField("Mayor", "Roberto Gualtieri");
$card1->addField("Inhabitants", "2.763.804");
$card1->AddField("Zip", "001XX");

$card1->setButton("More info", "https://en.wikipedia.org/wiki/Rome");

$card1->draw();

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
$card2->setImageSource("paris.jpg");
$card2->setTitle("Paris");
$card2->setSubTitle("Capital of France");
$card2->setInnerText("The following fields' name & data will be acquired by the datasource.");
$card2->setDataSource($paris);
$card2->setButton("More info", "https://en.wikipedia.org/wiki/Paris");
$card2->draw();

Card::endCardGroupLayout();
```

produces the following output
<img src="/phpxpress/examples/card.jpg" alt="Demo">

$card2 receives a DataSource whereas $card1 does not.
