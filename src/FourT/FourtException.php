<?php
namespace Fourt;

use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

class FourtException extends BadResponseException
{

    /**
     * Related transaction
     * @var integer
     */
    private $transactionId;

    /**
     * Status, ie. 'FAILURE'
     * @var string
     */
    private $status;

    /**
     * Error code, see table 12.3 in API docs
     * @var integer
     */
    protected $code;

    /**
     * Reason for the exception
     * @var string
     */
    private $reason;

    /**
     * @var integer
     */
    private $authorizeTimeout;

    /**
     * Factory method to create a new response exception based on the response code.
     *
     * @param RequestInterface $request  Request
     * @param Response         $response Response received
     *
     * @return BadResponseException
     */
    public static function factory(RequestInterface $request, Response $response)
    {
        $data = $response->json();

        // Only override the expected response
        if (!isset($data['status']) || !isset($data['code']) || !isset($data['reason'])) {
            return parent::factory($request,$response);
        }

        $e = new FourtException("{$data['reason']} ({$data['code']})");
        $e->setResponse($response);
        $e->setRequest($request);

        $e->setStatus($data['status']);
        $e->setCode($data['code']);
        $e->setReason($data['reason']);
        if (isset($data['transactionId'])) $e->setTransactionId($data['transactionId']);
        if (isset($data['authorizeTimeout'])) $e->setAuthorizeTimeout($data['authorizeTimeout']);

        return $e;
    }

    /**
     * @param int $authorizeTimeout
     */
    public function setAuthorizeTimeout($authorizeTimeout)
    {
        $this->authorizeTimeout = $authorizeTimeout;
    }

    /**
     * @return int
     */
    public function getAuthorizeTimeout()
    {
        return $this->authorizeTimeout;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }


}