<?php

namespace App\Enums;

enum BloodTypesEnum : int
{
    case FirstPositive = 1;
    case SecondPositive = 2;
    case ThirdPositive = 3;
    case FourthPositive = 4;
    case FirstNegative = 5;
    case SecondNegative = 6;
    case ThirdNegative = 7;
    case FourthNegative = 8;

    public function BloodType(): string
    {
        return match ($this) {
            BloodTypesEnum::FirstPositive => 'O(+)',
            BloodTypesEnum::SecondPositive => 'A(+)',
            BloodTypesEnum::ThirdPositive => 'B(+)',
            BloodTypesEnum::FourthPositive => 'AB(+)',
            BloodTypesEnum::FirstNegative => 'O(-)',
            BloodTypesEnum::SecondNegative => 'A(-)',
            BloodTypesEnum::ThirdNegative => 'B(-)',
            BloodTypesEnum::FourthNegative => 'AB(-)',
        };
    }
}
