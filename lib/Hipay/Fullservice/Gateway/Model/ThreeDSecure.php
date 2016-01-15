<?php
/*
 * Hipay fullservice SDK
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @copyright      Copyright (c) 2016 - Hipay
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 *
 */
namespace Hipay\Fullservice\Gateway\Model;

/**
 * 3d secure model
 * 
 * Result of the 3-D Secure Authentication.
 * Include enrollment and authentication status
 * 
 * @see \Hipay\Fullservice\Enum\Transaction\ThreeDSecureStatus
 * 
 * @package Hipay\Fullservice
 * @author Kassim Belghait <kassim@sirateck.com>
 * @copyright Copyright (c) 2016 - Hipay
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @link https://github.com/hipay/hipay-fullservice-sdk-php
 * @api
 */
class ThreeDSecure extends AbstractTransaction
{
    /**
     * @var int $_eci The 3-D Secure (3DS) electronic commerce indicator.
     */
    private $_eci;
    
   /**
    * @var string $_enrollmentStatus The enrollment status.
    * @see \Hipay\Fullservice\Enum\Transaction\ThreeDSecureStatus
    */
   private $_enrollmentStatus;
   
   /**
    * @var string $_enrollmentMessage The enrollment message
    */
   private $_enrollmentMessage;
   
   /**
    * This field is only included if payment authentication was attempted and a value was received.
    * 
    * @var string $_authenticationStatus The authentication status
    * @see \Hipay\Fullservice\Enum\Transaction\ThreeDSecureStatus
    */
   private $_authenticationStatus;
   
   /**
    * This field is only included if payment authentication was attempted and a value was received.
    * @var string $_authenticationMessage Authentication message
    */
   private $_authenticationMessage;
   
   /**
    * This is a value generated by the card issuer as a token 
    * to prove that the cardholder was successfully authenticated.
    * 
    * @var string $_authenticationToken Authentication token
    */
   private $_authenticationToken;
   
   /**
    * A unique transaction identifier that is generated by the payment server on behalf of the merchant 
    * to identify the 3-D Secure transaction
    * 
    * @var string $_xid Unique transaction identifier
    */
   private $_xid;
    
}