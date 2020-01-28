# yii2-tokenlink
Component intergates [trorg/php-tokenlink](https://github.com/trorg/php-tokenlink)


## Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist trorg/yii2-tokenlink:"1.*"
```

or add

```json
"trorg/yii2-tokenlink": "1.*"
```

to the require section of your composer.json.


## Configuration

To use this extension, you have to configure the Connection class in your application configuration:

```php
return [
    //....
    'components' => [
        'tokenlink' => [
            'class' => 'trorg\yii2\tokenlink\TokenLink',
            'secret' => 'my_secret',
            'ttl' => 86400,
            'fields' => ['user_id', 'browser_id', 'timestamp'],
        ],
    ]
];
```

## Usage

```php
<?php
// SiteController.php
public function actionMySecret()
{
    $request = \Yii::$app->getRequest();
    $rawToken = $request->get('token');
    if (\Yii::$app->tokenlink->isValid($rawToken)) {
        // gran access
        $token = \Yii::$app->tokenlink->load($rawToken);
        $tokenId = $token->getIdentificator();
        echo $token->user_id;
        print_r($token->getAttributes());
    }

    // restrict access
}
```

## API

- [tokenlink](#tokenlink)
    - [`load(string $token): Token`](#load)
    - [`generate(array $fields): Token`](#generate)
    - [`isValid: bool`](#isvalid)

### `load(string $token): Token`

Load and reassembly token from string $token

### `generate(array $fields): Token`

Generate new token for $fields. For example
```php
$fields = [
    'user_id' => 1,
    'timestamp' => time()
];
$token = \Yii::$app->tokenlink->generate($fields);
```

### `isValid: bool`

Test if token is valid.
