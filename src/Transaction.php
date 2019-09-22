<?php
namespace Viras\Tpay;

/**
 * Class Transaction
 * @package Viras\Tpay
 */
class Transaction
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * This method allows you to prepare transaction for a customer.
     * @link https://docs.tpay.com/#!/Transaction_API/post_api_gw_api_key_transaction_create
     *
     * @param array $data
     * @return \stdClass
     * @throws ClientException
     */
    public function create(array $data): \stdClass
    {
        $crc = isset($data['crc']) ? $data['crc'] : '';
        $data['md5sum'] = md5($data['merchantId'] . $data['amount'] . $crc . $data['merchantSecret']);
        $data['id'] = $data['merchantId'];

        $response = $this->client->request('POST', 'transaction/create', $data);

        return $response;
    }

    /**
     * This method allows sending a BLIK code in direct communication between merchant and BLIK system.
     * @link https://docs.tpay.com/#!/Transaction_API/post_api_gw_api_key_transaction_blik
     *
     * @param array $data
     * @return \stdClass
     * @throws ClientException
     */
    public function blik(array $data): \stdClass
    {
        $response = $this->client->request('POST', 'transaction/blik', $data);

        return $response;
    }

    /**
     * This method allows you to get all information about the transaction by sending previously generated title.
     * @link https://docs.tpay.com/#!/Transaction_API/post_api_gw_api_key_transaction_get
     *
     * @param array $data
     * @return \stdClass
     * @throws ClientException
     */
    public function get(array $data): \stdClass
    {
        $response = $this->client->request('POST', 'transaction/get', $data);

        return $response;
    }

    /**
     * @TODO
     * This method returns payments report for the declared time range, generated in CSV format
     * @link https://docs.tpay.com/#!/Transaction_API/post_api_gw_api_key_transaction_report
     *
     * @param array $data
     * @return \stdClass
     * @throws  \Exception
     */
    public function report(array $data): \stdClass
    {
        throw new \Exception('Not implemented.');
    }
}