# Off-Grid-Docs-OFFICIAL
This will be the repo where anyone in the world can pull a version of the Off-Grid-Docs web app and use it to have all of your favorite documents, videos, text files etc and will work on ANY device using Docker, develop it to their needs. See more in the README file.

# Project Raptor - Off Grid Doc Management (DOCKER VERSION)
<p align="center">
  <img src="https://publichtmlimg.blob.core.windows.net/$web/off-grid-docs.jpg" alt="" width="100%" height="90%">
</p>

## Introduction

This project is an off grid documentation/video/text management app built with HTML, PHP and Docker. It includes categories for different survival topics, file uploads, and dark mode support.

## Prerequisites

- Docker
- Docker Compose

LAMP (Linux) Web Version Info here soon:

=======================================
## Steps to Deploy the Application Using Docker
Ensure Docker and Docker Compose are Installed:
Make sure that Docker and Docker Compose are installed on the user's machine. Users can download and install Docker from Docker's official website.
https://www.docker.com/

Create Necessary Files:
Ensure that the provided Dockerfile and docker-compose.yaml are placed in the root directory of your project.

Run the Docker Compose Command:
Users can deploy the application by navigating to the root directory of your project and running the following command:

`docker-compose up --build`


This command will:

Build the Docker image from the Dockerfile.
Start the Docker container and map port 80 of the container to port 8081 on the host machine.
