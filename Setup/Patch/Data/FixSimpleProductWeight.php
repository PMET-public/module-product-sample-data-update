<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\ProductSampleDataUpdate\Setup\Patch\Data;


use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use MagentoEse\ProductSampleDataUpdate\Model\ProductUpdate;
use MagentoEse\ProductSampleDataUpdate\Setup\SetSession;


class FixSimpleProductWeight implements DataPatchInterface, PatchVersionInterface
{

    /** @var ProductUpdate  */
    protected $productUpdate;

    public function __construct(ProductUpdate $productUpdate, SetSession $setSession)
    {
        $this->productUpdate = $productUpdate;
    }

    public function apply()
    {
        //fix missing weights in simple products
        $this->productUpdate->install(['MagentoEse_ProductSampleDataUpdate::fixtures/0.0.2.csv']);
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
    public static function getVersion()
    {
        return '0.0.4';
    }
}