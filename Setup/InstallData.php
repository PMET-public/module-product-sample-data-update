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
    private $product;
    private $state;
    private $index;
    private $objectManager;


    public function __construct(\Magento\Framework\Setup\SampleData\Context $sampleDataContext,
                                \Magento\Store\Model\Store $storeView,
                                \Magento\Catalog\Model\ProductFactory $productFactory,
                                \Magento\Framework\App\State $state,
                                \Magento\Indexer\Model\Processor $index,
                                \Magento\Framework\ObjectManagerInterface   $objectManager)
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
        $this->index = $index;
        $this->objectManager=$objectManager;

    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        //get product file
        $_fileName = $this->fixtureManager->getFixture('MagentoEse_ProductSampleDataUpdate::fixtures/Products.csv');
        $_rows = $this->csvReader->getData($_fileName);

        $_header = array_shift($_rows);
        $_productsArray = array();
        foreach ($_rows as $_row) {
            $_productsArray[] = array_combine($_header, $_row);
        }
        $this->importerModel  = $this->objectManager->create('MagentoEse\ProductSampleDataUpdate\Model\Importer');
        try {
            $this->importerModel->processImport($_productsArray);
        } catch (\Exception $e) {
            print_r($e->getMessage());
       }

        print_r($this->importerModel->getLogTrace());
        print_r($this->importerModel->getErrorMessages());

    }
}