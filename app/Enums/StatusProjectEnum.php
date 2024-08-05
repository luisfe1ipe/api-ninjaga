<?php

namespace App\Enums;

enum StatusProjectEnum: string
{
  case ONGOING = 'Em andamento';
  case COMPLETED = 'Concluído';
  case CANCELLED = 'Cancelado';
  case HIATUS = 'Hiato';
}
