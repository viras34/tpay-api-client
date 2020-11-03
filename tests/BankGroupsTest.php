<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class BankGroupsTest extends TestCase
{
    public function testGet(): void
    {
        $client = $this->getClient();
        $data = $client->getBankGroups(13963);

        $this->assertIsArray($data);
        $this->assertIsArray($data[103]);
        $this->assertArrayHasKey('banks', $data[103]);
    }

    private function getClient()
    {
        return new \Viras\Tpay\Client([
            'apiKey'=>'',
            'apiPass'=>''
        ]);
    }
}