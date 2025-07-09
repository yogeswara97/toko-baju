<?php

if (!function_exists('getStatusColors')) {
    function getStatusColors()
    {
        return [
            'pending' => 'bg-red-100 text-red-800',
            'paid' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];
    }
}
