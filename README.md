### 应用场景
1. 云片短信

### Install

```
composer require sn01615/yunpian
```
### Usage

```php
use Yunpian\Yumpian;

$text = "【某某有限公司】您的验证码是#code#";
$text = str_replace('#code#', $code, $text);

$apikey = $_SERVER['CONFIGYUNPIAN'];

$sender = new Yunpian();
$sender->setApiKey($apikey);
$sender->setCurlOpt(
    [
        CURLOPT_CAINFO => __DIR__ . '/../nlibraries/ca-bundle.crt'
    ]);
$result = $sender->singleSend($mobile, $text);

```
