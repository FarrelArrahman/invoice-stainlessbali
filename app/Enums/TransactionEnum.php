<?php 

namespace App\Enums;

enum TransactionEnum : string {
    case Unpaid = 'Unpaid';
    case Partial = 'Partial';
    case Paid = 'Paid';

    public function color(): string
    {
        return match($this) 
        {
            TransactionEnum::Unpaid => 'danger',
            TransactionEnum::Partial => 'info',
            TransactionEnum::Paid => 'success',
        };
    }

    public function icon(): string
    {
        return match($this) 
        {
            TransactionEnum::Unpaid => 'far fa-x',
            TransactionEnum::Partial => 'fas fa-clock',
            TransactionEnum::Paid => 'fas fa-check',
        };
    }

    public function badge(): string
    {
        return "<div class=\"badge bg-{$this->color($this)}\">{$this->value}</div>";
    }
}

?>