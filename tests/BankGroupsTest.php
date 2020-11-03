<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class BankGroupsTest extends TestCase
{
    public function testGet(): void
    {
        $client = $this->getClient();
        $data = $client->getBankGroups(10100);

        $this->assertIsArray($data);
        $this->assertIsArray($data[103]);
        $this->assertArrayHasKey('banks', $data[103]);
    }

    private function getClient()
    {
        return new \Viras\Tpay\Client([
            'apiKey'=>'75f86137a6635df826e3efe2e66f7c9a946fdde1',
            'apiPass'=>'p@$$w0rd#@!'
        ]);
    }
}