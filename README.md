### Configuration & requirements
- Create PostgreSQL DB
- Run `composer install`
- Run `composer run-script post-create-project-cmd` (set permissions, copy `.env.dist` to `.env` etc.)
- Change application settings in your `.env` file
- Run `./yii migrate` (migrations)
- Optional:
  - Run `./bin/yii serve` to serve application using PHP built-in web server
  - Open `http://localhost:8080/doc` for documentation

  ## Testing
- Set `DB_DSN_TEST`, `DB_USERNAME_TEST`, `DB_PASSWORD_TEST` variables in your `.env` file
- Run `php tests/bin/yii migrate` (migrations)
- Run `composer test-api` to execute API tests
