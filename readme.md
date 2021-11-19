# Nova CSV Export

This package allows you to export resources as a csv file.

## Prerequisites

* php >= 7.3
* Laravel >= 6.0
* Laravel Nova ~3.0

## Installation

```bash
composer require gevorgmelkumyan/nova-csv-export
```

## Usage
* Make the model of the resource you desire to export to use `Exportable` trait:

```php
namespace App\Models;
use GevorgMelkumyan\Models\Exportable;

class User extends Authenticable {
    use Exportable;
}
```

* Inside the model override `mapping` array fetched from `Exportable` by specifying model's attributes as keys and their labels as the values:
```php
...
protected $mapping = [
    'id' => 'ID',
    'first_name' => 'First Name',
    'dob' => 'Date Of Birth',
];
...
```

* Inside the resource related to the model add `ExportCsv` to `Actions` specifying the directory where the csv files will be stored:
```php
use GevorgMelkumyan\Actions\ExportCsv;
...
public function actions() {
    return [
        new ExportCsv('csv'),
    ];
}
```