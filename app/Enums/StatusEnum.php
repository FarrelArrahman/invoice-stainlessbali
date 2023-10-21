<?php 

namespace App\Enums;

enum StatusEnum : string {
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Available = 'Available';
    case Unavailable = 'Unavailable';

    public function color(): string
    {
        return match($this) 
        {
            StatusEnum::Active => 'success',
            StatusEnum::Inactive => 'danger',
            StatusEnum::Available => 'primary',
            StatusEnum::Unavailable => 'secondary',
        };
    }

    public function icon(): string
    {
        return match($this) 
        {
            StatusEnum::Active => 'fas fa-check',
            StatusEnum::Inactive => 'fas fa-ban',
            StatusEnum::Available => 'fas fa-check',
            StatusEnum::Unavailable => 'far fa-x',
        };
    }

    public function badge(): string
    {
        return "<div class=\"badge bg-{$this->color($this)}\">{$this->value}</div>";
    }

    public static function activeCases(): array
    {
        return [StatusEnum::Active, StatusEnum::Inactive];
    }

    public static function availableCases(): array
    {
        return [StatusEnum::Available, StatusEnum::Unavailable];
    }
}

?>