<?php namespace Happyclicker\Honeys;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HoneysOrder extends Honeys
{
    protected $body;

    public function __construct($options = [])
    {
        parent::__construct($options);
    }

    public function prepareOrder($order, $ship_code)
    {
        $this->body = $this->createXML($order, $ship_code); // Put API XML here.
    }

    public function submittedXML()
    {
        return $this->body;
    }

    public function submitOrder()
    {
        $client = new Client([
            'base_uri' => $this->base_url
        ]);

        try {
            $res = $client->request('GET', 'ws', [
                'query' => ['xmldata' => $this->body]
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

    public function createXML($order, $ship_code)
    {
        $xml = '<?xml version="1.0" encoding="iso-8859-1"?>
<HPEnvelope>
    <account>' . $this->account . '</account>
    <password>' . $this->api_token . '</password>
    <order>
        <reference>' . $order->order_number . '</reference>
        <shipby>' . $ship_code . '</shipby>
        <date>' . date('m-d-y') . '</date>
        <items>' .
           $this->createItemsXML($order->line_items) . '
        </items>
        ' . $this->createOrderAddressXML($order->shipping_address->cleanAddress()) . '
        <instructions></instructions>
    </order>
</HPEnvelope>';

        return($xml);
    }

    public function createItemsXML($items)
    {
        $xml = '';
        foreach($items as $item) {
            $xml .= '
            <item>
                <sku>' . $item->sku . '</sku>
                <qty>' . $item->quantity . '</qty>
            </item>';
        }
        return $xml;
    }

    public function createOrderAddressXML($addressArr)
    {
        return '<last>' . $addressArr['last_name'] . '</last>
        <first>' . $addressArr['first_name'] . '</first>
        <address1>' . $addressArr['address1'] . '</address1>
        <address2>' . $addressArr['address2'] . '</address2>
        <city>' . $addressArr['city'] . '</city>
        <state>' . $addressArr['state'] . '</state>
        <zip>' . $addressArr['zip'] . '</zip>
        <country>' . $addressArr['country_code'] . '</country>
        <phone>' . $addressArr['phone'] . '</phone>
        <emailaddress>none@none.com</emailaddress>';
    }
}