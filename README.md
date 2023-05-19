

### Install with Docker

Start the container

    docker-compose up -d

Run the installation triggers (creating cookie validation code)

    docker-compose run --rm web composer install

Update your vendor packages

    docker-compose run --rm web composer update --prefer-dist


Migration

    docker-compose run web ./yii migrate
    
You can then access the application through the following URL:

    http://127.0.0.1:8808

Commands
-------------

    For fill and view information NGINX access log

    - nginx/get-count            Displays the number of records within a time interval.
        ./yii nginx/get-count "2023-05-10 12:23:181" "2023-05-19 12:23:18"

    - nginx/get-data             Displays information within a time interval.
        ./yii nginx/get-data "2023-05-10 12:23:181" "2023-05-19 12:23:18"

    - nginx/stuck-data           Watches the file and constantly updates the information.
        ./yii nginx/stuck-data

    - nginx/watch-stuck-data     Watches the file in while and constantly updates the information.
        ./yii nginx/watch-stuck-data
