<?php

namespace Fourt\Tests;

use Fourt\FourtClient;

class TransactionTest extends FourtTestCase
{
    public function testCreate()
    {
        $res = $this->client->createTransaction(
            array(
                'accountId' => '4511111111',
                'merchantId' => 3,
                'amount' => 1,
                'currency' => 'DKK',
                'vatAmount' => 0.2,
                'category' => 'SC12',
                'productId' => 'P01',
                'accountVerified' => true,
                'referenceTitle' => 'Test',
                'shortCode' => 1111
            )
        );
        return $res->get('id');
    }

    /**
     * @depends testCreate
     */
    public function testAuthorize($id)
    {
        $this->client->authorize(array('transactionId' => $id));
        return $id;
    }

    /**
     * @depends testAuthorize
     */
    public function testCapture($id)
    {
        $this->client->capture(array('transactionId' => $id, 'amount' => 0.5, 'vatAmount' =>0.1));
        return $id;
    }

    /**
     * @depends testCapture
     */
    public function testRefund($id)
    {
        $this->client->refund(array('transactionId' => $id, 'amount' => 0.5, 'vatAmount' =>0.1));
        return $id;
    }

    /**
     * @depends testCreate
     */
    public function testGet($id)
    {
        $this->client->getTransaction(array('transactionId' => $id));
        return $id;
    }

    /**
     *
     */
    public function testInvalidate()
    {
        $res = $this->client->createTransaction(
            array(
                'accountId' => '4511111111',
                'merchantId' => 3,
                'amount' => 1,
                'currency' => 'DKK',
                'vatAmount' => 0.2,
                'category' => 'SC12',
                'productId' => 'P01',
                'accountVerified' => true,
                'referenceTitle' => 'Test',
                'shortCode' => 1111
            )
        );
        $this->client->invalidateTransaction(array('transactionId' => $res['id']));
    }
}