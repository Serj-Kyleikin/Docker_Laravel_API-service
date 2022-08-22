 #!/bin/bash

cd laravel
docker exec -it app php artisan migrate --seed
