# Booking

Simple Symfony application for booking desks in a coworking space. It runs in Docker and uses MySQL for storage.

## Requirements

- **PHP** 8 or newer
- **MySQL** database
- **Docker** and **Docker Compose** installed on your machine

## Setup

1. Clone this repository
2. Build the Docker image
3. Start the containers using Docker Compose
4. Run database migrations
5. Open the site in your browser

### Build the Docker image

```bash
docker build -t booking-app .
```

### Start the containers

```bash
docker-compose up -d
```

Set database credentials in a `.env.local` file or export variables `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` before running the containers.

### Run migrations

```
docker-compose exec app php bin/console doctrine:migrations:migrate
```

### Access the site

Visit [http://localhost:8000](http://localhost:8000) after the containers are running.

