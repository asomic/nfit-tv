<?php

namespace App\Models\Tenant;

use GuzzleHttp\Client;

class CloudFlare
{
    /**
     * [$client description]
     *
     * @var  GuzzleHttp\Client
     */
    protected $client;

    /**
     * CLOUDFLARE Credentials
     *
     * @var  string
     */
    protected $dnsUrl;

    /**
     * [$dnsAPIUrl description]
     *
     * @var [type]
     */
    protected $dnsAPIUrl;

    /**
     * [$dnsAPIUrl description]
     *
     * @var [type]
     */
    protected $apiKey;

    /**
     * [$dnsAPIUrl description]
     *
     * @var [type]
     */
    protected $dnsIP;

    /**
     * API KEY from CLOUDFLARE
     *
     * @var  string
     */
    protected $api_key;

    /**
     * [__construct description]
     *
     * @return  void
     */
    public function __construct() {
        // Instanciate Guzzle for HTTP Requests
        $this->client = new Client();

        /** Get dns URL, API KEY and IP from CloudFlare Credentials */
        $this->dnsUrl = config('services.cloudflare.dnsUrl');
        $this->dnsAPIUrl = config('services.cloudflare.dnsAPIUrl');
        $this->apiKey = config('services.cloudflare.apiKey');
        $this->dnsIP = config('services.cloudflare.dnsIP');
    }

    /**
     * Add specific sub domain to CloudFlare System
     *
     * @return  string|boolean
     */
    public function addDomain($subDomainName = null)
    {
        /** Add tenant web domain */
        $this->addDomainCloudFlare($subDomainName, $this->dnsUrl, $this->apiKey, $this->dnsIP);

        /** Add tenant API domain */
        $this->addDomainCloudFlare($subDomainName, $this->dnsAPIUrl, $this->apiKey, $this->dnsIP);

        return true;
    }

    /**
     * Convert error json to array put on errors table the exception
     * and return it like a string to the admnin
     *
     * @param   json    $error
     * @param   string  $sub_domain_name
     *
     * @return  string
     */
    private function checkError($error, $subDomainName)
    {
        $error = json_decode($error);

        \DB::connection('system')->table('errors')->insert([
            'exception' => 'domain: '. $subDomainName . ' ' . json_encode($error->errors[0]),
            'created_at' => now()
        ]);

        return $error->errors[0]->message;
    }

    /**
     * [addDomainCloudFlare description]
     *
     * @param   string  $subDomainName  name of the box
     * @param   string  $url            domain from CloudFlare (nfit.app or nfitapi.com)
     * @param   string  $apiKey         get from CloudFlare
     * @param   string  $dnsIP          IP from CloudFlare, is the Server IP
     *
     * @return  boolean|\GuzzleHttp\Exception
     */
    private function addDomainCloudFlare($subDomainName, $url, $apiKey, $dnsIP)
    {
        try {
            $response = $this->client->post($url, [
                'headers' => [
                    'X-Auth-Email' => 'contacto@nfit.app',
                    'X-Auth-Key' => $apiKey,
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode([
                    'type'     => 'A',
                    'name'     => $subDomainName,
                    'content'  => $dnsIP,
                    'ttl'      => 120,
                    'priority' => 10,
                    'proxied'  => true
                ])
            ]);

            return true;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            /**  Get error data stream */
            $error = $e->getResponse()->getBody()->getContents();
            /**  Parse error to a readable message and return */
            return $this->checkError($error, $subDomainName);
        }
    }
}
