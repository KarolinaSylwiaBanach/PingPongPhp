<?php
//importing required script
require_once 'DbOperation.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!verifyRequiredParams(array('name', 'password'))) {
        //getting values
        $password = $_POST['password'];
        $name = $_POST['name'];
        

        //creating db operation object
        $db = new DbOperation();

        //adding user to database
        $result = $db->logInUser($name, $password);

        //making the response accordingly
        if ($result == ALL_RIGHT) {
            $response['error'] = false;
            $response['message'] = 'All right';
        } elseif ($result == USER_NOT_EXIST) {
            $response['error'] = true;
            $response['message'] = 'User not exist';
        } elseif ($result == USER_EXIST) {
            $response['error'] = true;
            $response['message'] = 'User exist';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'Required parameters are missing';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid request';
}

//function to validate the required parameter in request
//function to validate the required parameter in request
function verifyRequiredParams($required_fields)
{

    //Getting the request parameters
    $request_params = $_REQUEST;

    //Looping through all the parameters
    foreach ($required_fields as $field) {
        //if any requred parameter is missing
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {

            //returning true;
            return true;
        }
    }
    return false;
}

echo json_encode($response);	