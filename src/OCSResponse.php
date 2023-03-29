<?php

namespace Conkal\OwncloudProvisioningApi;

/**
 * OCS response
 */
class OCSResponse
{
    /**
     * @var OCSMeta
     */
    public $meta;
    public $data;

    public function __construct($response)
    {
        $this->meta = new OCSMeta();
        $this->meta->status = $response['ocs']['meta']['status'];
        $this->meta->statusCode = $response['ocs']['meta']['statuscode'];
        $this->meta->message = $response['ocs']['meta']['message'];
        $this->data = $response['ocs']['data'];
    }



}