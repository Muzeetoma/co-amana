echo "Stopping and removing Docker containers..."
docker-compose down -v

echo "Starting Docker containers..."
docker system prune -a -f
docker-compose build
echo "Setup executed successfully!"
