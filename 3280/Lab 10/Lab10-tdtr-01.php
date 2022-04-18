<?php

//Require configuration
require_once('inc/config.inc.php');

//Require Entities
require_once('inc/Entities/Customer.class.php');

//Require Utilities
require_once('stdClass/RestClient.class.php');
require_once('stdClass/Page.class.php');

//Require stdClass
require_once('inc/Utilities/CustomerConverter.class.php');

//Check if there was get data, perofrm the action
if (!empty($_GET))    {
    //Perform the Action
    if ($_GET["action"] == "delete")  {
        //Call the rest client with DELETE
        RestClient::call("DELETE", array('id'=>$_GET["id"]));
    }

    if ($_GET["action"] == "edit")  {
        //Call the rest client with GET, decode the result
        RestClient::call("GET", array('id'=>$_GET["id"]));
        //Convert the decoded customer
    }

}

//Check for post data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["action"]) && $_POST["action"] == "edit")    {
        //Assemble the the postData
        //Call the RestClient with PUT
    //Was probably a create
    } else {
        //Assemble the Customer
        $nc = new Customer();
        $nc->setName($_POST["name"]);
        $nc->setAddress($_POST["address"]);
        $nc->setCity($_POST["city"]);

        $stdCustomer = CustomerConverter::convertToStdClass($nc);
        //Add the the Customer 
        RestClient::call("POST", $stdCustomer);
    }
}

//Get all the customers from the web service via the REST client
$stdCustomerList = json_decode(RestClient::call("GET", array()));
//Store the customer objects 
$customers = CustomerConverter::convertToCustomerClass($stdCustomerList);


Page::$title = "Lab 10 - Tri Duc Tran - 300270001";
Page::header();
Page::listCustomers($customers);


//Check Get again, display the right form edit or add
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_POST["action"] == "edit") {
        Page::editCustomer($ec);
    } else {
        Page::addCustomer();
    }
}

Page::footer();