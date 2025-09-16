<?php 

namespace Core\Models\DTOs;

class UserEntity
{
    public function __construct(
        public int $id,
        public string $email,
        public string $created_at,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'created_at' => $this->created_at,
        ];
    }
}