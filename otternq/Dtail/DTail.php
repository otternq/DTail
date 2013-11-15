<?php

namespace DTail;

use Aws\Common\Aws;
use Aws\DynamoDb\DynamoDbClient;

use Monolog\Logger;
use Monolog\Handler\DynamoDbHandler;
use Monolog\ErrorHandler;

use DTail\Utils;


class DTail {

    private $dynamodb;

    private $table;
    private $key;
    private $secret;
    private $region;

    public function __construct($config) {

        $config = new Utils\Arr($config); //use my array wrapper
        
        $this->table = $config->get('dyn-table');
        $this->key = $config->get('dyn-key', true);
        $this->secret = $config->get('dyn-secret', true);
        $this->region = $config->get('dyn-region', true);



        $this->dynamodb = $client = DynamoDbClient::factory(array(
            'key'    => $this->key,
            'secret' => $this->secret,
            'region' => $this->region,
            )
        );

    }

    public function get($channel) {

        $iterator = $this->dynamodb->getIterator('Query', array(
            'TableName'     => $this->table,
            'KeyConditions' => array(
                'channel' => array(
                    'AttributeValueList' => array(
                        array('S' => $channel)
                        ),
                    'ComparisonOperator' => 'EQ'
                    )
                )
            )
        );

        return $iterator;
    }

}