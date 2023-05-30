<?php
namespace DNAPayments\Util;

class RequestException extends \Exception {
    private $status;
    private $data;

    public function __construct($data = null)
    {
        $status = $data['status'];
        $code= !empty($data['response']) ? $data['response']['code'] : 400;
        $message = !empty($data['response']) ? $data['response']['message'] : 'Server Error';
        $this->data = $data;
        $this->status = $status;
        parent::__construct($message, $code);
    }

    public function getStatus() {
        return $this->status;
    }

    public function getData() {
        return $this->data;
    }
}