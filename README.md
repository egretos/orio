# Orio

Orio is a good [OrientDB](https://orientdb.com/) query builder based on the PHPOrient.

Tested on Orientdb version 2.1.3

#### Requires
- PHP Version >= 5.4 ( Socket extension enabled )
- [phporient by ostico](https://github.com/Ostico/PhpOrient)

## Installation

### Using git:
    
    git clone https://github.com/egretos/orio.git

### Using composer

Install composer
```bash
php -r "readfile('https://getcomposer.org/installer');" | php
php composer.phar --no-dev install
```

Install Orio
```bash    
php composer.phar require "egretos/orio:dev-master" --update-no-dev
```

## Usage

```php
require "vendor/autoload.php";
use Orio\DB;
```

#### Connecting to server
```php
$DBconfig = [
    'hostname' => '127.0.0.1',
    'port' => 2424,
    'username' => 'username',
    'password' => 'password',
    'name' => 'shema name',
];
DB::init($DBConfig);
```

#### Simple query
return array of [phporient](https://github.com/Ostico/PhpOrient) Records
```php
$result = DB::command("select from #12:0");
```

#### Select by class
return array of Orio Model 
```php
$result = DB::select('User')->get();
```

#### Getting with custom fields 
```php
$result = DB::select('User')
    ->get('name'); //one field
$result = DB::select('User')
    ->get(['name', 'email']); //many fields
```
#### Getting by condition 
```php
$result = DB::select('User')
    ->where('name', 'Joe')
    ->get();
    
$result = DB::select('User')
    ->where('age', '>', '18')
    ->get();    
```

return of Orio Model
#### Getting one record by rid 
```php
use PhpOrient\Protocols\Binary\Data\ID

// 3 variants of definition
$rid = new ID( '#12:0' );
$rid = new ID( 12, 0 );
$rid = new ID( [ 'cluster' => 12, 'position' => 0 ] );

// getting model
$result = DB::byRid($rid);
```
or
```php
$result = DB::byRid('#12:0');   
```

# License

MIT

