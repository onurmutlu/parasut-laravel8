<?php

namespace Onurmutlu\Parasut;

class Base
{
    public $client;

    public function __construct(Client $client = null)
    {
        if( $client === null )
            $client = app('Onurmutlu\Parasut\Client');
        $this->client = $client;
    }

    /**
     * @param $params
     * @access private
     */
    static function params_replace($params){
        $pararr = [
            'page_size' => 'page[size]',
            'page_number' => 'page[number]'
        ];
        foreach($pararr as $key => $val){
            if(array_key_exists($key,$params)){
                $params[$val] = $params[$key];
                unset($params[$key]);
            }
        }

    }
}