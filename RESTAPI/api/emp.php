<?php
define('TABLE_NAME', 'emp');

#empGet : select data of emp
if (!function_exists('empGet')) {
    function empGet($id = '')
    {

        $headers = ['Content-Type' => 'application/json;charset=utf-8', 'hasToken' => false];
        $response = ['json'];
        $params = ['single' => '/api/emp/$id', 'All Records' => '/api/emp'];

        if (empty($id)) {

            $query = new Query();
            $data = $query->select(TABLE_NAME)->commit()->getAllRecords();
            if (count($data) > 0) {

                echo json_encode([
                    'code' => 200,
                    'message' => $query->getSuccessMessage(),
                    'status' => true,
                    'error' => false,
                    'data' => $data,
                ], JSON_PRETTY_PRINT);
                exit();
            } else {
                echo json_encode([
                    'code' => 201,
                    'message' => $query->getErrorMessage(),
                    'status' => true,
                    'error' => false,
                    'data' => $data,
                ], JSON_PRETTY_PRINT);
                exit();

            }

        } else {

            $query = new Query();
            $data = $query->select(TABLE_NAME)->where('id', '=', $id)->commit()->getRow();
            if (count($data) > 0) {

                echo json_encode([
                    'code' => 200,
                    'message' => $query->getSuccessMessage(),
                    'status' => true,
                    'error' => false,
                    'data' => $data,
                ], JSON_PRETTY_PRINT);
                exit();
            } else {
                echo json_encode([
                    'code' => 201,
                    'message' => $query->getErrorMessage(),
                    'status' => true,
                    'error' => false,
                    'data' => $data,
                ], JSON_PRETTY_PRINT);
                exit();

            }

        }








    }
}

#empPost : Insert data of emp
if (!function_exists('empPost')) {
    function empPost()
    {
        $fillable = ['name', 'email', 'password', 'mobile', 'dept', 'salary'];
        $headers = ['Content-Type' => 'application/json;charset=utf-8', 'hasToken' => false];
        $response = ['json'];

    }
}

#empPut : Update data of emp
if (!function_exists('empPut')) {
    function empPut()
    {
        $fillable = ['name', 'email', 'mobile', 'dept', 'salary'];
        $headers = ['Content-Type' => 'application/json;charset=utf-8', 'hasToken' => false];
        $response = ['json'];

    }
}

#empDelete : Delete data of emp
if (!function_exists('empDelete')) {
    function empDelete()
    {

        $headers = ['Content-Type' => 'application/json;charset=utf-8', 'hasToken' => false];
        $response = ['json'];

    }
}




?>