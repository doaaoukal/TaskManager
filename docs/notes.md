# Development Notes

## 1. Project Overview

Task Manager is a web-based task management application built using Laravel and a Go REST API.

The Laravel application provides the user interface and communicates with the Go backend to perform task management operations.

## 2. Technology Stack

- **Laravel:** Web application and user interface.
- **PHP:** Backend application logic.
- **Go:** REST API service.
- **SQLite:** Database for Laravel.
- **Docker:** Containerization and deployment.
- **Docker Compose:** Multi-container orchestration.
- **Nginx:** Web server and reverse proxy.
- **Git and GitHub:** Version control and collaboration.
- **GitHub Actions:** Continuous Integration (CI).

## 3. Docker Implementation

The project uses separate Docker containers for:

- Laravel application running with PHP-FPM.
- Nginx web server.
- Go REST API backend.

Docker Compose manages the services, networking, dependencies, and persistent volumes.

The Go backend includes a health check endpoint at `/health`.

## 4. Multi-Stage Docker Build

The Laravel Dockerfile uses multiple stages:

1. **Frontend Stage:** Installs Node.js dependencies and builds frontend assets.
2. **Vendor Stage:** Installs PHP dependencies using Composer.
3. **Application Stage:** Builds the final PHP-FPM application image.

The Go backend Dockerfile also uses a multi-stage build to produce a lightweight runtime image.

## 5. Additional Docker Features

The following features were implemented:

- Docker Compose for managing multiple services.
- Multi-stage Docker builds.
- Health checks for the Go API.
- Persistent Docker volumes for SQLite data and public assets.
- `.dockerignore` to reduce the Docker build context.
- Environment variables for service configuration.

## 6. Makefile Commands

The project includes a Makefile to simplify common development tasks.

| Command | Description |
|---|---|
| `make up` | Start all services |
| `make down` | Stop all services |
| `make restart` | Restart services |
| `make build` | Build Docker images |
| `make logs` | Display service logs |
| `make ps` | Show running containers |
| `make test` | Run Go backend tests |
| `make clean` | Remove containers and volumes |

**Note:** `make clean` removes Docker volumes, including persistent application data.

## 7. GitHub Actions CI

A GitHub Actions workflow was configured to automate project checks.

The workflow includes:

- Laravel dependency installation and frontend asset build.
- Go backend test execution.

Both CI jobs completed successfully.

## 8. Git Workflow

The project follows a feature-branch workflow.

- `master`: Main branch.
- `feature/docker`: Docker implementation branch.

Changes are committed with descriptive commit messages and pushed to GitHub through the feature branch.

A Pull Request was created to propose merging the Docker implementation into the main branch.

## 9. Testing and Verification

The following checks were performed:

- Successfully built Docker images.
- Started the application using Docker Compose.
- Verified that the Laravel application was accessible through the browser.
- Verified communication between Laravel and the Go API.
- Tested adding, editing, and deleting tasks.
- Verified the Go API health check.
- Executed the Go test command successfully.
- Verified successful GitHub Actions workflow execution.

**Note:** The Go test command completed successfully, but no Go test files were present at the time of verification.

## 10. Important Notes

- The Go backend currently stores tasks in memory. Its task data is reset when the backend container restarts.
- Laravel uses SQLite with a persistent Docker volume.
- The application uses environment variables to configure service connections.
