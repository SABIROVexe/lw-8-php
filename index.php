<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\BankAccount;
use App\Exception\InsufficientFundsException;
use App\Exception\InvalidAmountException;

// 1. Попытка создать счет с отрицательным балансом
try {
    $invalidAccount = new BankAccount(-100.0);
} catch (InvalidAmountException $e) {
    echo 'Ошибка создания счета: ' . $e->getMessage() . PHP_EOL;
}

// 2. Создание корректного счета и выполнение операций
try {
    $account = new BankAccount(1000.0);
    echo 'Счет открыт. Баланс: ' . $account->getBalance() . PHP_EOL;

    // Успешное пополнение
    $account->deposit(500.0);
    echo 'Пополнение на 500. Новый баланс: ' . $account->getBalance() . PHP_EOL;

    // Успешное снятие
    $account->withdraw(300.0);
    echo 'Снятие 300. Новый баланс: ' . $account->getBalance() . PHP_EOL;

    // Попытка пополнить на отрицательную сумму
    try {
        $account->deposit(-50.0);
    } catch (InvalidAmountException $e) {
        echo 'Ошибка пополнения: ' . $e->getMessage() . PHP_EOL;
    }

    // Попытка снять нулевую сумму
    try {
        $account->withdraw(0.0);
    } catch (InvalidAmountException $e) {
        echo 'Ошибка снятия: ' . $e->getMessage() . PHP_EOL;
    }

    // Попытка снять сумму больше текущего баланса (1200)
    try {
        $account->withdraw(2000.0);
    } catch (InsufficientFundsException $e) {
        echo 'Ошибка снятия: ' . $e->getMessage() . PHP_EOL;
    }

    echo 'Итоговый баланс: ' . $account->getBalance() . PHP_EOL;
} catch (InvalidAmountException | InsufficientFundsException $e) {
    echo 'Критическая ошибка операции: ' . $e->getMessage() . PHP_EOL;
}
