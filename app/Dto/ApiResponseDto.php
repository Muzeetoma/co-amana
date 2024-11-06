<?php
namespace App\Dto;

class ApiResponseDto{
    public $success;
    public $message;
    public $data;

    public function __construct(bool $success, string $message, $data) {
        $this->success = $success;
        $this->message =$message;
        $this->data = $data;
    }
}