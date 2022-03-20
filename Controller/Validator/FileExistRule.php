<?php
namespace Bondspear\ListingConstructor\Controller\Validator;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class FileExistRule extends Action implements HttpPostActionInterface
{
    const CONTROLLER_PATH = 'Bondspear/ListingConstructor/Controller/Validator';

    protected $resultJsonFactory;
    protected $request;

    public function __construct(RequestInterface $request, Context $context, JsonFactory $resultJsonFactory)
    {
        $this->request = $request;
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $value = str_replace('\\', '/', $this->request->getParam('value'));
        $module = str_replace('_', '/', $this->request->getParam('module'));
        $path =  str_replace(self::CONTROLLER_PATH, '', __DIR__);

        if ($value[0] != '/') {
            $value = '/' . $value;
        }

        if (!stristr($value, '.php')) {
            $value = $value . '.php';
        }

        $file = $path . $module . $value;
        $result = false;
        if (is_file($file)) {
            $result = true;
        }
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData([
            'result' => $result
        ]);
    }
}
