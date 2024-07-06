<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "covid_2023";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$apiKey = "606a565222msh11a3fc50796560fp1ec259jsn55ce72275eb8";
$endpoint = 'https://covid-193.p.rapidapi.com/statistics';

$curl = curl_init($endpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    "X-RapidAPI-Key: $apiKey"
]);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

if ($data && isset($data['response'])) {
    $statistics = $data['response'];


    $stmt = $conn->prepare("INSERT INTO covid_cases (countryName, population, totalcases, deaths, tests, continent, date) VALUES (?, ?, ?, ?, ?, ?, ?)");


    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    foreach ($statistics as $stat) {

        $countryName = $stat['country'];
        $population = $stat['population'] ?? 0;
        $totalCases = $stat['cases']['total'] ?? 0;
        $deaths = $stat['deaths']['total'] ?? 0;
        $tests = $stat['tests']['total'] ?? 0;
        $continent = $stat['continent'] ?? '';
        $date = date("Y-m-d");


        $stmt->bind_param("sisssss", $countryName, $population, $totalCases, $deaths, $tests, $continent, $date);


        if ($stmt->execute() !== true) {
            echo "Error: " . $stmt->error;
        }
    }

    echo "COVID-19 information saved successfully!";
} else {
    echo "Error geting data from the API.";
}


$stmt->close();
$conn->close();
