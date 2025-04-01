### Развертывание проекта
1. Клонировать репозиторий (перед эти проверить, что установлен ключ ssh на gitlab.com)
```bash
git clone git@gitlab.com:andrey_schedrin/carsharing.git
```
2. Установить утилиту sail для работы с docker-compose - https://laravel.com/docs/11.x#docker-installation-using-sail
3. Запустить контейнеры (нужен установленный docker и docker-compose)
```bash
sail up -d
```

### Codestyle 
Перед пушем в репозиторий, необходимо убедиться, что код стайл соответствует стандарту. Для этого запустить - 
```bash
composer fix-codestyle
```
Проверить корректность стиля кода (предыдущая команда корректирует не все погрешности кода) можно с помощью команды - 
```bash
composer codestyle
```

### Тестирование
Запуск автотестов локально
```bash
composer test
```

### Api docs
- Документация по api доступна по адресу - `/api/docs`
- Openapi файл в корне приложения - `openapi.yaml`
