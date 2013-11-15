<?php

namespace DTail;

use Aws\Common\Aws;
use Aws\DynamoDb\DynamoDbClient;

use DTail\Utils;


class DTail {

    private $dynamodb;

    private $table;
    private $key;
    private $secret;
    private $region;

    public function __construct($dynamodb) {

        $this->dynamodb = $dynamodb;

    }

    public function get($table, $channel) {

        $iterator = $this->dynamodb->getIterator('Query', array(
            'TableName'     => $table,
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