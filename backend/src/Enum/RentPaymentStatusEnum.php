<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum RentPaymentStatusEnum: int implements TranslatableInterface
{
    case PENDING = 0;
    case PAYED = 1;
    case UNPAYED = 2;

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        // Translate enum using custom labels
        return match ($this) {
            self::PENDING => $translator->trans('rent_payment_status.pending.label', locale: $locale),
            self::PAYED => $translator->trans('rent_payment_status.payed.label', locale: $locale),
            self::UNPAYED => $translator->trans('rent_payment_status.unpayed.label', locale: $locale),
        };
    }
}