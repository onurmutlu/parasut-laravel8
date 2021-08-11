<?php

namespace Onurmutlu\Parasut;

class Account extends Base
{

    public function list($params = [])
    {
        $params = parent::params_replace($params);

        return collect($this->client->request(
            'contacts/',
            $params,
            'GET'
        ));
    }

    public function create($data)
    {
        return $this->client->request(
            'contacts',
            $data,
            'POST'
        );
    }

    public function show($id, $data = [])
    {
        return $this->client->request(
            'contacts/' . $id,
            $data,
            'GET'
        );
    }

    public function update($id, $data = [])
    {
        return $this->client->request(
            'contacts/' . $id,
            $data,
            'PUT'
        );
    }
}
