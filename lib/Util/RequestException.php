<?php
namespace DNAPayments\Util;

class RequestException extends \Exception {
    private $status;
    private $data;

    public function __construct($data = null, $code_field = 'code')
    {
        $status = $data['status'];
        $code= !empty($data['response']) ? $data['response'][$code_field] : 400;
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