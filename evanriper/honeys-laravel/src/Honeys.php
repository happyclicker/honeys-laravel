<?php namespace Evanriper\Honeys;

class Honeys
{
    public $base_url;
    public $account;
    public $api_token;

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

}