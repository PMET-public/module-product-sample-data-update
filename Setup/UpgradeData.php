<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\ProductSampleDataUpdate\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\State;



class UpgradeData implements UpgradeDataInterface
{
    protected $productUpdate;
    protected $state;


    public function __construct(\MagentoEse\ProductSampleDataUpdate\Model\ProductUpdate $productUpdate, State $state)
    {
        try{
            $state->setAreaCode('adminhtml');
        }
        catch(\Magento\Framework\Exception\LocalizedException $e){
            // left empty
        }
        $this->productUpdate = $productUpdate;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.2') < 0
        ) {
            //fix missing weights in simple products
            $this->productUpdate->install(['MagentoEse_ProductSampleDataUpdate::fixtures/0.0.2.csv']);
        }


        $setup->endSetup();
    }
}
