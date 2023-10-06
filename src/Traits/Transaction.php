<?php

namespace Aybarsm\Whmcs\Service\Traits;

trait Transaction
{
    public static function newTransactionHistory(array $attributes): \WHMCS\Billing\Payment\Transaction\History
    {
        $model = new \WHMCS\Billing\Payment\Transaction\History();

        $model->mergeFillable(array_keys($attributes));
        $model->fill($attributes);

        return $model;
    }

    public static function updateTransactionHistory(array $attributes, ?\WHMCS\Billing\Payment\Transaction\History $model, int $id = null): ?\WHMCS\Billing\Payment\Transaction\History
    {
        if (! $model && ! $id){
            return null;
        }

        $model = $model ?? \WHMCS\Billing\Payment\Transaction\History::find($id);

        if (! $model){
            return null;
        }

        $model->mergeFillable(array_keys($attributes));
        $model->fill($attributes);

        return $model;
    }
}