<?php
/**
 * @package   Codewix_IPbasedMethods
 * @author    Ravinder <codewix@gmail.com>
 */

class Codewix_IpbasedMethods_Model_Observer {

    /*
     * Method will restrict payment methods 'checkmo','cashondelivery','purchaseorder' based on customer IP address
     * */

    public function paymentMethod($event) {

        $method = $event->getMethodInstance();
        $result = $event->getResult();
        $allowedMethods = array('checkmo','cashondelivery','purchaseorder');
        if(in_array($method->getCode(),$allowedMethods)){
            $userIpAddress = $_SERVER['REMOTE_ADDR'];
            $ipAddress = Mage::getStoreConfig('payment/'.$method->getCode().'/ip');
            if(empty($ipAddress)) {
                return;
            } else {
                $ipAddress = explode(',',$ipAddress);
                if(!in_array($userIpAddress,$ipAddress)) {
                    $result->isAvailable = false;
                }
            }
        }

    }

}