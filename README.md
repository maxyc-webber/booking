# Booking

A simple PHP application demonstrating a containerized environment using PHP 8 and MySQL. The project uses Docker to make setup and deployment easy.

## Requirements

- **PHP** 8 or newer
- **MySQL** database
- **Docker** and **Docker Compose** installed on your machine

## Setup

1. Clone this repository
2. Build the Docker image
3. Start the containers using Docker Compose
4. Open the site in your browser

### Build the Docker image

```bash
docker build -t booking-app .
```

### Start the containers

```bash
docker-compose up -d
```

### Access the site

Visit [http://localhost:8000](http://localhost:8000) after the containers are running.

