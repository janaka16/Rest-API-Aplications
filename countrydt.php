<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" >
    <meta charset="UTF-8">
    <style>
       

    </style>
    <title>Country Details</title>
</head>
<body>
    <?php 
        $countryCode = $_POST['country_code'];
        $countries = json_decode(file_get_contents("https://restcountries.com/v3.1/region/Asia"), true);
        $country = null;

        foreach ($countries as $c) {
            if ($c['cca2'] === $countryCode) {
                $country = $c;
                break;
            }
        }

        if ($country !== null) {
            $officialName = $country['name']['official'];
            $commonName = $country['name']['common'];
            $flagURL = $country['flags']['png'];
            $capital = isset($country['capital'][0]) ? $country['capital'][0] : 'No capital';
            $currency = $country['currencies'][key($country['currencies'])]['name'];
            $subregion = $country['subregion'];
            $continent = $country['continents'][0];
            $languages = isset($country['languages']) ? $country['languages'] : [];
            $borders = isset($country['borders']) ? $country['borders'] : [];
            $population = $country['population'];
            $area = $country['area'];
        }
    ?>

    <h2 class="text-center"><?= $commonName ?></h2>
    <table class="table table-striped">
        <tbody>
            <tr>
            
                <td class="flag-cell" colspan="2" style="text-align: center">
                    <img src="<?= $flagURL ?>" class="flag-img" />
                </td>
            </tr>
            <tr>
                <th>Official Name</th>
                <td><?= $officialName ?></td>
            </tr>
            <tr>
                <th>Capital</th>
                <td><?= $capital ?></td>
            </tr>
            <tr>
                <th>Currency</th>
                <td><?= $currency ?></td>
            </tr>
            <tr>
                <th>Subregion</th>
                <td><?= $subregion ?></td>
            </tr>
            <tr>
                <th>Continent</th>
                <td><?= $continent ?></td>
            </tr>
            <tr>
                <th>Languages</th>
                <td>
                    <?php if (!empty($languages)) : ?>
                        <?= implode(', ', $languages) ?>
                    <?php else : ?>
                        No languages found.
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Borders</th>
                <td>
                    <?php if (!empty($borders)) : ?>
                        <?= implode(', ', $borders) ?>
                    <?php else : ?>
                        No bordering countries.
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Population</th>
                <td><?= $population ?></td>
            </tr>
            <tr>
                <th>Area</th>
                <td><?= $area ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
