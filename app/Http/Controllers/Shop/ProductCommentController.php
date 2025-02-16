<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\ProductCommentRequest;
use App\Interfaces\CommentInterface;
use App\Interfaces\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductCommentController extends Controller
{
    protected CommentInterface $commentRepository;
    protected ProductInterface $productRepository;

    public function __construct(CommentInterface $commentRepository, ProductInterface $productRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->productRepository = $productRepository;
    }

    public function store_product_comment(ProductCommentRequest $request): object
    {
        $request = $request->validated();
        $check_user_open_comments = $this->commentRepository
            ->user_open_comments_count(user_id: auth()->id());
        if ($check_user_open_comments > 5)
        {
            return response()->json(status: 403);
        }
        try {
            $product = $this->productRepository->find_active_product(id: $request['product_id']);
            $product->comments()->create([
                'user_id' => auth()->id(),
                'content' => $request['description'],
                'parent_id' => $request['parent_id'],
            ]);
            return response()->json(status: 201);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(status: 400);
        }
    }
}
