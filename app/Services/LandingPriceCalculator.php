<?php

class LandingPriceCalculator
{
    // $isMember: bool, $landingPage: LandingPage model, $extraMembersCount: int
    public static function calculate(LandingPage $landingPage, bool $isMember, int $extraMembersCount, Collection $discountRules)
    {
        $base = $isMember ? $landingPage->member_price : $landingPage->non_member_price;

        // If extra members are charged per extra? (Assumption: base price is per registration; extra members use same base or zero)
        // For simplicity we assume base is per registration and extra members are included as 'extra_count' fee = 0 by default.
        // You can extend to charge per extra member.

        $gstAmount = round($base * ($landingPage->gst_percent / 100), 2);
        $totalBeforeDiscount = $base + $gstAmount;

        // Apply discount rules (we check for active rules)
        $discountAmount = 0;
        foreach ($discountRules as $rule) {
            if (! $rule->active) continue;
            if ($rule->type === 'flat_percent') {
                $discountAmount += round($totalBeforeDiscount * ($rule->value / 100), 2);
            } elseif ($rule->type === 'extra_member_threshold' && $extraMembersCount > ($rule->threshold ?? 0)) {
                $discountAmount += round($totalBeforeDiscount * ($rule->value / 100), 2);
            }
        }
        $final = max(0, $totalBeforeDiscount - $discountAmount);
        return [
            'base' => $base,
            'gst' => $gstAmount,
            'discount' => $discountAmount,
            'final' => round($final, 2)
        ];
    }
}
