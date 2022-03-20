<?php
namespace Bondspear\ListingConstructor\Controller\Validator;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Controller\Result\JsonFactory;

class TableExistRule extends Action implements HttpPostActionInterface
{
    protected $resultJsonFactory;
    protected $resourceConnection;
    protected $request;

    public function __construct(ResourceConnection $resourceConnection, RequestInterface $request, Context $context, JsonFactory $resultJsonFactory)
    {
        $this->request = $request;
        $this->resourceConnection = $resourceConnection;
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $value = $this->request->getParam('value');

        $result = false;
        if (stristr($value, '@', )) {
            $parts = explode('@', $value);
            $tableName = $parts[0];
            $primaryKey = $parts[1];

            $connection = $this->resourceConnection->getConnection();

            $sqlTables = $connection->fetchAll("SHOW TABLES");

            $sqlTables = array_column($sqlTables,key($sqlTables[0]));



            if(in_array($tableName,$sqlTables)){
                $table = $connection->getTableName($tableName);
                $sql = $connection->fetchAll("DESCRIBE " . $table);

                if (!empty($sql)) {
                    foreach ($sql as $k => $column) {
                        if ($column['Field'] == $primaryKey and $column['Extra'] == 'auto_increment') {
                            $result = true;
                        }
                    }
                }
            }
        }

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData([
            'result' => $result
        ]);
    }
}
