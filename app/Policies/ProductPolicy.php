<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    // Hanya pemilik, dan hanya selama barang belum terjual
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id && ! $product->isSold();
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id && ! $product->isSold();
    }
}