#!/bin/bash

# Construir la imagen Docker y obtener su ID
IMAGE_ID=$(docker build -q .)

if [ -z "$IMAGE_ID" ]; then
    echo "Error al construir la imagen Docker."
    exit 1
fi

echo "Imagen Docker construida con ID: $IMAGE_ID"

# Crear y ejecutar un contenedor basado en la imagen construida
CONTAINER_ID=$(docker run -p 80:80 --name test -d $IMAGE_ID)

if [ -z "$CONTAINER_ID" ]; then
    echo "Error al ejecutar el contenedor."
    exit 1
fi

echo "Contenedor ejecutado con ID: $CONTAINER_ID"

# Obtener el nombre del contenedor a partir del ID
CONTAINER_NAME=$(docker ps --format "{{.Names}}" -f "id=$CONTAINER_ID")

echo "Nombre del contenedor: $CONTAINER_NAME"

# Mostrar información del contenedor
docker ps -f "id=$CONTAINER_ID"

# Mostrar información de la imagen
docker images $IMAGE_ID
