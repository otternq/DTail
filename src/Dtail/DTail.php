<?php

namespace DTail;

use Aws\Common\Aws;
use Aws\DynamoDb\DynamoDbClient;


class DTail {

    private $dynamodb;

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