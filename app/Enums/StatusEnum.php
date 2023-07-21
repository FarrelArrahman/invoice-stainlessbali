<?php 

namespace App\Enums;

enum StatusEnum : string {
    case Available = 'Available';
    case Unavailable = 'Unavailable';

    public function color(): string
    {
        return match($this) 
        {
            StatusEnum::Available => 'success',
            StatusEnum::Unavailable => 'secondary',
        };
    }

    public function icon(): string
    {
        return match($this) 
        {
            StatusEnum::Available => 'fas fa-check',
            StatusEnum::Unavailable => 'far fa-x',
        };
    }

    public function badge(): string
    {
        return "<div class=\"badge bg-{$this->color($this)}\">{$this->value}</div>";
    }
}

?>