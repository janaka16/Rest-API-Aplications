<?php
if (isset($_GET['q'])) {
    $cityInput = $_GET['q'];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://city-and-state-search-api.p.rapidapi.com/search?q=$cityInput",
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
        $cities = json_decode($response, true);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" >
    <title>City Details</title>
	
	
</head>

<body>

<div class="container">
    <div class="text-black bg-white">
        <div class="row">
        
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>City Name</th>
                        <th>State Name</th>
                        <th>Country Name</th>
                        <th></th>
                    </tr>
                </thead>
                    
                <tbody>
                
                    <?php 
                    if (!empty($cities) && is_array($cities)) {
                        foreach ($cities as $city) { ?>
                            <tr>
                                <td><?= $city['id']; ?></td>
                                <td><?= $city['name']; ?></td>
                                <td>
                                    <?php 
                                    if (isset($city['state_name'])) {
                                        echo $city['state_name'];
                                    }
                                    else {
                                        echo 'No data available';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($city['country_name'])) {
                                        echo $city['country_name'];
                                    }
                                    else {
                                        echo 'No data available';
                                    }
                                    ?>
                                </td>
                                
                                <td>
                                    <a href="citydt.php?q=<?= $city['id']; ?>">
                                        <button type="button" class="btn btn-success">City Details</button>
                                    </a>
                                </td>
                            </tr>
                    <?php }} else { ?>
                            <tr>
                                <td colspan="5">No cities found.</td>
                            </tr>
                    <?php } ?>
					
                </tbody>
					
            </table>
                
        </div>
			
    </div>
</div>
			
</body>
</html>
