<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../db/example_database.php';

use Firebase\JWT\JWT;
use Packback\Lti1p3;

JWT::$leeway = 5;
$launch = Packback\Lti1p3\LtiMessageLaunch::new(new ExampleDatabase())
    ->validate();

$launch_data = $launch->getLaunchData();
foreach ( $launch_data as $key => $value) {
    echo '<pre>'. $key . '::';
    var_dump($value);
    echo '</pre>';
}

?>


