# Laravel VIN decoder

## What is VIN?
A vehicle identification number (VIN) is a unique code, including a serial number, used by the automotive industry to identify individual motor vehicles, towed vehicles, motorcycles, scooters and mopeds, as defined in ISO 3779 (content and structure) and ISO 4030 (location and attachment).

- What is VDS?
    - VDS is a Vehicle Descriptor Section. VDS is used to specify a type of vehicle and may include information about the model, platform, engine and transmission.
- What is VIN?
    - VIN is a Vehicle Identification Number
- What is VIS?
    - VIS is a Vehicle Identifier Section
- What is WMI?
    - WMI is a World Manufacturer Identifier. The first three symbols identify the manufacturer of the car.

## Installation
```bash
composer require composite/laravel-vin
```

In Laravel 5.5 or above the service provider will automatically get registered. In older versions of the framework just add the service provider in `config/app.php` file:
```php
'providers' => [
    ...
    /*
     * Package Service Providers...
     */
    Composite\LaravelVin\VinServiceProvider::class,
    ...
],

'aliases' => [
    ...
    'Vin' => Composite\LaravelVin\Facades\Vin::class,
    ...
],
```

## Usage
```php
use Composite\LaravelVin\Facades\Vin;

// validate
Vin::validate('WBA3A5C51CF256987'); // true

// parse
Vin::parse('WBA3A5C51CF256987'); // Vin object

// get information
Vin::parse('WBA3A5C51CF256987')->getWmi(); // WBA
Vin::parse('WBA3A5C51CF256987')->getVds(); // 3A5C51
Vin::parse('WBA3A5C51CF256987')->getVis(); // CF256987
Vin::parse('WBA3A5C51CF256987')->getManufacturer(); // BMW
Vin::parse('WBA3A5C51CF256987')->getRegion(); // Europe
Vin::parse('WBA3A5C51CF256987')->getCountry(); // Germany
Vin::parse('WBA3A5C51CF256987')->getModelYear(); // [2012]

// get information directly from vin
Vin::getWmi('WBA3A5C51CF256987'); // WBA
Vin::getVds('WBA3A5C51CF256987'); // 3A5C51
Vin::getVis('WBA3A5C51CF256987'); // CF256987
Vin::getManufacturer('WBA3A5C51CF256987'); // BMW
Vin::getRegion('WBA3A5C51CF256987'); // Europe
Vin::getCountry('WBA3A5C51CF256987'); // Germany
Vin::getModelYear('WBA3A5C51CF256987'); // [2012]

// to get info in an array you can call toArray() method
// or just return the object to get in json format
// or give vin number directly to toArray() method
Vin::parse('WBA3A5C51CF256987')->toArray(); // ['wmi' => 'WBA', 'vds' => '3A5C51', 'vis' => 'CF256987', 'manufacturer' => 'BMW', 'region' => 'Europe', 'country' => 'Germany', 'model_year' => [2012]]
Vin::parse('WBA3A5C51CF256987'); // {"wmi":"WBA","vds":"3A5C51","vis":"CF256987","manufacturer":"BMW","region":"Europe","country":"Germany","model_year":[2012]}
Vin::toArray('WBA3A5C51CF256987'); // ['wmi' => 'WBA', 'vds' => '3A5C51', 'vis' => 'CF256987', 'manufacturer' => 'BMW', 'region' => 'Europe', 'country' => 'Germany', 'model_year' => [2012]]
```

### Return object structure
```json
{
    "vin": "WBA3A5C51CF256987",
    "wmi": "WBA",
    "vds": "3A5C51",
    "vis": "CF256987",
    "manufacturer": "BMW",
    "region": "Europe",
    "country": "Germany",
    "model_year": [
        1982,
        2012
    ]
}
```
## TODO
- [ ] Add model query support

## Credits
- [Composite Solutions Hungary Kft.](https://composite-solutions.eu)

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
