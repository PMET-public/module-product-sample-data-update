<?php
/**
 * Copyright © 2018 Magento. All rights reserved.
 */

namespace MagentoEse\ProductSampleDataUpdate\Model;


use Magento\Setup\Exception;
use Magento\TargetRule\Model\RuleFactory;

class TargetRuleUpdate
{

    /** @var RuleFactory  */
    private $ruleFactory;

    public function __construct(RuleFactory $ruleFactory)
    {
        $this->ruleFactory = $ruleFactory;
    }

    /**
     * Fix issue in sample data where names of cart rules do not match rule types
     */
    public function updateTargetRuleName()
    {
        /** @var \Magento\TargetRule\Model\Rule $rule */
        $rules = $this->ruleFactory->create();
        $ruleCollection = $rules->getCollection()->getItems();
        foreach ($ruleCollection as $targetRule){
            $rule = $this->ruleFactory->create();
            $rule->load($targetRule->getId());
            //Defined types - Related Products (Related), Up-sells (Upsells), Cross-sells (Crosssell)
            $options = $rule->getAppliesToOptions();
            $assignedOption = $options[$rule->getApplyTo()]->getText();
            $ruleName = $rule->getName();
            if ($assignedOption == "Up-sells") {
                $ruleName = str_replace("Related", $assignedOption, $ruleName);
                $ruleName = str_replace("Crosssell", $assignedOption, $ruleName);
            } elseif ($assignedOption == "Related Products") {
                $ruleName = str_replace("Crosssell", $assignedOption, $ruleName);
                $ruleName = str_replace("Upsells", $assignedOption, $ruleName);
            } elseif ($assignedOption == "Cross-sells") {
                $ruleName = str_replace("Upsells", $assignedOption, $ruleName);
                $ruleName = str_replace("Related", $assignedOption, $ruleName);
            }
            $rule->setName($ruleName);
            $rule->save();
            //throw new Exception("doh");
        }
    }

}