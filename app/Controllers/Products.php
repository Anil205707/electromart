<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
   public function index()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('index.php/login'));
    }

    $productModel = new \App\Models\ProductModel();
    $q = trim((string) $this->request->getGet('q'));

    $builder = $productModel
        ->select('products.*, users.name as seller_name')
        ->join('users', 'users.id = products.seller_id')
        ->orderBy('products.id', 'DESC');

    if ($q !== '') {
        $builder->groupStart()
            ->like('products.title', $q)
            ->orLike('products.category', $q)
            ->orLike('products.description', $q)
            ->groupEnd();
    }

    $products = $builder->findAll();

    return view('products/index', [
        'products' => $products,
        'q' => $q
    ]);
}

    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('index.php/login'));
        }

        return view('products/create');
    }

    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('index.php/login'));
        }

        try {
            $productModel = new ProductModel();

            $title = trim((string) $this->request->getPost('title'));
            $description = trim((string) $this->request->getPost('description'));
            $price = trim((string) $this->request->getPost('price'));
            $category = trim((string) $this->request->getPost('category'));

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
                'latitude'    => null,
                'longitude'   => null,
                'seller_id'   => session()->get('user_id'),
                'created_at'  => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to(base_url('index.php/products'))
                             ->with('success', 'Product added successfully.');
        } catch (\Throwable $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function show($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('index.php/login'));
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

    $productModel = new \App\Models\ProductModel();
    $q = trim((string) $this->request->getGet('q'));

    $builder = $productModel
        ->select('products.*, users.name as seller_name')
        ->join('users', 'users.id = products.seller_id')
        ->orderBy('products.id', 'DESC');

    if ($q !== '') {
        $builder->groupStart()
            ->like('products.title', $q)
            ->orLike('products.category', $q)
            ->orLike('products.description', $q)
            ->groupEnd();
    }

    $products = $builder->findAll();

    return $this->response->setJSON($products);
}
}