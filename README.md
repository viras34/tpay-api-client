
Installation
------------

Via [composer](https://getcomposer.org)

```bash
composer require viras34/tpay-api-client
```

Create new tPay transaction
-----------------

```php
use \Viras\Tpay\Client;

$client = new Client([
    'apiKey'=>'75f86137a6635df826e3efe2e66f7c9a946fdde1', 
    'apiPass'=>'p@$$w0rd#@!'
]);

$transaction = $client->transaction->create([
    'merchantId'=>'1010',
    'merchantSecret'=>'demo',
    'amount' => 999.99,
    'description' => 'Transaction description',
    'crc' => '3214',
    'result_url' => 'http://example.pl/transaction_confirmation',
    'result_email' => 'shop@example.com',
    'return_url' => 'http://example.pl/',
    'email' => 'customer@example.com',
    'name' => 'John Doe',
    'language' => 'en',
    'group' => 150,
    'accept_tos' => 1,
]);

print_r($transaction);

/*
stdClass Object
(
[result] => 1
[title] => TR-BRA-1D7Z9TX
[amount] => 999.99
[online] => 1
[url] => https://secure.tpay.com/?gtitle=TR-BRA-1D7Z9TX
)
*/

```

Method returns transaction title required for other API methods and redirection link for a customer.

Send Blik code
------------------

```php
$result = $client->transaction->blik([
    'title'=>$response->title,
    'code'=>'123456',
    'amount' => 999.99,
]);

print_r($result);

/*
stdClass Object
(
    [result] => 1
)
*/

```

Method returns parameter ‘result’ equal to 1 which means that payment popup has been successfully displayed at customer mobile application.


