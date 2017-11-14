# Install with Composer

```bash
cd /var/www/html/

curl -O https://raw.githubusercontent.com/gpjp-hades/Backend/master/packages.json

composer create-project --repository packages.json gpjp-hades/backend hades
```

## Requirements

**PHP** 7.1+

**php_sqlite3**

**Composer** 1.5.0+

### Change default path
If you want to move Hades from ```/hades``` to somewhere else (let's say ```/foo```) run this

```bash
cd /var/www/html/
mv hades foo

vi foo/bar/bootstrap/app.php

# find $config['path'] = "/hades";
# change it to $config['path'] = "/foo";
```
