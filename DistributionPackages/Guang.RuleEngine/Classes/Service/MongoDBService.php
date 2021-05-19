<?php
namespace Guang\RuleEngine\Service;

use MongoClient;
use MongoDB\Client;
use MongoDB\Driver\Manager;
use MongoDB\Model\BSONDocument;
use Neos\Flow\Annotations as Flow;
use function MongoDB\BSON\fromPHP;
use function MongoDB\BSON\toJSON;

class MongoDBService {

    /**
     * @param $user
     * @param $password
     * @param $server
     */
    public function setConnection($user, $password, $server)
    {
        setcookie('mongodbuser', $user);
        setcookie('mongodbpassword', $password);
        setcookie('mongodbserver', $server);
    }

    public function closeConnection()
    {
        setcookie('mongodbuser', '', 1, '/');
        setcookie('mongodbpassword', '', 1, '/');
        setcookie('mongodbserver', '', 1, '/');
        setcookie('mongodbdatabase', '', 1, '/');
        sleep(1);
    }

    public function setDatabase(string $database)
    {
        setcookie('mongodbdatabase', $database);
    }

    /**
     * @param string $database
     * @param string $collection
     * @return false|string
     */
    public function getData(string $collection)
    {
        $client = $this->getClient();
        if (is_null($client)) {
            return '';
        }
        $collection = $client->selectCollection($this->getDatabaseName(), $collection);
        $items = $collection->find()->toArray();

        return json_encode($items, JSON_PRETTY_PRINT);
    }

    /**
     * @return array
     */
    public function getDatabaseNames()
    {
        $client = $this->getClient();
        $database = [];
        foreach ($client->listDatabaseNames() as $databaseName) {
            $database[$databaseName] = $databaseName;
        }
        return $database;
    }

    /**
     * @return bool
     */
    public function hasConnectionData()
    {
        return (isset($_COOKIE['mongodbuser']) && isset($_COOKIE['mongodbpassword']) && isset($_COOKIE['mongodbserver']));
    }

    /**
     * @return array
     */
    public function getConnectionData()
    {
        if ($this->hasConnectionData()) {
            return ['user' => $_COOKIE['mongodbuser'], 'server' => $_COOKIE['mongodbserver']];
        }
        return [];
    }

    public function getCollections()
    {
        $client = $this->getClient();
        $collection = [];
        foreach ($client->selectDatabase($_COOKIE['mongodbdatabase'])->listCollectionNames() as $collectionName) {
            $collection[$collectionName] = $collectionName;
        }
        return $collection;
    }

    public function hasDatabaseChoosen()
    {
        return isset($_COOKIE['mongodbdatabase']);
    }

    public function getDatabaseName()
    {
        return $_COOKIE['mongodbdatabase'];
    }

    private function getClient()
    {
        if ($this->hasConnectionData()) {
            return new Client('mongodb+srv://'.$_COOKIE['mongodbuser'].':'.$_COOKIE['mongodbpassword'].'@'.$_COOKIE['mongodbserver']);
        }
        return null;
    }

}
