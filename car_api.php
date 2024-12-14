<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

function getCarData($make, $model, $year, $apiKey) {
    $client = new Client();

    try {
        $response = $client->request('GET', 'https://api.api-ninjas.com/v1/cars', [
            'headers' => [
                'X-Api-Key' => $apiKey
            ],
            'query' => [
                'make' => $make,
                'model' => $model,
                'year' => $year
            ]
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            $body = $response->getBody();
            $data = json_decode($body, true);
            return $data;
        } else {
            // Handle non-200 responses
            return null;
        }
    } catch (Exception $e) {
        // Handle exceptions
        echo 'Error: ' . $e->getMessage();
        return null;
    }
}

// Example usage
$apiKey = 'HJ6a49+2fDfruCfYRtsu6w==MO72bBsxAzi5Afpc'; // Replace with your actual API key
$carData = getCarData('Toyota', 'Camry', '2020', $apiKey);
if ($carData) {
    print_r($carData);
} else {
    echo "Failed to fetch car data.";
}
?>
