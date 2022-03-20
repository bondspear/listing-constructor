<?php
namespace Bondspear\ListingConstructor\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;
use Bondspear\ListingConstructor\FileGenerator\AdminControllerAddGenerator;
use Bondspear\ListingConstructor\FileGenerator\AdminControllerDeleteGenerator;
use Bondspear\ListingConstructor\FileGenerator\AdminControllerEditGenerator;
use Bondspear\ListingConstructor\FileGenerator\AdminControllerIndexGenerator;
use Bondspear\ListingConstructor\FileGenerator\AdminControllerMassDeleteGenerator;
use Bondspear\ListingConstructor\FileGenerator\AdminControllerUpdateGenerator;
use Bondspear\ListingConstructor\FileGenerator\DiGenerator;
use Bondspear\ListingConstructor\FileGenerator\FormActionAddGenerator;
use Bondspear\ListingConstructor\FileGenerator\FormButtonsGenerator;
use Bondspear\ListingConstructor\FileGenerator\FormGenerator;
use Bondspear\ListingConstructor\FileGenerator\LayoutAddGenerator;
use Bondspear\ListingConstructor\FileGenerator\LayoutEditGenerator;
use Bondspear\ListingConstructor\FileGenerator\LayoutIndexGenerator;
use Bondspear\ListingConstructor\FileGenerator\LeftMenuGenerator;
use Bondspear\ListingConstructor\FileGenerator\ListingActionsGenerator;
use Bondspear\ListingConstructor\FileGenerator\ListingDataProviderGenerator;
use Bondspear\ListingConstructor\FileGenerator\ListingDeleteActionGenerator;
use Bondspear\ListingConstructor\FileGenerator\ListingIndexGenerator;
use Bondspear\ListingConstructor\FileGenerator\ListingMassActionsGenerator;
use Bondspear\ListingConstructor\FileGenerator\AdminRouterGenerator;
use Magento\Framework\App\ResourceConnection;

class Save extends Action
{
    protected $resultPageFactory;
    protected $request;
    protected static $settings = [];
    protected static $listingModule;
    protected static $listingModel;
    protected $diGenerator;
    protected $formButtonsGenerator;
    protected $formActionAddGenerator;
    protected $formGenerator;
    protected $layoutAddGenerator;
    protected $layoutEditGenerator;
    protected $layoutIndexGenerator;
    protected $leftMenuGenerator;
    protected $listingDataProviderGenerator;
    protected $listingDeleteActionGenerator;
    protected $listingIndexGenerator;
    protected $listingActionsGenerator;
    protected $listingMassActionsGenerator;
    protected $adminControllerAddGenerator;
    protected $adminControllerMassDeleteGenerator;
    protected $adminControllerEditGenerator;
    protected $adminControllerIndexGenerator;
    protected $adminControllerDeleteGenerator;
    protected $adminControllerUpdateGenerator;
    protected $adminRouterGenerator;
    protected $resourceConnection;

