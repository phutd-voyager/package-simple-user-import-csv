# Simple Upload File

[`PHP v8.2`](https://php.net)

[`Laravel v11.x`](https://github.com/laravel/laravel)

## Installation

```bash
composer require voyager-inc/simple-user-import-csv
```

- Publish provider
```bash
php artisan vendor:publish --provider="VoyagerInc\SimpleUserImportCsv\SimpleUserImportCsvServiceProvider"
```

## Usage

- Run command to copy file from stubs folder

```bash
php artisan simple-user-import-csv:install
```

- Add more this line to `web.php` file

```bash
...
require __DIR__ . '/user_import_csv.php';
```