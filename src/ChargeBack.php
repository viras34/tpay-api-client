<?php
namespace Viras\Tpay;

class ChargeBack
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
     * The method used to refund full transaction amount.
     * @link https://docs.tpay.com/#!/Transaction_API/post_api_gw_api_key_chargeback_transaction
     *
     * @param array $data
     * @return \stdClass
     * @throws ClientException
     */
    public function transaction(array $data): \stdClass
    {
        $response = $this->client->request('POST', 'chargeback/transaction', $data);

        return $response;
    }

    /**
     * The method used to refund part of the transaction amount.
     * @link https://docs.tpay.com/#!/Transaction_API/post_api_gw_api_key_chargeback_any
     *
     * @param array $data
     * @return \stdClass
     * @throws ClientException
     */
    public function any(array $data): \stdClass
    {
        $response = $this->client->request('POST', 'chargeback/any', $data);

        return $response;
    }

    /**
     * The method used to check transaction refunds statuses.
     * @link https://docs.tpay.com/#!/Transaction_API/post_api_gw_api_key_chargeback_status
     *
     * @param array $data
     * @return \stdClass
     * @throws ClientException
     */
    public function status(array $data): \stdClass
    {
        $response = $this->client->request('POST', 'chargeback/status', $data);

        return $response;
    }
}