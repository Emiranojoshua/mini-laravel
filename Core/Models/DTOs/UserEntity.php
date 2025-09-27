<?php 

namespace Core\Models\DTOs;

class UserEntity
{
    public function __construct(
        public int $id,
        public string $email,
    ) {
        //encrypt user details later
    }

    public function toArray(): array
    {
        //decreypt userdetails before returning array
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }
}