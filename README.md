## Installation

This package can be installed via Composer:

```bash
composer require sohagsrz/instagram-media-downloader
```

## Media download example

```php

require_once 'vendor/autoload.php';
use InstagramMediaDownloader\Downloader;
$downloader = new Downloader();

$result = $downloader->get_by_shortcode('C16ErQiLCJm');

var_dump($result);
```

## To get profile data

```php

require_once 'vendor/autoload.php';
use InstagramMediaDownloader\ProfileDownloader;
$profile = new ProfileDownloader();
$result = $profile->getProfile('sohagsrz');
var_dump($result);
```

## Contribution

If you find any issues or have suggestions for improvement, feel free to contribute to this project. You can fork the repository, make your changes, and submit a pull request.
