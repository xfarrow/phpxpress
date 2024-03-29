# phpxpress

PhpXpress' goal is to create a simple way to programmatically manage Bootstrap elements.
It's similar to Microsoft's WebForms with a great layout by default (like DevExpress).


<noscript><a href="https://liberapay.com/xfarrow/donate"><img alt="Donate using Liberapay" src="https://liberapay.com/assets/widgets/donate.svg"></a></noscript>

## Available components
* Table
* Card
* Breadcrumb
* Dropdown

## Examples

### Table

The following code

```php
$employees = array($employee1, $employee2, $employee3);

$table = new PhpXpress\Table;
$table->setDataSource($employees);
$table->setCustomCaptions(array("Name", "Surname", "Date of Birth", "Social Security Number")); //not required. If not specified it'll use objects' property names
$table->addColumn("Extra");
$table->onValueDisplaying("onValueDisplaying");
$table->setStripedRows(true);
$table->setBordered(true);
$table->setHoverAnimation(true);
$table->draw();

function onValueDisplaying($caption, &$value, $row){
	if($caption == "ssn"){
		if($row["ssn"] == "12345")
		{
		 	$value = $row["name"] . " " . $row["surname"] . " agreed to share their ssn (12345)" ;
        	}
        	else
		{
			$value = "SSN not shown for privacy reasons";
        	}
    	}
    	else if($caption == "Extra")
	{
		$value = "This column did not exist in the datasource";
    	}
}
```

produces the following output

<img src="/examples/images/demoTable.jpg" alt="Demo">


### Card

The follwing code

```php
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

<img src="/examples/images/card.jpg" alt="Demo">

$card2 receives a DataSource whereas $card1 does not.

### Breadcrumb

The follwing code

```php
            $links["Github"] = "https://www.github.com";
            $links["xfarrow"] = "https://www.github.com/xfarrow";
            $links["PhpXpress"] = "https://www.github.com/xfarrow/phoxpress";

            $breadcrumb = new BreadCrumb;

            $breadcrumb->setDataSource($links);
            $breadcrumb->draw();
```

Produces the following output:

<img src="/examples/images/breadcrumb.jpg" alt="Demo">
