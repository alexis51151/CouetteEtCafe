# Couette & Café 

Couette & Café is a Airbnb-like web app for customers to find accommodation worldwide.


## Prerequisites

Before you begin, ensure you have met the following requirements:
<!--- These are just example requirements. Add, duplicate or remove as required --->
* You have installed the latest version of PHP (< 7.2.9) and Composer.

## Installing 

To install Couette & Café, follow these steps:
```bash
# Loading all libraries used
composer install

# Database file creation
bin/console doctrine:database:create

# Creating database schema
bin/console doctrine:schema:create

# Populating the database with fixture data
bin/console doctrine:fixtures:load -n
```

## How to use 

To start the server :  

```
bin/console server:run
```

To access the web app : 

```
localhost:8080
```


