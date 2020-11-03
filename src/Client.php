<?php
namespace Viras\Tpay;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use UnexpectedValueException;
use \stdClass;

class Client
{
//    private $secureIpTable = [
//        '195.149.229.109', '148.251.96.163', '178.32.201.77',
//        '46.248.167.59', '46.29.19.106', '176.119.38.175'
//    ];

    /**
     * @var string HTTP method used to fetch access tokens.
     */
    const METHOD_GET = 'GET';

    /**
     * @var string HTTP method used to fetch access tokens.
     */
    const METHOD_POST = 'POST';

    protected $apiKey;

    protected $apiPass;

    /**
     * @var Transaction
     */
    public $transaction;

    /**
     * @var GuzzleClient
     */
    private $client;

    public function __construct(array $options = [])
    {
        $this->apiPass = $options['apiPass'];
        $this->apiKey = $options['apiKey'];

        $this->client = new GuzzleClient([
            'base_uri' => $this->getBaseUrl(),
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $this->transaction = new Transaction($this);
    }

    protected function getBaseUrl()
    {
        return 'https://secure.tpay.com/api/gw/' . $this->apiKey . '/';
    }

    /**
     * @param $method
     * @param $endpoint
     * @param array $data
     * @return mixed
     * @throws ClientException|\GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $endpoint, $data = [])
    {
        $data['json'] = true;
        $options = [
//            'on_stats' => function ($stats) {
//                if ($stats->hasResponse()) {
//                    $stats->getResponse()->stats = $stats;
//                }
//            }
        ];
        switch ($method) {
            case 'GET':
                $options['query'] = $data;
                break;
            default:
                $data['api_password'] = $this->apiPass;
                $options['form_params'] = $data;
        }

        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new ClientException($e->getMessage());
        }

        return $this->handleResponse($response);
    }

    /**
     * @param int $merchantId
     * @param bool $onlyAvailable
     * @return array
     * @throws ClientException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBankGroups(int $merchantId, bool $onlyAvailable=true ): array
    {
        $client = new GuzzleClient([
            'base_uri' => 'https://secure.tpay.com',
        ]);

        $available = (int) $onlyAvailable;

        try {
            $response = $client->request('GET', "groups-{$merchantId}{$available}.js?json");
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new ClientException($e->getMessage());
        }

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @param Response $response
     * @return mixed
     */
    private function handleResponse(Response $response)
    {
        $stream = Utils::streamFor($response->getBody());
        return $this->parseJson($stream);
    }

    /**
     * @param $content
     * @return stdClass
     */
    private function parseJson($content)
    {
        $content = json_decode($content, false);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new UnexpectedValueException(sprintf(
                "Failed to parse JSON response: %s",
                json_last_error_msg()
            ));
        }

        return $content;
    }
}