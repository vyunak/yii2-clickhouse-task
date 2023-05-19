Консольні команди

1. Моніторинг та збереження логів
   Консольна команда моніторить файл access.log сервера Nginx та зберігає нові дані в базі даних Clickhouse. Ця команда автоматично виконується для отримання нових записів з логів та збереження їх у базі даних.

2. Вивід записів за часовим проміжком
   Консольна команда приймає обов'язкові параметри startDate та finishDate та виводить всі збережені записи з бази даних Clickhouse за заданий часовий проміжок.

3. Вивід кількості записів за часовим проміжком
   Консольна команда приймає обов'язкові параметри startDate та finishDate та виводить кількість збережених записів в базі даних Clickhouse за заданий часовий проміжок.

Вимоги

Мова програмування: PHP

Фреймворк: Yii2

Можливе використання додаткових бібліотек

Інфраструктура описана в файлі docker-compose.yml і включає Nginx, Clickhouse, php-fpm та інші необхідні контейнери

Таблиця для збереження логів в базі даних Clickhouse створюється за допомогою міграції. Структура таблиці може бути налаштована відповідно до вимог проекту.

Налаштування додатку здійснюється за допомогою файлу .env

Інструкція зі запуску проекту міститься у файлі Readme.md

При виникненні запитань зазначеній в Readme.md файлі, кандидат повинен надати список запитань, з якими він зіткнувся, а також описати, яким чином він їх вирішив.

Виконання завдання

Форкніть цей репозиторій на свій акаунт на GitHub.

Виконайте завдання, реалізуючи необхідний функціонал та використовуючи Yii2 фреймворк.

Заповніть Readme.md файл з відповідною інформацією про проект.

Час на виконання тестового завдання: 1 тиждень.

### Install with Docker

Start the container

    docker-compose up -d

Run the installation triggers (creating cookie validation code)

    docker-compose run --rm web composer install

Migration

    docker-compose run --rm web ./yii migrate
    
You can then access the application through the following URL:

    http://127.0.0.1:8808

Commands
-------------

    For fill and view information NGINX access log

    - nginx/get-count            Displays the number of records within a time interval.
        ./yii nginx/get-count "2023-05-10 12:23:18" "2023-05-19 12:23:18"

    - nginx/get-data             Displays information within a time interval.
        ./yii nginx/get-data "2023-05-10 12:23:18" "2023-05-19 12:23:18"

    - nginx/stuck-data           Watches the file and constantly updates the information.
        ./yii nginx/stuck-data

    - nginx/watch-stuck-data     Watches the file in while and constantly updates the information.
        ./yii nginx/watch-stuck-data
