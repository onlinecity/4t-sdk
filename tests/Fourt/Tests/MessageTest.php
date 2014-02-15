<?php

namespace Fourt\Tests;

use Fourt\FourtClient;


class MessageTest extends FourtTestCase
{
    public function testSendMessage()
    {
        $res = $this->client->sendMessage(
            array(
                'merchantId' => 3,
                'to' => '4511111121',
                'text' => 'Hello World',
                'shortCode' => 1111,
                'from' => 'TestTest'
            )
        );
        $this->assertTrue($res->hasKey('smsId'));
        $this->assertEquals('DELIVERED',$res->get('status'));
        return (int) $res->get('smsId');
    }

    /**
     * @depends testSendMessage
     */
    public function testGet($id)
    {
        $this->client->getMessage(array('messageId' => $id));
        return $id;
    }

    public function testSendRaw()
    {
        $res = $this->client->sendMessage(
            array(
                'merchantId' => 3,
                'to' => '4511111121',
                'text' => 'C0601AE02056A0045C60C037777772E6D6F6269636174696F6E2E636F6D2F7265706F7369746F72792F766964656F2F6D70342F3937305F64343338636137323036346132653337376165306131616131383136633038612E6D70340001034D46205375707065000101',
                'shortCode' => 1111,
                'from' => 'MyMerchant',
                'type' => 'raw',
                'udh' => '0605040B8423F0',
            )
        );
        $this->assertTrue($res->hasKey('smsId'));
        $this->assertEquals('DELIVERED',$res->get('status'));
    }

    public function testSendComplete()
    {
        $res = $this->client->sendMessage(
            array(
                'merchantId' => 3,
                'to' => '4511111121',
                'text' => 'Hello World',
                'shortCode' => 1111,
                'from' => 'MyMerchant',
                'referenceId' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit posuere.',
                'validity' => 60,
                'obfuscate' => 'true',
                'callbackUrl' => 'http://127.0.0.1/dummy',
                'provideDeliveryNotification' => 'true',
                'paymentTransactionId' => 1,
                'type' => 'text'
            )
        );
        $this->assertTrue($res->hasKey('smsId'));
        $this->assertEquals('DELIVERED',$res->get('status'));
    }
}