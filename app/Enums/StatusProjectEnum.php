<?php

namespace App\Enums;

enum StatusProjectEnum: string
{
  case ONGOING = 'Em andamento';
  case COMPLETED = 'Concluído';
  case CANCELLED = 'Cancelado';
  case HIATUS = 'Hiato';

  public static function values(): array
  {
    return [
      self::ONGOING->value,
      self::COMPLETED->value,
      self::CANCELLED->value,
      self::HIATUS->value,
    ];
  }
}
