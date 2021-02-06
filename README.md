# PhoenixEasyElasticsearchBundle

## Core library

- https://packagist.org/packages/elasticsearch/elasticsearch
- https://packagist.org/packages/ongr/elasticsearch-dsl

## Roadmap

- Index deletion - ask confirmation
- Pretty array with settings and mappings display on console

## Brainstroming

## Commands

### Index related commands

```
php bin/console phoenix:elasticsearch:index --name=location create
```

```
php bin/console phoenix:elasticsearch:index --name=location delete
```

```
php bin/console phoenix:elasticsearch:index --name=location exists
```

```
php bin/console phoenix:elasticsearch:index --name=location settings
```

```
php bin/console phoenix:elasticsearch:index --name=location mappings
```

```
php bin/console phoenix:elasticsearch:index --name=location update-settings
```

```
php bin/console phoenix:elasticsearch:index --name=location update-mappings
```

### Document related commands

```
php bin/console phoenix:elasticsearch:document --index=location --id=10 sync-by-id
```

```
php bin/console phoenix:elasticsearch:document --index=location sync
```

```
php bin/console phoenix:elasticsearch:document --index=location delete-all
```

```
php bin/console phoenix:elasticsearch:document --index=location --id=10 delete-by-id
```

```
php bin/console phoenix:elasticsearch:document --index=location --id=10 get
```