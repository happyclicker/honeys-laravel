<?php namespace Happyclicker\Honeys;

class Honeys
{
    public $base_url;
    public $account;
    public $api_token;

    protected $response_code;
    protected $response_message;
    protected $response_data;
    protected $response_body;

    function __construct($options = [])
    {
        $this->bootstrap($options);
    }

    public function bootstrap($options)
    {
        if(empty($options))
        {
            $this->base_url = config('honeys.api_base_url');
            $this->account = config('honeys.account');
            $this->api_token = config('honeys.api_key');
        } else {
            $this->base_url = $options['api_base_url'];
            $this->account = $options['account'];
            $this->api_token = $options['api_key'];
        }
    }

    public function getResponseCode()
    {
        return $this->response_code;
    }

    public function getResponseMessage()
    {
        return $this->response_message;
    }

    public function getResponseData()
    {
        return $this->response_data;
    }

    public function getResponseBody()
    {
        return $this->response_body;
    }
}