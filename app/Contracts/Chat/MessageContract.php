<?php
namespace App\Contracts\Chat;

interface MessageContract
{
    public function sendMessage($payload);
    public function getMessage($payload);
}
