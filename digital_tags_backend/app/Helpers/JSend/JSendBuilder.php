<?php

namespace App\Helpers\JSend;

class JSendBuilder
{
    public function __construct(
        private JSendStatus $status = JSendStatus::SUCCESS,
        private array $data = [],
        private array $errors = [],
        private ?string $message = null,
        private ?int $code = null,
        private array $extraHeaders = []
    ) {}

    public function success(): self {
        $this->status = JSendStatus::SUCCESS;
        return $this;
    }

    public function fail(): self {
        $this->status = JSendStatus::FAIL;
        return $this;
    }

    public function error(): self {
        $this->status = JSendStatus::ERROR;
        return $this;
    }

    public function data(array $data): self {
        $this->data = $data;
        return $this;
    }

    public function errors(array $errors): self {
        $this->errors = $errors;
        return $this;
    }

    public function message(?string $message): self {
        $this->message = $message;
        return $this;
    }

    public function code(?int $code): self {
        $this->code = $code;
        return $this;
    }

    public function extraHeaders(array $extraHeaders): self {
        $this->extraHeaders = [];
        return $this;
    }

    public function get(int $statusCode = 200): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
    {
        $content = [
            'status' => $this->status->value,
        ];

        if (!empty($this->data)) {
            $content['data'] = $this->data;
        }

        if (!empty($this->errors)) {
            $content['errors'] = $this->errors;
        }

        if ($this->code !== null) {
            $content['code'] = $this->code;
        }

        if ($this->message !== null) {
            $content['message'] = $this->message;
        }

        return response(json_encode($content), $statusCode, array_merge(['Content-Type' => 'application/json'], $this->extraHeaders));
    }
}
