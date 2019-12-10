<?php namespace Happyclicker\Honeys;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HoneysStockCheck extends Honeys
{

    public function __construct($options = [])
    {
        parent::__construct($options);
    }

    public function getStock($skus)
    {
        $body = $this->createXML($skus); // Put API XML here.
        $client = new Client([
            'base_uri' => $this->base_url
        ]);

        try {
            $res = $client->request('GET', 'ws', [
                'query' => ['xmldata' => $body],
                ]);

            $this->response_code = $res->getStatusCode();
            $this->response_message = $res->getReasonPhrase();
            $this->response_data = $res->getBody()->getContents();
            return(response()->json([
                'code' => $res->getStatusCode(),
                'message' => $res->getReasonPhrase(),
                'data' => $res->getBody()->getContents()
            ]));
        } catch (GuzzleException $e) {
            // Handle the errors
            return(response()->json([
                'error' => $e->getMessage()
            ], 500));
        }
    }

    public function createXML($skus)
    {
        $xml = '<?xml version="1.0" encoding="iso-8859-1"?><HPEnvelope><account>' . $this->account . '</account><password>' . $this->api_token . '</password><stockcheck>';
        if(is_string($skus)) {
            $xml .= '<sku>' . $skus . '</sku>';
        } else if(is_array($skus)) {
            foreach($skus as $sku) {
                $xml .= '<sku>' . $sku . "</sku>";
            }
        }
        $xml .= '</stockcheck></HPEnvelope>';

        return($xml);
    }
}