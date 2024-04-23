<?php
header("Content-Type:application/json;charset=utf-8");
http_response_code(200);

$uri = $_SERVER['PHP_SELF'];
$endPoint = explode('index.php', $uri);
$uriEndPoint = $endPoint[1];
$parameter_Arr = explode('/', $uriEndPoint);
unset($parameter_Arr[0]);
$api_path = isset($parameter_Arr[1]) ? $parameter_Arr[1] : "";
$file_name = isset($parameter_Arr[2]) ? $parameter_Arr[2] : "";
$file_path = PROJECT_PATH . '/' . $api_path . '/' . $file_name . '.php';
if (file_exists($file_path)) {
    require_once $file_path;
    //Api Handling:-
    $arguments = [];
    for ($i = 3; $i <= count($parameter_Arr); $i++) {
        $arguments[] = $parameter_Arr[$i];
    }

    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $methodName = $file_name . strtolower($requestMethod);
    switch ($requestMethod) {
        case 'GET':
            handleRequest($requestMethod, $methodName, $arguments);
            break;
        case 'POST':
            handleRequest($requestMethod, $methodName, $arguments);
            break;
        case 'PUT':
            handleRequest($requestMethod, $methodName, $arguments);
            break;
        case 'PATCH':
            handleRequest($requestMethod, $methodName, $arguments);
            break;
        case 'DELETE':
            handleRequest($requestMethod, $methodName, $arguments);
            break;
        default:
            echo json_encode(
                array(
                    'code' => 404,
                    'message' => 'Invalid Request,This Method is not supported',
                    'status' => false,
                    'error' => true,
                    'data' => []
                ),
                JSON_PRETTY_PRINT
            );
            exit();
            break;

    }

} else {

    if (empty($api_path) and empty($file_name)) {
        header("Content-Type:text/html");
        require_once PROJECT_PATH . '/api/swagger/index.php';
        exit();
    } else {
        echo json_encode(
            array(
                'code' => 404,
                'message' => $file_name . ' resource, not found.',
                'status' => false,
                'error' => true,
                'data' => []
            ),
            JSON_PRETTY_PRINT
        );
        exit();
    }
}
//function handleRequest
function handleRequest($requestMethod, $methodName, $arguments)
{
    $clientName = isset($_GET['client']) ? $_GET['client'] : "POSTMAN";
    $method = isset($_GET['method']) ? $_GET['method'] : $requestMethod;
    if (in_array($clientName, ['POSTMAN', 'swagger']) and $method == $requestMethod) {

        //For Valid Request FROM POSTMAN 

        if (function_exists($methodName)) {
            return call_user_func_array($methodName, $arguments);
        } else {
            echo json_encode(
                array(
                    'code' => 404,
                    'message' => $requestMethod . ', function for ' . ucfirst(basename($methodName, strtolower($requestMethod))) . ' Does Not Exist',
                    'status' => false,
                    'error' => true,
                    'data' => []
                ),
                JSON_PRETTY_PRINT
            );
            exit();
        }

        //End for Valid Request from POSTMAN

    } else {
        echo json_encode(
            array(
                'code' => 404,
                'message' => 'This EndPoint,Request Type should be ' . $method,
                'status' => false,
                'error' => true,
                'data' => [],
            ),
            JSON_PRETTY_PRINT
        );
        exit();

    }

}


?>