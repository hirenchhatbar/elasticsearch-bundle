# PhoenixEasyElasticsearchBundle

## Core library

- https://packagist.org/packages/elasticsearch/elasticsearch
- https://packagist.org/packages/ongr/elasticsearch-dsl

## ToDo

- Sync location when add, edit, delete action is performed
- Listing
- Search
- Sort
- Pagination

## Roadmap

- Index deletion - ask confirmation
- Pretty array with settings and mappings display on console

## Brainstroming

## Commands

### Index related commands

```php
// Creates index for location
php bin/console phoenix:elasticsearch:index --name=location create
```

```php
// Deletes index of location
php bin/console phoenix:elasticsearch:index --name=location delete
```

```php
// Checks whether index for location exists or not
php bin/console phoenix:elasticsearch:index --name=location exists
```

```php
// Displays settings of index for location
php bin/console phoenix:elasticsearch:index --name=location settings
```

```php
// Displays mappings of index for location
php bin/console phoenix:elasticsearch:index --name=location mappings
```

```php
// Updates settings in index for location
php bin/console phoenix:elasticsearch:index --name=location update-settings
```

```php
// Updates settings in index for location
php bin/console phoenix:elasticsearch:index --name=location update-mappings
```

### Document related commands

```php
// Index single document of location of ID given
php bin/console phoenix:elasticsearch:document --index=location --id=10 sync-by-id
```

```php
// Index all documents of location
php bin/console phoenix:elasticsearch:document --index=location sync
```

```php
// Delete all documents of location
php bin/console phoenix:elasticsearch:document --index=location delete-all
```

```php
// Delete single document of given ID of location
php bin/console phoenix:elasticsearch:document --index=location --id=10 delete-by-id
```

```php
// Displays document of given ID of location
php bin/console phoenix:elasticsearch:document --index=location --id=10 get
```