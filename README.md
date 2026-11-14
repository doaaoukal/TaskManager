# 🚀 Task Manager – Dockerized Application

<p align="center">
  <strong>A Task Management Web Application built with Laravel, Go, and Docker.</strong>
  <br>
  A containerized application demonstrating REST API integration, multi-container orchestration, and CI/CD automation.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-Framework-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/Go-Backend-00ADD8?style=for-the-badge&logo=go&logoColor=white" />
  <img src="https://img.shields.io/badge/Docker-Containerized-2496ED?style=for-the-badge&logo=docker&logoColor=white" />
  <img src="https://img.shields.io/badge/GitHub_Actions-CI/CD-2088FF?style=for-the-badge&logo=githubactions&logoColor=white" />
</p>

---

## 📌 Table of Contents

- [📖 Project Overview](#-project-overview)
- [✨ Main Features](#-main-features)
- [🛠️ Technology Stack](#️-technology-stack)
- [🏗️ Architecture](#️-architecture)
- [📂 Project Structure](#-project-structure)
- [🚀 Getting Started](#-getting-started)
- [🐳 Docker Features](#-docker-features)
- [⚙️ Makefile Commands](#️-makefile-commands)
- [🔌 API Endpoints](#-api-endpoints)
- [🔄 Continuous Integration](#-continuous-integration)
- [🧪 Testing](#-testing)
- [📚 Documentation](#-documentation)
- [👩‍💻 Author](#-author)

---

## 📖 Project Overview

**Task Manager** is a web-based task management application built using **Laravel** and a separate **Go REST API**.

The application allows users to manage their tasks through a simple web interface while Laravel communicates with the Go backend to perform task operations.

The entire application is containerized using **Docker** and orchestrated with **Docker Compose**, making deployment and development easier and more consistent.

## ✨ Main Features

- 📋 View all tasks.
- ➕ Add new tasks.
- ✏️ Edit existing tasks.
- 🗑️ Delete tasks.
- 🔗 REST API communication between Laravel and Go.
- 🐳 Dockerized application deployment.
- 📦 Multi-container orchestration using Docker Compose.
- ❤️ Health checks for the Go backend.
- ⚙️ Automated CI checks using GitHub Actions.

## 🛠️ Technology Stack

| Technology | Purpose |
|---|---|
| 🖥️ Laravel | Web application |
| 🐘 PHP 8.4 | Application runtime |
| 🐹 Go | REST API backend |
| 🗄️ SQLite | Laravel database |
| 🌐 Nginx | Web server |
| 🐳 Docker | Containerization |
| 📦 Docker Compose | Service orchestration |
| ⚙️ GitHub Actions | Continuous Integration |

## 🏗️ Architecture

The application consists of three main services:

| Service | Responsibility |
|---|---|
| 🖥️ Laravel App | Handles the web application and task management interface |
| 🐹 Go Backend | Provides REST API endpoints for task operations |
| 🌐 Nginx | Serves the Laravel application through HTTP |

### 🔄 Application Workflow

1. The user interacts with the Laravel web interface.
2. Laravel sends HTTP requests to the Go REST API.
3. The Go backend processes the requested task operation.
4. The API returns a response to Laravel.
5. Laravel updates the interface.

Docker Compose manages communication between the application services.

## 📂 Project Structure

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

## 🚀 Getting Started

Follow these steps to run the project locally.

### 📋 Prerequisites

Make sure you have the following tools installed:

- 🐳 Docker Desktop
- 🧰 Git
- 🔧 GNU Make (optional)

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/doaaoukal/TaskManager.git
cd TaskManager
```

### 2️⃣ Configure Environment

Create your environment file:

```bash
cp .env.example .env
```

Make sure the environment configuration is suitable for Docker Compose.

### 3️⃣ Build and Start the Application

```bash
docker compose up -d --build
```

### 4️⃣ Access the Application

Once all containers are running, open your browser:

| Service | URL |
|---|---|
| 🌐 Laravel Application | http://localhost:8000 |
| 🐹 Go REST API | http://localhost:8081 |
| ❤️ API Health Check | http://localhost:8081/health |

## 🐳 Docker Features

This project demonstrates several Docker concepts:

- 🏗️ **Multi-stage Builds:** Separate build stages for Laravel and Go.
- 📦 **Docker Compose:** Multi-container application orchestration.
- ❤️ **Health Checks:** Monitor the Go backend service.
- 💾 **Persistent Volumes:** Store SQLite data and public assets.
- 🔗 **Service Communication:** Separate containers for the application, web server, and API.
- 🚀 **Build Optimization:** Using `.dockerignore` to reduce the Docker build context.

## ⚙️ Makefile Commands

The project includes a Makefile to simplify common Docker operations.

| Command | Description |
|---|---|
| `make up` | ▶️ Start all services |
| `make down` | ⏹️ Stop all services |
| `make restart` | 🔄 Restart services |
| `make build` | 🏗️ Build Docker images |
| `make logs` | 📋 Display service logs |
| `make ps` | 🔍 Show running containers |
| `make test` | 🧪 Run Go backend tests |
| `make clean` | 🧹 Remove containers and volumes |

> ⚠️ **Warning:** `make clean` removes Docker volumes and persistent application data.

## 🔌 API Endpoints

The Go backend provides the following REST API endpoints:

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/tasks` | 📋 Retrieve all tasks |
| `POST` | `/tasks` | ➕ Create a new task |
| `PUT` | `/tasks/{id}` | ✏️ Update an existing task |
| `DELETE` | `/tasks/{id}` | 🗑️ Delete a task |
| `GET` | `/health` | ❤️ Check API health |

## 🔄 Continuous Integration

GitHub Actions is configured to automatically run project checks.

The CI workflow includes:

- 📦 Laravel dependency installation.
- 🎨 Frontend asset compilation.
- 🧪 Go backend test execution.

Workflow configuration:

```text
.github/workflows/ci.yml
```

## 🧪 Testing

The application was tested through the following steps:

- 🏗️ Building Docker images.
- 🐳 Running all services using Docker Compose.
- 🌐 Verifying application accessibility.
- ➕ Testing task creation.
- ✏️ Testing task editing.
- 🗑️ Testing task deletion.
- ❤️ Checking the Go API health endpoint.
- 🧪 Running the Go test command.
- ⚙️ Verifying GitHub Actions execution.

### 📝 Current Implementation Notes

- The Go backend currently stores tasks in memory. Therefore, task data is reset when the Go container restarts.
- The Go test command currently completes successfully, although no Go test files have been added yet.

## 📚 Documentation

For additional implementation details and development decisions, see:

📄 [`docs/notes.md`](docs/notes.md)

---

## 👩‍💻 Author

<p align="center">
  <img src="https://img.shields.io/badge/Developer-Doaa_Oukal-blueviolet?style=for-the-badge&logo=github" />
  <br><br>
  <strong>Doaa Oukal</strong>
  <br>
  💻 Software Development Student
  <br><br>
  <a href="https://github.com/doaaoukal">
    <img src="https://img.shields.io/badge/GitHub-Profile-181717?style=for-the-badge&logo=github&logoColor=white" />
  </a>
  <a href="https://github.com/doaaoukal/TaskManager">
    <img src="https://img.shields.io/badge/Project-Repository-2EA44F?style=for-the-badge&logo=github&logoColor=white" />
  </a>
</p>
ravel, Go, and Docker
</p>
