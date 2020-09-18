<?php


namespace App;


use GuzzleHttp\Client;

class TransferClass
{
    /**
     * TransferClass constructor.
     */
    public function __construct()
    {
        $config = [
          'url' => $_ENV['API_URL'],

        ];
        $this->client = new Client($config);
    }

    public function send(array $client)
    {
        $result = $this->client->get( $this->client->getConfig()['url'].'/api/dosomething', ['userId' => $client['id'], 'name' => $client['name']])->withAddedHeader('Accept', 'application/json');
        if ($result->getStatusCode() === 200){
            return 'OK';
        }else{
            throw new \Exception('Client '.$client['id']." couldn't be send");
        }
    }
}