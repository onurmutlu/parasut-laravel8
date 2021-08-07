<?php

namespace Onurmutlu\Parasut;

use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class Product extends Base
{
    public function list($params = [])
    {
        $params = parent::params_replace($params);

        return collect($this->client->request(
            'products/',
            $params,
            'GET'
        ));
    }

    public function create($data)
    {
        return $this->client->request(
            'products',
            $data
        );
    }

    public function show($id, $data = [])
    {
        return $this->client->request(
            'products/' . $id,
            $data,
            'GET'
        );
    }

    public function update($id, $data = [])
    {
        return $this->client->request(
            'products/' . $id,
            $data,
            'PUT'
        );
    }

    /**
     * Tüm ürünleri Excel dosyası olarak aktarır.
     * @return bool|mixed
     * @throws \Exception
     */
    public function export()
    {
        $exurl = $this->client->request(
            'products/export',
            [],
            'GET'
        );

        if (isset($exurl['data']['attributes']['url'])) {
            sleep(3);
            $getaws = Http::withHeaders([
                'Accept' => 'application/json',
                'User-Agent' => null,
            ])->get(urldecode($exurl['data']['attributes']['url']));

            $awsurl2 = json_decode($getaws->body(), true);

            if (isset($awsurl2['url'])) {
                sleep(3);
                $contents = file_get_contents($awsurl2['url']);
                \Storage::put('tmp_parasut_products.xlsx', $contents);

                $import = new \App\Imports\ProductImport();
                Excel::import($import, \Storage::path('tmp_parasut_products.xlsx'));

                return true;
            }
            \Log::error('Product transfer Link-2 error Response:'.$getaws->status(), (array)$awsurl2);

            return false;
        }
        \Log::error('Product transfer Link-1 error Response:'.$getaws->status(), (array)$awsurl2);

        return false;
    }
}
