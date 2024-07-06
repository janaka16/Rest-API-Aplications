<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" >
    <meta charset="UTF-8">
    <title>Asian Countries</title>
    <style>
        .country-flag {
            width: 30px;
            height: 20px;
        }
        
        th {
            color: blue;
        }
    </style>
</head>
<body>
    <?php
        $data = json_decode(file_get_contents("https://restcountries.com/v3.1/region/Asia"), true);
    ?>
    <h3 class="text-center">Asian Countries</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Flag</th>
                <th>Country Name</th>
                <th>Capital City</th>
                <th>Region</th>
                <th>Subregion</th>
                <th>Currencies</th>
                <th>Country Code</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $country) : ?>
                <tr>
                    <td><img src="<?= $country['flags']['png'] ?>" class="country-flag"></td>
                    <td><?= $country['name']['common'] ?></td>
                    <td><?= $country['capital'][0] ?? 'No capital' ?></td>
                    <td><?= $country['region'] ?></td>
                    <td><?= $country['subregion'] ?></td>
                    <td><?= $country['currencies'][key($country['currencies'])]['name']."(".$country['currencies'][key($country['currencies'])]['symbol'].")" ?></td>
                    <td><?= $country['cca2'] ?></td>
                    <td>
                        <form method="POST" action="countrydt.php">
                            <input type="hidden" name="country_code" value="<?= $country['cca2'] ?>">
                            <button type="submit" class="btn btn-success" name="details">View</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
