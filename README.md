# Task Manager – Dockerized Application

A task management web application built with **Laravel** and a **Go REST API**, containerized using **Docker** and orchestrated with **Docker Compose**.

## Project Overview

Task Manager allows users to manage their tasks through a web interface. The Laravel application communicates with a separate Go backend service to perform task operations.

### Main Features

- View all tasks.
- Add new tasks.
- Edit existing tasks.
- Delete tasks.
- REST API communication between Laravel and Go.
- Containerized deployment using Docker.
- Automated CI checks using GitHub Actions.

## Technology Stack

| Technology | Purpose |
|---|---|
| Laravel | Web application |
| PHP 8.4 | Application runtime |
| Go | REST API backend |
| SQLite | Laravel database |
| Nginx | Web server |
| Docker | Containerization |
| Docker Compose | Service orchestration |
| GitHub Actions | Continuous Integration |

## Architecture

The application consists of three main services:

1. **Laravel App:** Handles the web application and task management interface.
2. **Go Backend:** Provides REST API endpoints for task operations.
3. **Nginx:** Serves the Laravel application through HTTP.

Docker Compose manages communication between the services.

## Project Structure

```text
TaskManager/
│
├── GoBackend/
│   └── Dockerfile
│
├── docker/
│   └── nginx/
│       └── default.conf
│
├── docs/
│   └── notes.md
│
├── .github/
│   └── workflows/
│       └── ci.yml
│
├── Dockerfile
├── docker-compose.yml
├── Makefile
├── .dockerignore
├── .gitignore
└── README.md
```

## Getting Started

### Prerequisites

Make sure the following tools are installed:

- Docker Desktop
- Git
- GNU Make (optional, for Makefile commands)

### 1. Clone the Repository

```bash
git clone https://github.com/doaaoukal/TaskManager.git
cd TaskManager
```

### 2. Configure Environment

Create your environment file:

```bash
cp .env.example .env
```

Make sure the environment configuration is suitable for Docker Compose.

### 3. Start the Application

```bash
docker compose up -d --build
```

### 4. Access the Application

Open your browser:

```text
http://localhost:8000
```

The Go API is available at:

```text
http://localhost:8081
```

Health check endpoint:

```text
http://localhost:8081/health
```

## Makefile Commands

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

**Note:** `make clean` removes Docker volumes and persistent application data.

## Docker Features

This project implements the following Docker features:

- Multi-stage Docker builds for Laravel and Go.
- Docker Compose for multi-container orchestration.
- Health checks for the Go backend.
- Persistent volumes for SQLite and public assets.
- Separate containers for application, web server, and API.
- `.dockerignore` to optimize the build context.

## Continuous Integration

GitHub Actions is configured to run automated checks.

The CI workflow includes:

- Laravel dependency installation.
- Frontend asset compilation.
- Go backend test execution.

## API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/tasks` | Retrieve all tasks |
| POST | `/tasks` | Create a task |
| PUT | `/tasks/{id}` | Update a task |
| DELETE | `/tasks/{id}` | Delete a task |
| GET | `/health` | Check API health |

## Testing

The application was tested by:

- Building Docker images.
- Running all services using Docker Compose.
- Verifying application accessibility.
- Testing task creation, editing, and deletion.
- Checking Go API health.
- Running the Go test command.
- Verifying GitHub Actions execution.

**Note:** The Go backend currently stores tasks in memory, so task data is reset when the Go container restarts. The Go test command currently completes successfully, although no Go test files have been added yet.

## Documentation

For additional implementation details and development decisions, see:

[`docs/notes.md`](docs/notes.md)

## GitHub Repository

[Task Manager – GitHub Repository](https://github.com/doaaoukal/TaskManager)

---

**Developed as part of a university assignment on Git, GitHub, Docker, and CI/CD.**