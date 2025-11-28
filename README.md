# support-ticket-app
This my submission for an assessment task. The goal is to create a support ticket application.

## Running the migration
This will create multiple databases on your MySQL env configuration.
```
php artisan migrate:all
```

## Make attachments work
You will need to symlink the public path to your storage for file attachments to work.
```
php artisan storage:link
```

## Run the Ticket Test
```
php artisan test --filter TicketTest
```

##
**You can access the ticketing system by accessing /ticketing**
##

**NOTE:** this is not made to run on production servers running on LAMP stacks. The views are intentionally left to use Vite.


