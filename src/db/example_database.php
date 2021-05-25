<?php
require_once __DIR__ . '/../vendor/autoload.php';
define("TOOL_HOST", ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?: $_SERVER['REQUEST_SCHEME']) . '://' . $_SERVER['HTTP_HOST']);
session_start();
use Firebase\JWT\JWT;
use Packback\Lti1p3;

JWT::$leeway = 5;

$_SESSION['iss'] = [];
$reg_configs = array_diff(scandir(__DIR__ . '/configs'), array('..', '.', '.DS_Store'));
foreach ($reg_configs as $key => $reg_config) {
    $_SESSION['iss'] = array_merge($_SESSION['iss'], json_decode(file_get_contents(__DIR__ . "/configs/$reg_config"), true));
}
class ExampleDatabase implements Packback\Lti1p3\Interfaces\Database {
    public function findRegistrationByIssuer($iss, $clientId = NULL): Packback\Lti1p3\Registration {
        $issuer = Issuer::find($iss);
        return Packback\Lti1p3\LTIRegistration::new()
            ->setAuthLoginUrl($issuer->auth_login_url)
            ->setAuthTokenUrl($issuer->auth_token_url)
            ->setClientId($issuer->client_id)
            ->setKeySetUrl($issuer->key_set_url)
            ->setKid($issuer->kid)
            ->setIssuer($issuer->issuer)
            ->setToolPrivateKey($issuer->private_key);
    }

    public function findDeployment($iss, $deployment_id, $clientId = NULL): Packback\Lti1p3\LtiDeployment {
        $issuer = Issuer::where('issuer', $issuer_url)
            ->where('client_id', $deployment_id)
            ->first();
        return Packback\Lti1p3\LtiDeployment::new()
            ->setDeploymentId($issuer->deployment_id);
    }

    private function private_key($iss) {
        return file_get_contents(__DIR__ . $_SESSION['iss'][$iss]['private_key_file']);
    }
}
?>