<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\ProductSampleDataUpdate\Setup\Patch\Data;


use Magento\Framework\Setup\Patch\DataPatchInterface;
use MagentoEse\ProductSampleDataUpdate\Model\ProductUpdate;
use MagentoEse\ProductSampleDataUpdate\Setup\SetSession;


class FixUrlKeys implements DataPatchInterface
{


    /** @var ProductUpdate  */
    protected $productUpdate;

    public function __construct(ProductUpdate $productUpdate, SetSession $setSession)
    {
        $this->productUpdate = $productUpdate;
    }

    public function apply()
    {
        $this->productUpdate->install(['MagentoEse_ProductSampleDataUpdate::fixtures/urlKeyFix.csv']);
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}