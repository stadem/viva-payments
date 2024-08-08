<?php

namespace Stadem\VivaPayments\Traits;

trait unsetData
{
    public function unsetData(array $data): array
    {
        return array_filter($data, fn (mixed $item) => isset($item));
    }
}