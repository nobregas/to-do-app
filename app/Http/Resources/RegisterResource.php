<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    public String $access_token;

    public String $token_type = "Bearer";

    public function __construct($resource,  $access_token)
    {
        parent::__construct($resource);
        $this->access_token = $access_token;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "access_token" => $this->access_token,
            "token_type" => $this->token_type,
            "user"=> new UserResource($this->resource),
        ];
    }
}
