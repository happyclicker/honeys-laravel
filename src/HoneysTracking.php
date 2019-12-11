<?php namespace Happyclicker\Honeys;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HoneysTracking extends Honeys
{

    public function __construct($options = [])
    {
        parent::__construct($options);
    }

    public function getTracking($order_reference_number)
    {
        $body = $this->createXML($order_reference_number); // Put API XML here.
        $client = new Client([
            'base_uri' => $this->base_url
        ]);

        try {
            $res = $client->get('ws', [
                'query' => ['xmldata' => $body],
                ]);

            $this->response_code = $res->getStatusCode();
            $this->response_message = $res->getReasonPhrase();
            $this->response_data = $res->getBody()->getContents();
            $this->response_body = $res->getBody();

            return(response()->json([
                'code' => $this->response_code,
                'message' => $this->response_message,
                'data' => $this->response_data,
                'body' => $this->response_body
            ]));
        } catch (GuzzleException $e) {
            // Handle the errors
            return(response()->json([
                'error' => $e->getMessage()
            ], 500));
        }
    }

    public function createXML($order_reference_number)
    {
        $xml = '<?xml version="1.0" encoding="iso-8859-1"?>
            <HPEnvelope>
                <account>' . $this->account . '</account>
                <password>' . $this->api_token . '</password>
                <orderstatus>' . $order_reference_number . '</orderstatus>
            </HPEnvelope>';

        return($xml);
    }
}