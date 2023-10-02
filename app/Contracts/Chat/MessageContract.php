<?php
namespace App\Contracts\Chat;

interface MessageContract
{
    public function sendMessage($payload);
}
