<?php

declare(strict_types=1);

namespace App;

use App\Exception\InsufficientFundsException;
use App\Exception\InvalidAmountException;

class BankAccount
{
    private float $balance;

    /**
     * @throws InvalidAmountException
     */
    public function __construct(float $initialBalance)
    {
        if ($initialBalance < 0) {
            throw new InvalidAmountException('Начальный баланс не может быть отрицательным.');
        }

        $this->balance = $initialBalance;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @throws InvalidAmountException
     */
    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidAmountException('Сумма пополнения должна быть больше нуля.');
        }

        $this->balance += $amount;
    }

    /**
     * @throws InvalidAmountException
     * @throws InsufficientFundsException
     */
    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidAmountException('Сумма снятия должна быть больше нуля.');
        }

        if ($amount > $this->balance) {
            throw new InsufficientFundsException(
                "Недостаточно средств на счете. Текущий баланс: {$this->balance}, запрошено: {$amount}."
            );
        }

        $this->balance -= $amount;
    }
}