    public function __construct(
        ResourceConnection $resourceConnection,
        AdminRouterGenerator $adminRouterGenerator,
        AdminControllerUpdateGenerator $adminControllerUpdateGenerator,
        AdminControllerDeleteGenerator $adminControllerDeleteGenerator,
        AdminControllerIndexGenerator $adminControllerIndexGenerator,
        AdminControllerEditGenerator $adminControllerEditGenerator,
        AdminControllerMassDeleteGenerator $adminControllerMassDeleteGenerator,
        DiGenerator $diGenerator,
        AdminControllerAddGenerator $adminControllerAddGenerator,
        FormActionAddGenerator $formActionAddGenerator,
        FormButtonsGenerator $formButtonsGenerator,
        FormGenerator $formGenerator,
        LayoutAddGenerator $layoutAddGenerator,
        LayoutEditGenerator $layoutEditGenerator,
        LayoutIndexGenerator $layoutIndexGenerator,
        LeftMenuGenerator $leftMenuGenerator,
        ListingActionsGenerator $listingActionsGenerator,
        ListingMassActionsGenerator $listingMassActionsGenerator,
        ListingDataProviderGenerator $listingDataProviderGenerator,
        ListingDeleteActionGenerator $listingDeleteActionGenerator,
        ListingIndexGenerator $listingIndexGenerator,
        RequestInterface $request,
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->adminRouterGenerator = $adminRouterGenerator;
        $this->adminControllerUpdateGenerator = $adminControllerUpdateGenerator;
        $this->adminControllerDeleteGenerator = $adminControllerDeleteGenerator;
        $this->adminControllerIndexGenerator = $adminControllerIndexGenerator;
        $this->adminControllerEditGenerator = $adminControllerEditGenerator;
        $this->diGenerator = $diGenerator;
        $this->adminControllerMassDeleteGenerator = $adminControllerMassDeleteGenerator;
        $this->adminControllerAddGenerator = $adminControllerAddGenerator;
        $this->formActionAddGenerator = $formActionAddGenerator;
        $this->formButtonsGenerator = $formButtonsGenerator;
        $this->formGenerator = $formGenerator;
        $this->layoutAddGenerator = $layoutAddGenerator;
        $this->layoutEditGenerator = $layoutEditGenerator;
        $this->layoutIndexGenerator = $layoutIndexGenerator;
        $this->leftMenuGenerator = $leftMenuGenerator;
        $this->listingDataProviderGenerator = $listingDataProviderGenerator;
        $this->listingDeleteActionGenerator = $listingDeleteActionGenerator;
        $this->listingIndexGenerator = $listingIndexGenerator;
        $this->listingActionsGenerator = $listingActionsGenerator;
        $this->listingMassActionsGenerator = $listingMassActionsGenerator;
        $this->request = $request;
        $this->resultPageFactory = $resultPageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        self::$settings = [
            'listingModule'     =>  $this->request->getParam('listing_module'),
            'listingModel'      =>  $this->request->getParam('listing_model'),
            'listingCollection' =>  $this->request->getParam('listing_collection'),
            'listingDb'         =>  $this->request->getParam('listing_db'),
            'listingColumns'    =>  $this->getAllColumns($this->request->getParam('listing_db'))
        ];
        //XML
        $this->diGenerator->generate(self::$settings);
        $this->leftMenuGenerator->generate(self::$settings);
        $this->layoutIndexGenerator->generate(self::$settings);
        $this->layoutEditGenerator->generate(self::$settings);
        $this->layoutAddGenerator->generate(self::$settings);
        $this->formGenerator->generate(self::$settings);
        $this->listingIndexGenerator->generate(self::$settings);
        $this->formActionAddGenerator->generate(self::$settings);
        $this->adminRouterGenerator->generate(self::$settings);
        //PHP
        $this->listingDataProviderGenerator->generate(self::$settings);
        $this->adminControllerAddGenerator->generate(self::$settings);
        $this->listingActionsGenerator->generate(self::$settings);
        $this->listingMassActionsGenerator->generate(self::$settings);
        $this->adminControllerMassDeleteGenerator->generate(self::$settings);
        $this->formButtonsGenerator->generate(self::$settings);
        $this->adminControllerEditGenerator->generate(self::$settings);
        $this->adminControllerIndexGenerator->generate(self::$settings);
        $this->adminControllerDeleteGenerator->generate(self::$settings);
        $this->adminControllerUpdateGenerator->generate(self::$settings);
        return  $this->resultPageFactory->create();
    }

    public function getAllColumns($tableData)
    {
        $parts = explode('@', $tableData);


        $connection = $this->resourceConnection->getConnection();
        $table = $connection->getTableName($parts[0]);
        $describe = $connection->fetchAll("DESCRIBE " . $table);

        $columns = [];
        foreach($describe as $column){
            $columns[] = $column['Field'];
        }
        return implode(',', $columns);
    }
}
