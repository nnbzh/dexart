<?php

namespace App\Utils;

use CurlHandle;

class HttpClient
{
    private string $baseUrl;

    private array $headers;

    public function __construct(string $baseUrl, array $headers = [])
    {
        $this->baseUrl = $baseUrl;
        $this->headers = $headers;
    }

    public function get(string $uri, array $params = [], $headers = []): mixed
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL             => "$this->baseUrl/$uri?".$this->buildQuery($params),
            CURLOPT_HTTPHEADER      => $this->buildHeaders($headers),
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => "",
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => "GET"
        ]);
        $response = curl_exec($curl);
        $code     = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->handleErrors($curl);

        return json_decode($response, true);
    }

    public function post(string $uri, array $params = [], $headers = []): mixed
    {
        $curl = curl_init("$this->baseUrl/$uri");
        curl_setopt_array($curl, [
            CURLOPT_HTTPHEADER      => array_merge($this->headers, $headers),
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_POSTFIELDS      => $params,
        ]);

        $response = curl_exec($curl);
        $code     = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->handleErrors($curl);

        return json_decode($response, true);
    }

    private function buildQuery(array $params = []): string
    {
        return http_build_query($params);
    }

    private function handleErrors(CurlHandle|bool $curl): void
    {
        $error    = curl_error($curl);
        $errno    = curl_errno($curl);

        if (is_resource($curl)) {
            curl_close($curl);
        }

        if (0 !== $errno) {
            response([
                'message' => $error
            ], 500);
        }
    }

    private function buildHeaders(array $headers)
    {
        $formatted = [];

        foreach (array_merge($headers, $this->headers) as $key => $value) {
            $formatted[] = "$key: $value";
        }

        return $formatted;
    }
}