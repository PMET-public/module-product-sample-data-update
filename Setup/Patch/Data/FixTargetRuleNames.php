<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\ProductSampleDataUpdate\Setup\Patch\Data;


use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use MagentoEse\ProductSampleDataUpdate\Model\TargetRuleUpdate;
use MagentoEse\ProductSampleDataUpdate\Setup\SetSession;


class FixTargetRuleNames implements DataPatchInterface, PatchVersionInterface
{

    /** @var TargetRuleUpdate  */
    protected $targetRuleUpdate;

    public function __construct(TargetRuleUpdate $targetRuleUpdate, SetSession $setSession)
    {
        $this->targetRuleUpdate = $targetRuleUpdate;
    }

    public function apply()
    {
        $this->targetRuleUpdate->updateTargetRuleName();
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