# .env


#### .env
```text
###> doctrine/doctrine-bundle ###
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
#
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
# DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=10.5.8-MariaDB"
# DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
DATABASE_NAME=kw-asphalt
DATABASE_HOST=localhost
DATABASE_PORT=3306
DATABASE_USER=sym_asphalt_user
DATABASE_PASS=zssuW7DpT7D5T{44)D}/x~h{xW{|92Q9
DATABASE_SERVER_VERSION=10.11.5-MariaDB
###< doctrine/doctrine-bundle ###
```

###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=ff93dfdb487e2d442c29b87404818f65
###< symfony/framework-bundle ###

###> symfony/mailer ###
# MAILER_DSN=null://null
# Looking to send emails in production? Check out our Email API/SMTP product!
MAILER_DSN="smtp://36d2321826f5e4:6e0e9c0438b106@sandbox.smtp.mailtrap.io:2525"
###< symfony/mailer ###
