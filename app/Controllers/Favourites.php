<?php

namespace App\Controllers;

use App\Models\FavouriteModel;
use App\Models\ProductModel;

class Favourites extends BaseController
{
    public function toggle()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
        }

        $userId = session()->get('user_id');
        $productId = (int) $this->request->getPost('product_id');

        $favouriteModel = new FavouriteModel();

        $existing = $favouriteModel
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $favouriteModel->delete($existing['id']);

            return $this->response->setJSON([
                'status' => 'removed',
                'message' => 'Removed from favourites'
            ]);
        }

        $favouriteModel->insert([
            'user_id'    => $userId,
            'product_id' => $productId,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'status' => 'added',
            'message' => 'Added to favourites'
        ]);
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('index.php/login'));
        }

        $userId = session()->get('user_id');

        $productModel = new ProductModel();

        $products = $productModel
            ->select('products.*, users.name as seller_name')
            ->join('favourites', 'favourites.product_id = products.id')
            ->join('users', 'users.id = products.seller_id')
            ->where('favourites.user_id', $userId)
            ->orderBy('favourites.id', 'DESC')
            ->findAll();

        return view('favourites/index', [
            'products' => $products
        ]);
    }
}