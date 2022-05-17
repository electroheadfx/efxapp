# Setup DB and Create admin :

```bash
# Fill Database config in app/config/production/db.php :
# Create MySQL Database : user_db
mysql -u user -password=userpassword
# dump
mysqldump -u user -p user_db | gzip > user_db.sql.gz

# init app setup

# migrate db schema
env FUEL_ENV=production php oil refine migrate --packages=auth
env FUEL_ENV=production php oil r migrate --all

# create users in db
env FUEL_ENV=production php oil console
    Auth::create_user('your name', 'pass', 'youremail@mail.com', 6, array('fullname'=>'Laurent Marques'));
    Auth::delete_user('guest');
    Auth::delete_user('admin');
    // change user password :
    Auth::change_password('newpass','oldpass','user');
```

# Setup App Cache & authorizations

```bash
chmod 775 app/config && chmod 777 app/tmp && chmod 777 app/cache && chmod 777 app/logs && chmod -R 775 media uploads

# Could have a issue on production/app-setup.php :
chmod 666 app/config/production/app-setup.php
```

# Snippets :

## FUEL

- oil migrations :

```bash
php oil refine migrate --packages=auth
php oil r migrate --all
```

- Files sync to PROD + SVN (see efx scripts in local) :
  
  + config modules folder
  + app config files
  + public assets’ theme


