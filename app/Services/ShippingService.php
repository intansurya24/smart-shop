<?php

namespace App\Services;

class ShippingService
{
    /**
     * Get Aceh Regencies/Cities list with their flat shipping rates.
     */
    public static function getAcehRates(): array
    {
        return [
            // Rp 10.000
            'Kota Banda Aceh' => 10000,
            'Kabupaten Aceh Besar' => 10000,

            // Rp 12.000
            'Kabupaten Pidie' => 12000,
            'Kabupaten Pidie Jaya' => 12000,

            // Rp 15.000
            'Kota Lhokseumawe' => 15000,
            'Kabupaten Aceh Utara' => 15000,
            'Kabupaten Bireuen' => 15000,

            // Rp 18.000
            'Kabupaten Aceh Barat' => 18000,
            'Kabupaten Aceh Barat Daya' => 18000,
            'Kabupaten Nagan Raya' => 18000,

            // Rp 20.000
            'Kota Langsa' => 20000,
            'Kabupaten Aceh Tamiang' => 20000,
            'Kabupaten Aceh Timur' => 20000,

            // Rp 22.000
            'Kabupaten Aceh Tengah' => 22000,
            'Kabupaten Bener Meriah' => 22000,
            'Kabupaten Gayo Lues' => 22000,

            // Rp 25.000
            'Kota Sabang' => 25000,
            'Kabupaten Simeulue' => 25000,
            'Kabupaten Aceh Singkil' => 25000,
            'Kota Subulussalam' => 25000,
            'Kabupaten Aceh Selatan' => 25000,
            'Kabupaten Aceh Tenggara' => 25000,
        ];
    }

    /**
     * Calculate Aceh shipping fee using PHP match.
     */
    public static function calculateShippingFee(string $city): int
    {
        $normalized = trim($city);

        return match ($normalized) {
            'Kota Banda Aceh', 'Banda Aceh', 'Kabupaten Aceh Besar', 'Aceh Besar' => 10000,
            'Kabupaten Pidie', 'Pidie', 'Kabupaten Pidie Jaya', 'Pidie Jaya' => 12000,
            'Kota Lhokseumawe', 'Lhokseumawe', 'Kabupaten Aceh Utara', 'Aceh Utara', 'Kabupaten Bireuen', 'Bireuen' => 15000,
            'Kabupaten Aceh Barat', 'Aceh Barat', 'Kabupaten Aceh Barat Daya', 'Aceh Barat Daya', 'Kabupaten Nagan Raya', 'Nagan Raya' => 18000,
            'Kota Langsa', 'Langsa', 'Kabupaten Aceh Tamiang', 'Aceh Tamiang', 'Kabupaten Aceh Timur', 'Aceh Timur' => 20000,
            'Kabupaten Aceh Tengah', 'Aceh Tengah', 'Kabupaten Bener Meriah', 'Bener Meriah', 'Kabupaten Gayo Lues', 'Gayo Lues' => 22000,
            'Kota Sabang', 'Sabang', 'Kabupaten Simeulue', 'Simeulue', 'Kabupaten Aceh Singkil', 'Aceh Singkil', 'Kota Subulussalam', 'Subulussalam', 'Kabupaten Aceh Selatan', 'Aceh Selatan', 'Kabupaten Aceh Tenggara', 'Aceh Tenggara' => 25000,
            default => 20000,
        };
    }
}

