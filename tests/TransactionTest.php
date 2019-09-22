<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Viras\Tpay\Email;

final class TransactionTest extends TestCase
{
    public function create(\Viras\Tpay\Client $client): \stdClass
    {
        $client = $this->getClient();
        $body = [
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
        ];

        $response = $client->transaction->create($body);

        $this->assertIsObject($response);

        $this->assertObjectHasAttribute('result', $response);
        $this->assertObjectHasAttribute('amount', $response);
        $this->assertObjectHasAttribute('url', $response);
        $this->assertObjectHasAttribute('title', $response);

        $this->assertSame(1, $response->result);
        $this->assertSame($body['amount'], $response->amount * 1);

        return $response;
    }

//    public function testBlik(): void
//    {
//        $client = $this->getClient();
//        $response = $this->create($client);
//        $body = [
//            'title'=>$response->title,
//            'code'=>'123456',
//            'amount' => 999.99,
//        ];
//
//        $response = $client->transaction->blik($body);
//
//
//        $this->assertIsObject($response);
//
//        $this->assertObjectHasAttribute('result', $response);
//
//        $this->assertSame(1, $response->result);
//    }

//    public function testGet(): void
//    {
//        $client = $this->getClient();
//        $body = [
//            'title'=>'TR-BRA-KGZK0X',
//        ];
//
//        $response = $client->transaction->get($body);
//
//        $this->assertIsObject($response);
//
//        $this->assertObjectHasAttribute('result', $response);
//        $this->assertObjectHasAttribute('status', $response);
//
//        $this->assertSame(1, $response->result);
//        $this->assertSame('correct', $response->status);
//    }

    public function testGet(): void
    {
        $client = $this->getClient();
        $body = [
            'title'=>'TR-BRA-KGZK0X',
        ];

        $response = $client->transaction->get($body);

        $this->assertIsObject($response);

        $this->assertObjectHasAttribute('result', $response);
        $this->assertObjectHasAttribute('status', $response);

        $this->assertSame(1, $response->result);
        $this->assertSame('correct', $response->status);
    }


    private function getClient()
    {
        return new \Viras\Tpay\Client([
            'apiKey'=>'75f86137a6635df826e3efe2e66f7c9a946fdde1',
            'apiPass'=>'p@$$w0rd#@!'
        ]);
    }
}