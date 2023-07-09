<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TenantFormRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;


class CategoryApiController extends Controller
{
    protected  $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function categoriesByTenant(TenantFormRequest $request)
    {
        // if(!$request->token_company){
        //     return response()->json(['message' => 'Token not Found'], 404);
        // }

        $categories = $this->categoryService->getCategoriesByUuid($request->token_company); // podemos retorna com esses dados, porém irá exibir todos os dados, por conta disso utilizamos nosso resorce para filtrar o que iremos enviar.
        
        return CategoryResource::collection($categories);
    }

    public function show(TenantFormRequest $request, $identify)
    {
        if(!$category = $this->categoryService->getCategoryByUuid($identify)){
            return response()->json(['message' => 'Category not Found'], 404);
        }

        return new CategoryResource($category);
    }
}
