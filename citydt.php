<?php
if (isset($_GET['q'])) {
    $cityInput = $_GET['q'];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://city-and-state-search-api.p.rapidapi.com/cities/$cityInput",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: city-and-state-search-api.p.rapidapi.com",
            "X-RapidAPI-Key: 606a565222msh11a3fc50796560fp1ec259jsn55ce72275eb8"
        ],
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);

    curl_close($curl);

    if ($error) {
        echo "cURL Error #:" . $error;
    } else {
        $cityDetails = json_decode($response, true);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>City Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
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
                            <h3 class="text-center">City Information</h3>
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
                    <?php if (isset($cityDetails['country_code'])): ?>
                        <table class="table table-striped">
                            <?php
                            $data = [
                                'City ID' => $cityDetails['id'],
                                'City Name' => $cityDetails['name'],
                                'State Name' => $cityDetails['state_name'] ?? 'No data available',
                                'Country Name' => $cityDetails['country_name'] ?? 'No data available',
                            ];
                            ?>

                            <?php foreach ($data as $key => $value): ?>
                                <tr>
                                    <th><?= $key ?></th>
                                    <td><?= $value ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (isset($cityDetails['country_code'])): ?>
                                <tr>
                                    <th>Country Flag:</th>
                                    <td>
                                        <img src="https://flagcdn.com/w320/<?= strtolower($cityDetails['country_code']) ?>.png"
                                             alt="<?= $cityDetails['country_name'] ?> Flag" width="100" height="50">
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>

                        <?php if (isset($cityDetails['name']) && isset($cityDetails['country_name'])): ?>
                            <div class="map-container">
                                <iframe
                                    width="100%"
                                    height="300"
                                    frameborder="1" style="border:1"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCHv37QJ-NpJo1tX9g0yvD7SyZ6RAM52Vc &q=kanp<?= urlencode($cityDetails['name'] . ', ' . $cityDetails['country_name']) ?>&zoom=12"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <p>No city details available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
