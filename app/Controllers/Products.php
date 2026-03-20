<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\FavouriteModel;

class Products extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $productModel = new ProductModel();
        $categoryModel = new ProductModel();
        $favouriteModel = new FavouriteModel();

        $q = trim((string) $this->request->getGet('q'));
        $category = trim((string) $this->request->getGet('category'));
        $sort = trim((string) $this->request->getGet('sort'));

        $productModel
            ->select('products.*, users.name as seller_name')
            ->join('users', 'users.id = products.seller_id');

        if ($q !== '') {
            $productModel->groupStart()
                ->like('products.title', $q)
                ->orLike('products.category', $q)
                ->orLike('products.description', $q)
                ->groupEnd();
        }

        if ($category !== '') {
            $productModel->where('products.category', $category);
        }

        switch ($sort) {
            case 'price_low':
                $productModel->orderBy('products.price', 'ASC');
                break;

            case 'price_high':
                $productModel->orderBy('products.price', 'DESC');
                break;

            default:
                $productModel->orderBy('products.id', 'DESC');
                break;
        }

        // paginate products
        $products = $productModel->paginate(12, 'default');
        $pager = $productModel->pager;

        // get categories using a separate model
        $categories = $categoryModel
            ->select('category')
            ->distinct()
            ->orderBy('category', 'ASC')
            ->findAll();

        // get favourites
        $favourites = $favouriteModel
            ->where('user_id', session()->get('user_id'))
            ->findAll();

        $favouriteIds = array_column($favourites, 'product_id');

        return view('products/index', [
            'products'     => $products,
            'pager'        => $pager,
            'q'            => $q,
            'category'     => $category,
            'sort'         => $sort,
            'categories'   => $categories,
            'favouriteIds' => $favouriteIds,
        ]);
    }

    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        return view('products/create');
    }

    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        try {
            $productModel = new ProductModel();

            $title = trim((string) $this->request->getPost('title'));
            $description = trim((string) $this->request->getPost('description'));
            $price = trim((string) $this->request->getPost('price'));
            $category = trim((string) $this->request->getPost('category'));
            $latitude = trim((string) $this->request->getPost('latitude'));
            $longitude = trim((string) $this->request->getPost('longitude'));

            if ($title === '' || $description === '' || $price === '' || $category === '') {
                return redirect()->back()->withInput()->with('error', 'All fields are required.');
            }

            $image = $this->request->getFile('image');
            $imageName = null;

            if ($image && $image->isValid() && !$image->hasMoved()) {
                $imageName = $image->getRandomName();
                $image->move(ROOTPATH . 'public/uploads', $imageName);
            }

            $productModel->insert([
                'title'       => $title,
                'description' => $description,
                'price'       => $price,
                'category'    => $category,
                'image'       => $imageName,
                'latitude'    => $latitude !== '' ? $latitude : null,
                'longitude'   => $longitude !== '' ? $longitude : null,
                'seller_id'   => session()->get('user_id'),
                'created_at'  => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to(base_url('products'))
                ->with('success', 'Product added successfully.');
        } catch (\Throwable $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function show($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $productModel = new ProductModel();

        $product = $productModel
            ->select('products.*, users.name as seller_name')
            ->join('users', 'users.id = products.seller_id')
            ->where('products.id', $id)
            ->first();

        if (!$product) {
            return 'Product not found.';
        }

        return view('products/show', ['product' => $product]);
    }

    public function searchAjax()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([]);
        }

        $productModel = new ProductModel();
        $q = trim((string) $this->request->getGet('q'));

        $productModel
            ->select('products.*, users.name as seller_name')
            ->join('users', 'users.id = products.seller_id')
            ->orderBy('products.id', 'DESC');

        if ($q !== '') {
            $productModel->groupStart()
                ->like('products.title', $q)
                ->orLike('products.category', $q)
                ->orLike('products.description', $q)
                ->groupEnd();
        }

        $products = $productModel->findAll();

        return $this->response->setJSON($products);
    }
}