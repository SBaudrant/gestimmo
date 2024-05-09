<?php 

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum LocationTypeEnum: int implements TranslatableInterface{
    case UNFURNISHED = 0;
    case FURNISHED = 1;
    
    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        // Translate enum using custom labels
        return match ($this) {
            self::UNFURNISHED  => $translator->trans('location_type.unfurnished.label', locale: $locale),
            self::FURNISHED => $translator->trans('location_type.furnished.label', locale: $locale),
        };
    }
}