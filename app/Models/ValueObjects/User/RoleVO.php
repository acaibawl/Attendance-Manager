<?php

namespace App\Models\ValueObjects\User;

use Assert\Assert;

final class RoleVO
{
    private int $value;

    public function __construct(int $value)
    {
        // 検証にbeberlei/assertライブラリを利用
        Assert::that($value)->range(0, 30);
        $this->value = $value;
    }

    // getter
    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }
}
