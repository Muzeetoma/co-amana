echo "Stopping and removing Docker containers..."
docker-compose down -v

echo "Starting Docker containers..."
docker-compose up -d

echo "Waiting for the coamana-app container to be ready..."
sleep 15

echo "Entering the coamana-app container and running artisan commands..."
docker exec -it -u root coamana-app bash -c "
    php artisan ziggy:generate &&
    php artisan migrate &&
    php artisan config:cache &&
    php artisan cache:clear &&
    php artisan db:seed  &&
    ./vendor/bin/phpunit &&
    php artisan test --filter=OrderControllerTest &&
    php artisan queue:work
"

echo "All commands executed successfully!"
