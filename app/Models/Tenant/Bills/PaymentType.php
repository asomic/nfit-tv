<?php

namespace App\Models\Tenant\Bills;

use App\Models\Tenant\Bills\Bill;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;


class PaymentType extends Model
{
    use UsesTenantConnection;

    /**
     *  Constant to get PaymentType
     *
     *  @var  integer
     */
    const EFECTIVO = 1;

    /**
     *  Constant to get PaymentType
     *
     *  @var  integer
     */
    const TRANSFERENCIA = 2;

    /**
     *  Constant to get PaymentType
     *
     *  @var  integer
     */
    const CHEQUE = 3;

    /**
     *  Constant to get PaymentType
     *
     *  @var  integer
     */
    const DEBITO = 4;

    /**
     *  Constant to get PaymentType
     *
     *  @var  integer
     */
    const CREDITO = 5;

    /**
     *  Constant to get PaymentType
     *
     *  @var  integer
     */
    const FLOW = 6;

    /**
     * Return list of PaymentTypes
     *
     * @param   [type]  $typeId  [$typeId description]
     *
     * @return  [type]           [return description]
     */
    public function listPaymentType()
    {
        return [
            self::EFECTIVO      => 'EFECTIVO',
            self::TRANSFERENCIA => 'TRANSFERENCIA',
            self::CHEQUE        => 'CHEQUE',
            self::DEBITO        => 'DEBITO',
            self::CREDITO       => 'CREDITO',
            self::FLOW          => 'FLOW',
        ];
    }

    /**
     * Returns an specific paymentType
     *
     *  @param string
     */
    public function paymentType($typeId)
    {
        $paymentTypes = self::listPaymentType();

        return $paymentTypes[$typeId] ?? null;
    }

    /**
     *  Return true if typeId given is FLOW ($typeId = 1)
     *
     *  @return  Boolean
     */
    public function isFlow($typeId)
    {
        return self::FLOW === $typeId;
    }

    /**
     *  [bill description]
     *
     *  @return [model] [description]
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /** DEVELOPING
     * [getAllPayments description]
     *
     * @return  [type]  [return description]
     */
    // public function getAllPayments()
    // {
    //     return $this->get(['id', 'payment_type']);
    // }
}
