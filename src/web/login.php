<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../db/example_database.php';

use Firebase\JWT\JWT;
use Packback\Lti1p3;

JWT::$leeway = 5;

Packback\Lti1p3\LtiOidcLogin::new(new ExampleDatabase())
    ->doOidcLoginRedirect(TOOL_HOST . "/index.php")
    ->doRedirect();
?>