<?php
namespace Bondspear\ListingConstructor\Controller\Validator;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Controller\Result\JsonFactory;

class ColumnExistRule extends Action implements HttpPostActionInterface
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
        $db = $this->request->getParam('db');
        $result = false;
        $errors = false;

        if (!empty($db)) {
            if (stristr($db, '@', )) {
                $parts = explode('@', $db);
                $tableName = $parts[0];
                $primaryKey = $parts[1];

                $connection = $this->resourceConnection->getConnection();

                $sqlTables = $connection->fetchAll("SHOW TABLES");

                $sqlTables = array_column($sqlTables, key($sqlTables[0]));

                if (in_array($tableName, $sqlTables)) {
                    $table = $connection->getTableName($tableName);
                    $sql = $connection->fetchAll("DESCRIBE " . $table);
                    $columns = explode(',', $value);

                    if (!empty($sql)) {
                        $tableExist = false;
                        foreach ($sql as $k => $column) {
                            if ($column['Field'] == $primaryKey and $column['Extra'] == 'auto_increment') {
                                $tableExist = true;
                            }
                        }

                        if ($tableExist) {
                            foreach ($columns as $clm) {
                                if (in_array($clm, array_column($sql, 'Field'))) {
                                    $result = true;
                                } else {
                                    $errors = true;
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($errors) {
            $result = false;
        }

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData([
            'result' => $result
        ]);
    }
}
