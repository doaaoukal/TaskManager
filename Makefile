
.PHONY: up down restart build logs ps clean test

# Start all services
up:
	docker compose up -d

# Stop all services
down:
	docker compose down

# Restart all services
restart:
	docker compose restart

# Build Docker images
build:
	docker compose build

# Show container logs
logs:
	docker compose logs -f

# Show running containers
ps:
	docker compose ps

# Remove containers and volumes
clean:
	docker compose down -v

# Run Go backend tests
# Run Go backend tests
test:
	docker compose run --rm go-test