<?php
/**
 * Webservice description.
 * Also see 4-T official documentation, the description fields below are in short form.
 * For format see: http://guzzlephp.org/webservice-client/guzzle-service-descriptions.html
 * Provided as a PHP array to allow PHP APC caching
 */
return array(
    'name' => '4T',
    'apiVersion' => '1',
    'description' => '4T Mobile Payments REST API Client',
    'operations' => array(
        'CreateTransaction' => array(
            'httpMethod' => 'POST',
            'uri' => 'v1/payment/transaction',
            'summary' => 'Create a new transaction for operations',
            'responseClass' => 'GetTransactionOutput',
            'parameters' => array(
                'merchantId' => array(
                    'description' => 'The developers target Merchant ID',
                    'type' => 'integer',
                    'location' => 'json',
                    'required' => true
                ),
                'accountId' => array(
                    'description' => 'The identifying account ID. This will be given by the web flow through 4T.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => true
                ),
                'callbackUrl' => array(
                    'description' => 'Changes to the given transaction will be communicated to this endpoint.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'callbackVerbosity' => array(
                    'description' => 'Determines what kind of states will be communicated towards the callbackUrl. A combination of values is possible by using comma-separation.',
                    'type' => 'array',
                    'location' => 'json',
                    'required' => false
                ),
                'amount' => array(
                    'description' => 'The actual value of the payment including all taxes/vat.',
                    'type' => 'numeric',
                    'location' => 'json',
                    'required' => true
                ),
                'currency' => array(
                    'description' => '3 letter codes indicate ISO 4217 codes, 5 letter codes indicate custom variant',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => true
                ),
                'vatAmount' => array(
                    'description' => 'The actual amount of included taxes/vat.',
                    'type' => 'numeric',
                    'location' => 'json',
                    'required' => true
                ),
                'category' => array(
                    'description' => 'Code for content service category',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => true
                ),
                'referenceId' => array(
                    'description' => 'The reference ID used by the developer to identify the transaction',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'referenceTitle' => array(
                    'description' => 'Description of the purchased product.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => true
                ),
                'feeCoveredBy' => array(
                    'description' => 'Indicates who will cover the transaction fee cost. Default value is "MERCHANT".',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'firstOperation' => array(
                    'description' => 'If set, the given operation will be executed by the server directly after the creation of the transaction.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'firstOperationCallbackUrl' => array(
                    'description' => 'The result of the first operation for this transaction will be communicated to this endpoint.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'firstOperationCallbackVerbosity' => array(
                    'description' => 'Determines what kind of states will be communicated towards the callbackUrl. A combination of values is possible by using comma-separation.',
                    'type' => 'array',
                    'location' => 'json',
                    'required' => false
                ),
                'productId' => array(
                    'description' => 'Code for product code',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => true
                ),
                'accountVerified' => array(
                    'description' => 'The validation of the accountId by the merchant. If merchant have verified the account the value is true.',
                    'type' => 'boolean',
                    'location' => 'json',
                    'required' => true
                ),
                'shortCode' => array(
                    'description' => 'The shortcode the transaction is initiated by.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                )
            )
        ),
        'InvalidateTransaction' => array(
            'httpMethod' => 'DELETE',
            'uri' => 'v1/payment/transaction/{transactionId}',
            'summary' => 'Invalidate a transaction',
            'parameters' => array(
                'transactionId' => array(
                    'description' => 'The ID of the transaction',
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true
                )
            )
        ),
        'GetTransaction' => array(
            'httpMethod' => 'GET',
            'uri' => 'v1/payment/transaction/{transactionId}',
            'summary' => 'Get a transaction',
            'responseClass' => 'GetTransactionOutput',
            'parameters' => array(
                'transactionId' => array(
                    'description' => 'The ID of the transaction',
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true
                )
            )
        ),
        'Authorize' => array(
            'httpMethod' => 'POST',
            'uri' => 'v1/payment/transaction/{transactionId}/operation',
            'summary' => 'Perform an authorize operation on a transaction.',
            'responseClass' => 'OperationOutput',
            'parameters' => array(
                'transactionId' => array(
                    'description' => 'The ID of the transaction',
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true
                ),
                'type' => array(
                    'description' => 'Operation type',
                    'default' => 'AUTHORIZE',
                    'location' => 'json',
                    'required' => true
                ),
                'callbackUrl' => array(
                    'description' => 'The outcome of this operation will be communicated to the given endpoint.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'callbackVerbosity' => array(
                    'description' => 'Determines what kind of states will be communicated towards the callbackUrl. A combination of values is possible by using comma-separation.',
                    'type' => 'array',
                    'location' => 'json',
                    'required' => false
                )
            )
        ),
        'Cancel' => array(
            'httpMethod' => 'POST',
            'uri' => 'v1/payment/transaction/{transactionId}/operation',
            'summary' => 'Perform a cancel operation on a transaction.',
            'responseClass' => 'OperationOutput',
            'parameters' => array(
                'transactionId' => array(
                    'description' => 'The ID of the transaction',
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true
                ),
                'type' => array(
                    'description' => 'Operation type',
                    'default' => 'CANCEL',
                    'location' => 'json',
                    'required' => true
                ),
                'callbackUrl' => array(
                    'description' => 'The outcome of this operation will be communicated to the given endpoint.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'callbackVerbosity' => array(
                    'description' => 'Determines what kind of states will be communicated towards the callbackUrl. A combination of values is possible by using comma-separation.',
                    'type' => 'array',
                    'location' => 'json',
                    'required' => false
                )
            )
        ),
        'Capture' => array(
            'httpMethod' => 'POST',
            'uri' => 'v1/payment/transaction/{transactionId}/operation',
            'summary' => 'Perform a capture operation on a transaction.',
            'responseClass' => 'OperationOutput',
            'parameters' => array(
                'transactionId' => array(
                    'description' => 'The ID of the transaction',
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true
                ),
                'type' => array(
                    'description' => 'Operation type',
                    'default' => 'CAPTURE',
                    'location' => 'json',
                    'required' => true
                ),
                'callbackUrl' => array(
                    'description' => 'The outcome of this operation will be communicated to the given endpoint.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'callbackVerbosity' => array(
                    'description' => 'Determines what kind of states will be communicated towards the callbackUrl. A combination of values is possible by using comma-separation.',
                    'type' => 'array',
                    'location' => 'json',
                    'required' => false
                ),
                'amount' => array(
                    'description' => 'The actual value of the payment including all taxes/vat.',
                    'type' => 'numeric',
                    'location' => 'json',
                    'required' => false
                ),
                'vatAmount' => array(
                    'description' => 'The actual amount of included taxes/vat.',
                    'type' => 'numeric',
                    'location' => 'json',
                    'required' => false
                ),
            )
        ),
        'ImmediateCapture' => array(
            'httpMethod' => 'POST',
            'uri' => 'v1/payment/transaction/{transactionId}/operation',
            'summary' => 'Perform a capture operation on a transaction without going through authorize.',
            'responseClass' => 'OperationOutput',
            'parameters' => array(
                'transactionId' => array(
                    'description' => 'The ID of the transaction',
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true
                ),
                'type' => array(
                    'description' => 'Operation type',
                    'default' => 'IMMEDIATE_CAPTURE',
                    'location' => 'json',
                    'required' => true
                ),
                'callbackUrl' => array(
                    'description' => 'The outcome of this operation will be communicated to the given endpoint.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'callbackVerbosity' => array(
                    'description' => 'Determines what kind of states will be communicated towards the callbackUrl. A combination of values is possible by using comma-separation.',
                    'type' => 'array',
                    'location' => 'json',
                    'required' => false
                ),
                'amount' => array(
                    'description' => 'The actual value of the payment including all taxes/vat.',
                    'type' => 'numeric',
                    'location' => 'json',
                    'required' => false
                ),
                'vatAmount' => array(
                    'description' => 'The actual amount of included taxes/vat.',
                    'type' => 'numeric',
                    'location' => 'json',
                    'required' => false
                ),
            )
        ),
        'Refund' => array(
            'httpMethod' => 'POST',
            'uri' => 'v1/payment/transaction/{transactionId}/operation',
            'summary' => 'Perform a refund operation on a transaction.',
            'responseClass' => 'OperationOutput',
            'parameters' => array(
                'transactionId' => array(
                    'description' => 'The ID of the transaction',
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true
                ),
                'type' => array(
                    'description' => 'Operation type',
                    'default' => 'REFUND',
                    'location' => 'json',
                    'required' => true
                ),
                'callbackUrl' => array(
                    'description' => 'The outcome of this operation will be communicated to the given endpoint.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'callbackVerbosity' => array(
                    'description' => 'Determines what kind of states will be communicated towards the callbackUrl. A combination of values is possible by using comma-separation.',
                    'type' => 'array',
                    'location' => 'json',
                    'required' => false
                ),
                'amount' => array(
                    'description' => 'The actual value of the payment including all taxes/vat.',
                    'type' => 'numeric',
                    'location' => 'json',
                    'required' => false
                ),
                'vatAmount' => array(
                    'description' => 'The actual amount of included taxes/vat.',
                    'type' => 'numeric',
                    'location' => 'json',
                    'required' => false
                ),
            )
        ),
        'SendMessage' => array(
            'httpMethod' => 'POST',
            'uri' => 'smsapi/v1/SMS/Messages',
            'summary' => 'Send a SMS',
            'responseClass' => 'GetMessageOutput',
            'parameters' => array(
                'merchantId' => array(
                    'description' => 'The developers target Merchant ID',
                    'type' => 'integer',
                    'location' => 'json',
                    'required' => true
                ),
                'to' => array(
                    'description' => 'The MSISDN (Mobile Number) of the recipient of the message. MSISDN must be in international format',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => true
                ),
                'text' => array(
                    'description' => 'An alphanumeric value representing the content of the SMS.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => true
                ),
                'shortCode' => array(
                    'description' => 'The 4T system assigned short code. Ex: 1256',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => true
                ),
                'from' => array(
                    'description' => 'An alphanumeric sender address of maximum 11 characters with no special characters allowed.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'referenceId' => array(
                    'description' => 'The reference ID used by the developer/merchant to identify the transaction in their transaction.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'validity' => array(
                    'description' => 'Time in minutes that delivery of the sms should be attempted. This defaults to 4320',
                    'type' => 'integer',
                    'location' => 'json',
                    'required' => false
                ),
                'obfuscate' => array(
                    'description' => 'Possible values are true or false. If set to true, 4T system will not log the content of the message.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'callbackUrl' => array(
                    'description' => 'Changes to the given transaction will be communicated to this endpoint.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'provideDeliveryNotification' => array(
                    'description' => 'Possible values are true or false. If true the delivery status will be posted through callbackUrl. The default value is true',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'paymentTransactionId' => array(
                    'description' => 'This is mandatory on the contractual level - If this SMS that is being sent is in the context of a payment flow (SMS ticket) then this ID must indicate the transaction ID of the related authorization made earlier.',
                    'type' => 'integer',
                    'location' => 'json',
                    'required' => false
                ),
                'type' => array(
                    'description' => 'Specifies the type of message being sent. If left out it defaults to text.',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                ),
                'udh' => array(
                    'description' => 'ASCII-representations of hexadecimal numbers, which in turn represent the binary values. Eg. 05000102',
                    'type' => 'string',
                    'location' => 'json',
                    'required' => false
                )
            )
        ),
        'GetMessage' => array(
            'httpMethod' => 'GET',
            'uri' => 'smsapi/v1/SMS/Messages/{messageId}',
            'summary' => 'Get a SMS',
            'responseClass' => 'GetMessageOutput',
            'parameters' => array(
                'messageId' => array(
                    'description' => 'The ID of the transaction',
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true
                )
            )
        )
    ),
    'models' => array(
        'GetTransactionOutput' => array(
            'type' => 'object',
            'additionalProperties' => array(
                'location' => 'json'
            )
        ),
        'OperationOutput' => array(
            'type' => 'object',
            'additionalProperties' => array(
                'location' => 'json'
            )
        ),
        'GetMessageOutput' => array(
            'type' => 'object',
            'additionalProperties' => array(
                'location' => 'json'
            )
        )
    )
);