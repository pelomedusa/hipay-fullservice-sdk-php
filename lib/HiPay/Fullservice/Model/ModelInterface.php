<?php
/**
 * HiPay Fullservice SDK PHP
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Apache 2.0 Licence
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * @copyright      Copyright (c) 2016 - HiPay
 * @license        http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0 Licence
 *
 */

namespace HiPay\Fullservice\Model;

/**
 * Model Interface
 *
 * Created for furthers features.
 * Not used for the moment but implemented
 *
 * @package     HiPay\Fullservice
 * @author        Kassim Belghait <kassim@sirateck.com>
 * @copyright   Copyright (c) 2016 - HiPay
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0 License
 * @link        https://github.com/hipay/hipay-fullservice-sdk-php
 */
interface ModelInterface
{

    /**
     * Return Json representation of public attributes
     * @return string Json representation
     */
    public function toJson();

    /**
     * Return public attributes accessible by getter in ARRAY format
     * @return array public attributes array
     */
    public function toArray();
}
