<?php
namespace App\Contracts\Chat;

interface ChatContract
{
    public function createChat($payload);
    public function createGroupChat($payload);
}
