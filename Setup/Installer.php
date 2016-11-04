<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\ProductSampleDataUpdate\Setup;

use Magento\Framework\Setup;


class Installer implements Setup\SampleData\InstallerInterface
{

   protected $productUpdate;


    public function __construct(
        \MagentoEse\ProductSampleDataUpdate\Model\ProductUpdate $productUpdate

    ) {
        $this->productUpdate = $productUpdate;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        //correct hoodlie typo
        $this->productUpdate->install(['MagentoEse_ProductSampleDataUpdate::fixtures/0.0.1.csv']);
    }
}