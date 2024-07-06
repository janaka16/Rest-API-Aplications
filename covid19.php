<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <meta charset="UTF-8">
  <title>COVID19 Information in Europe</title>

  <style>
    section {
      padding: 5rem 0;
      max-width: 1700px;
      margin: 0 auto;
    }
  </style>

</head>

<body>
  <section>

    <div id="main">
      <div id="content">
        <div class="container">
          <div class="row">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-10">
              <h3 class="text-center">COVID19 Information in Europe</h3>
              <div class="container">

                <hr />

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>


    <div class="text-black bg-white">
      <div class="row">
        <div class="col-2">&nbsp;</div>
        <div class="col-8">
          <?php

          $apiKey = '606a565222msh11a3fc50796560fp1ec259jsn55ce72275eb8';
          $endpoint = 'https://covid-193.p.rapidapi.com/statistics';

          $curl = curl_init();

          curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
              'X-RapidAPI-Key: ' . $apiKey
            ]
          ]);

          $response = curl_exec($curl);
          curl_close($curl);

          $data = json_decode($response, true);

          if ($data && isset($data['response'])) {
            $europeanCountries = [];

            foreach ($data['response'] as $countryData) {
              $continent = $countryData['continent'];
              $country = $countryData['country'];
              if ($continent === 'Europe' && $country !== 'Europe') {
                $country = $countryData['country'];
                $population = $countryData['population'];
                $totalCases = $countryData['cases']['total'] ?? '0';
                $totalDeaths = $countryData['deaths']['total'] ?? '0';
                $tests = $countryData['tests']['total'] ?? '0';

                $europeanCountries[] = [
                  'country' => $country,
                  'population' => $population,
                  'totalCases' => $totalCases,
                  'totalDeaths' => $totalDeaths,
                  'tests' => $tests,
                  'continent' => $continent
                ];
              }
            }

            ?>

            <table class="table">
              <tr>
                <th>Country</th>
                <th>Population</th>
                <th>Total Covid Cases</th>
                <th>Total Deaths</th>
                <th>Tests</th>
                <th>Continent</th>
              </tr>
              <?php foreach ($europeanCountries as $countryData) : ?>
                <tr>
                  <td><?php echo $countryData['country']; ?></td>
                  <td><?php echo $countryData['population']; ?></td>
                  <td><?php echo $countryData['totalCases']; ?></td>
                  <td><?php echo $countryData['totalDeaths']; ?></td>
                  <td><?php echo $countryData['tests']; ?></td>
                  <td><?php echo $countryData['continent']; ?></td>
                </tr>
              <?php endforeach; ?>
            </table>

          <?php
          } else {
            echo 'Error occurred while getting data from the API.';
          }

          ?>
        </div>
      </div>
    </div>

  </section>

</body>

</html>
