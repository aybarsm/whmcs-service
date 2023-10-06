<?php

namespace Aybarsm\Whmcs\Service\Traits;

trait Invoice
{
    public static function getInvoiceById(int $id): ?\WHMCS\Billing\Invoice
    {
        return \WHMCS\Billing\Invoice::find($id);
    }
}