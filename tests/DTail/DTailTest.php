<?php

namespace DTail;

use DTail\DTail;

use Aws\Common\Aws;
use Aws\DynamoDb\DynamoDbClient;

use Guzzle\Service\Resource\Model;

class DTailTest extends \PHPUnit_Framework_TestCase {

    protected $serviceDetail;
    protected $mockDynamoDB;

    public function setUp()
    {

        $this->serviceBuilder = Aws::factory();
        $this->serviceBuilder->enableFacades();

        $this->prepDynamoDBMock();
    }

    public function prepDynamoDBMock() {
        // Mock the ListBuckets method of DynamoDB client
        $this->mockDynamoDBClient = $this->getMockBuilder('Aws\DynamoDb\DynamoDbClient')
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockDynamoDBClient->expects($this->any())
            ->method('getIterator')
            ->will($this->returnValue(array(
                'Buckets' => array(
                    array('Name' => 'foo'),
                    array('Name' => 'bar'),
                    array('Name' => 'baz')
                )
            )));

        $this->serviceBuilder->set('dynamodb', $this->mockDynamoDBClient);
    }

    public function testGet() {

        $dtail = new DTail($this->mockDynamoDBClient);
        $data = $dtail->get('PHPErrors', 'PHPErrorReporter');


        print_r($data);

        $this->assertTrue(is_array($data));

    }
        
}