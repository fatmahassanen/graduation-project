# Coding Standards

* Prefer updating existing code over writing from scratch.
* Keep solutions simple and modular. Break Blade files into reusable components.
* Never duplicate code.
* Write code aware of dev, test, and prod environments.
* Separate business logic into `Services/`, routes into `routes/web.php`, and database logic into Eloquent Models.
* Never write raw SQL; use Eloquent ORM.
* preferably use artisan commands if possible.
