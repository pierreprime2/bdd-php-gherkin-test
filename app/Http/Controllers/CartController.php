<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartController
{
    private function getCart(Request $request): Cart
    {
        /** @var Cart|null $cart */
        $cart = $_SESSION['cart'] ?? null;

        if (!$cart instanceof Cart) {
            $cart = new Cart();
            $_SESSION['cart'] = $cart;
        }

        return $cart;
    }

    private function saveCart(Cart $cart): void
    {
        $_SESSION['cart'] = $cart;
    }

    public function show(Request $request): JsonResponse
    {
        $cart = $this->getCart($request);

        return new JsonResponse([
            'total' => $cart->total(),
            'itemsCount' => $cart->itemsCount(),
            'items' => $cart->items(),
        ]);
    }

    public function addItem(Request $request)
    {
        // $cart = $this->getCart($request);

        // $price = $request->input('price');

        // // Illuminate\Request always returns JSON numbers as strings.
        // if (is_string($price) && ctype_digit($price)) {
        //     $price = (int) $price;
        // }

        // if (!is_int($price)) {
        //     return new JsonResponse([
        //         'error' => 'price must be an integer',
        //     ], 400);
        // }

        $cart = $this->getCart($request);

        // Decode raw JSON payload ourselves to avoid Request::input quirks
        $payload = json_decode($request->getContent(), true);

        if (!is_array($payload) || !array_key_exists('price', $payload)) {
            return new JsonResponse([
                'error' => 'price must be an integer',
            ], 400);
        }

        $price = $payload['price'];

        // Accept numeric integer values ("10" or 10), reject floats/"10.5"
        if (is_string($price) && ctype_digit($price)) {
            $price = (int) $price;
        }

        if (!is_int($price)) {
            return new JsonResponse([
                'error' => 'price must be an integer',
            ], 400);
        }

        try {
            $cart->addItem($price);
            $this->saveCart($cart);

            return new JsonResponse([
                'total' => $cart->total(),
                'itemsCount' => $cart->itemsCount(),
                'items' => $cart->items(),
            ], 201);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function clear(Request $request): JsonResponse
    {
        $cart = $this->getCart($request);
        $cart->clear();
        $this->saveCart($cart);

        return new JsonResponse([
            'total' => $cart->total(),
            'itemsCount' => $cart->itemsCount(),
            'items' => $cart->items(),
        ]);
    }
}
