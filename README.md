# route-log-analyzer
A laravel package for analysing route usage and log files.

# Installation
Begin by pulling in the package through Composer.

```
composer require ahilmurugesan/routeloganalyzer
```
# Configuration
If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```
\Ahilan\LogViewer\LogViewerServiceProvider::class,
```
Finally, to view the logs just access ```/logviewer``` route.

# Route Usage Module Configuration
To access route usage module run the migration command
```
php artisan migrate
```

Then run the preset command for the route usage module
```
php artisan preset routeseed
```

Finally, to view the route usage module just access ```/routeusage``` route.
