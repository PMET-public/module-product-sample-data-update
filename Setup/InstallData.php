<?php

namespace MagentoEse\ProductSampleDataUpdate\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


    /**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{

    private $sampleDataContext;
    private $productFactory;
    private $state;


    public function __construct(\Magento\Framework\Setup\SampleData\Context $sampleDataContext,
                                \Magento\Catalog\Model\ProductFactory $productFactory,
                                \Magento\Framework\App\State $state)
    {

        try{
            $state->setAreaCode('adminhtml');
        }
        catch(\Magento\Framework\Exception\LocalizedException $e){
            // left empty
        }

        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->productFactory = $productFactory;

    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        $_fileName = $this->fixtureManager->getFixture('MagentoEse_ProductSampleDataUpdate::fixtures/Products.csv');
        $_rows = $this->csvReader->getData($_fileName);

        $_header = array_shift($_rows);

        foreach ($_rows as $_row) {

            $_product = $this->productFactory->create();
            $_data = [];
            foreach ($_row as $_key => $_value) {
                $_data[$_header[$_key]] = $_value;
            }
            $_row = $_data;
            $_product->load($_product->getIdBySku($_row['sku']));
            $_product->setName($_row['name']);

            try {
                $_product->save();
            } catch (Exception $e) {
                echo $_row['sku'] . "Failed\n";
            }
            unset($_product);

        }
    }
}