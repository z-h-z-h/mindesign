[Первая часть тестового задания (написать запросы к MySQL)](https://docs.google.com/document/d/1HYtlC1_aO5Ku4vdcMRBMeCWKkkCE3TYIi7uoeREOOOc/edit?usp=sharing)

# Тестовое задание - Каталог товаров
* Главная страница:
    * Дерево категорий (adjency list)
    * Поиск по названию и описанию
    * Топ 20 самых продаваемых товаров
* Страница категории:
    * Название категории
    * Список продуктов в категории
* Страница продукта:
    * Главные категории продукта
    * Название, картинка, описание, цена
    * Артикулы

# Установка
* git clone https://github.com/z-h-z-h/mindesign.git mindesign
* composer install
* cp .env.example .env
* Настроить .env - URL проекта и MySQL
* php artisan key:generate
* php artisan migrate
* Скачиваем JSON с markethot.ru - php artisan markethot:download
* Импортируем в БД - php artisan markethot:import
* Открываем в браузере
* ??
* Profit!

# Импорт данных
Импорт осуществляются с помощью двух консольных команд - одна скачивает данные, вторая импортирует. При желании их можно запускать по расписанию, например, каждые 10 минут.

## markethot:download
Читает JSON по URL, который задан в конфиге config/markethot.php и сохраняет считанное в markethot.json

## markethot:import
Ищет локальный markethot.json, разбирает и сохраняет в БД
