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
use MagentoEse\ProductSampleDataUpdate\Model\ProductUpdate;
use MagentoEse\ProductSampleDataUpdate\Model\TargetRuleUpdate;


class UpgradeData implements UpgradeDataInterface
{

    /** @var ProductUpdate  */
    private $productUpdate;

    /** @var TargetRuleUpdate  */
    private $targetRuleUpdate;


    /**
     * UpgradeData constructor.
     * @param ProductUpdate $productUpdate
     * @param State $state
     * @param TargetRuleUpdate $targetRuleUpdate
     */
    public function __construct(ProductUpdate $productUpdate, State $state, TargetRuleUpdate $targetRuleUpdate)
    {
        try{
            $state->setAreaCode('adminhtml');
        }
        catch(\Magento\Framework\Exception\LocalizedException $e){
            // left empty
        }
        $this->productUpdate = $productUpdate;
        $this->targetRuleUpdate = $targetRuleUpdate;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Exception
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.2') < 0
        ) {
            //fix missing weights in simple products
            $this->productUpdate->install(['MagentoEse_ProductSampleDataUpdate::fixtures/0.0.2.csv']);
        }

        if (version_compare($context->getVersion(), '0.0.4', '<='))
        {
            //fix missing weights in simple products
            $this->targetRuleUpdate->updateTargetRuleName();
        }


        $setup->endSetup();
    }
}
