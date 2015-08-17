# Freguesias

Postal-PT is a Laravel 5 package that provides all post codes in Portugal.

## Instalation

Add `luismarcelino/postal-pt` to `composer.json`.

    "luismarcelino/postal-pt": "dev-master"

Run `composer update` to pull down the latest version of Postal Codes List.

Edit `config/app.php` and add the `provider` and `filter`

    'providers' => [
        Luismarcelino\PostalPt\FreguesiasServiceProvider::class,,
    ]

Now add the alias.

    'aliases' => [
        'PostalPt' => Luismarcelino\PostalPt\CodigosPostaisFacade::class,
    ]

## Publishing

Optionaly you can publishing the configuration if you want to change the default table name `post_codes_pt`:

    $ php artisan vendor:publish

To generate the migration file use:

    $ php artisan postalpt:migration

This will generate the `<timestamp>_setup_post_codes_pt_table.php` migration and the `PostalPtSeeder.php` seeder. To run the migration, run as usual:

    php artisan migrate:refresh

To run just this seeder user the artisan command:

    php artisan db:seed --class=PostalPtSeeder
