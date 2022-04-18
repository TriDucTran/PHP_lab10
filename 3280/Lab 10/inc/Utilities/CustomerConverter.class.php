<?php

class CustomerConverter {

    //This function will conver tot Standard Classes
    public static function convertToStdClass($data) {
        if (is_array($data))   {
            $stdObjects = array();
            //Convert every element into a stdClass and return it
            foreach ($data as $customer)    {

               $stdCus = new stdClass;
               $stdCus->CustomerID = $customer->getCustomerID();
               $stdCus->Name = $customer->getName();
               $stdCus->Address = $customer->getAddress();
               $stdCus->City = $customer->getCity();

               $stdObjects[] = $stdCus;
            }
        } else {
            $stdObjects = new stdClass;
            $stdObjects->CustomerID = $data->getCustomerID();
            $stdObjects->Name = $data->getName();
            $stdObjects->Address = $data->getAddress();
            $stdObjects->City = $data->getCity();
        }
        //REturn the stdObjects
        return $stdObjects;
    }

    public static function convertToCustomerClass($data)    {
        //Store the new Customers
        $newCustomers = array();
        if (is_array($data))   {
            //Go through all stndard Customers
            foreach ($data as $stdCustomer)    {
                //Create new Customer with the data
                $nc = new Customer();
                //Store the new Customer in the array
                $nc->setCustomerID($stdCustomer->CustomerID);
                $nc->setName($stdCustomer->Name);
                $nc->setAddress($stdCustomer->Address);
                $nc->setCity($stdCustomer->City);
               

               $newCustomers[] = $nc;
            }

        } else {
            //Create a single new Customer
            $nc = new Customer();
            $nc->getCustomerID();
            $nc->getName();
            $nc->getAddress();
            $nc->getCity();

            $newCustomers[] = $nc;
        }
        return $newCustomers;
    }

}