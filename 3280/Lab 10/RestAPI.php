<?php

//Require configuration
require_once('inc/config.inc.php');

//Require Entities
require_once('inc/Entities/Customer.class.php');

//Require stdClass
require_once('stdClass/PDOAgent.class.php');
require_once('stdClass/CustomerDAO.class.php');

//Require Utilities
require_once('inc/Utilities/CustomerConverter.class.php');

//Initialize Student DAO
CustomerDAO::initialize();

//This pulls the data from the stream.
$requestData = json_decode(file_get_contents('php://input'));

//Do some thing with the request
switch ($_SERVER["REQUEST_METHOD"]) {

     case "POST":
        if (
        //Very simple validation
        isset($requestData->Name)
        && isset($requestData->Address)
        && isset($requestData->City))    {
            
            //Insert the student
            $nc = new Customer();
            $nc->setName($requestData->Name);
            $nc->setAddress($requestData->Address);
            $nc->setCity($requestData->City);
            
            $result = CustomerDAO::createCustomer($nc);

            header('Content-Type: application/json');
            echo json_encode($result);

        } else {

            header('Content-Type: application/json');
            echo json_encode(array("message" => "Insert failed"));
        }

        break;
    
     case "GET":

        if (isset($requestData->id))   {
            $customer = CustomerDAO::getCustomer($requestData->id);
            $stdCustomer = CustomerConverter::convertToStdClass($customer);

            header('Content-Type: application/json');
            echo json_encode($stdStudent);

        } else {

            $stdCustomers = CustomerConverter::convertToStdClass(CustomerDAO::getCustomers());
            
            header('Content-Type: application/json');
            echo json_encode($stdCustomers);

        }
     break;
    
     case "PUT":
        //Do put things...
     break;
    
     case "DELETE":
        //Do delete things... 
        if (isset($requestData->id))    {
        
            $result = CustomerDAO::deleteCustomer($requestData->id);
            header('Content-Type: application/json');
            echo json_encode($result);

        } else {
            header('Content-Type: application/json');
            echo json_encode(array("message" => "You must specify an id before you vaporize a customer."));
        }
     break;
    
     default:
        echo json_encode("");
    break;
    }


?>