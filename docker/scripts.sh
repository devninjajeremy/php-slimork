#!/bin/bash

function start {
    docker-compose up -d
}

function stop {
    docker-compose down -v
}

function remove_all_containers {
    # Display all container numeric IDs
    containers=$(docker ps -a -q)

    if [ -z "$containers" ]; then
        echo "The containers is not exists"
    else
        echo "Deleting the containers"

        docker rm $containers
    fi
}

function remove_all_images {
    # Only show image numeric IDs
    images=$(docker images -q)

    if [ -z "$images" ]; then
        echo "The images is not exists"
    else
        echo "Deleting the images"

        docker rmi $images
    fi
}

COMMAND=${@:$OPTIND:1}

case $COMMAND in

    start)
        start
    ;;

    stop)
        stop
    ;;

    remove-all-containers)
        remove_all_containers
    ;;

    remove-all-images)
        remove_all_images
    ;;

    *)
        echo "- start"
        echo "- stop"
        echo "- remove-all-containers"
        echo "- remove-all-images"
    ;;

esac
