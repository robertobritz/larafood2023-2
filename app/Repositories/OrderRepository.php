<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    protected $entity;

    public function __construct(Order $order)
    {
        $this->entity = $order;
    }

    public function createNewOrder(
        string $identify,
        float $total,
        string $status,
        string $comment = '',
        int $tenantId,
        $clientId = '', 
        $tableId = ''
    ){
        $data = [
        'tenant_id' => $tenantId,    
        'identify' => $identify,
        'total' => $total,
        'status' => $status,
        'comment' => $comment,
        ];

        if ($clientId) $data['client_id'] = $clientId;
        if ($tableId) $data['table_id'] = $tableId;

        //dd($data); 

        $order = $this->entity->create($data);

        return $order;
    }


    public function getOrderByIdentify(string $identify)
    {
        $data = $this->entity // está colocando junto na consulta o tenant.
                         ->where('identify', $identify)
                         ->first();
        

        return($data);
    }

    public function registerProductsOrder(int $orderId, array $products)
    {
        $orderProducts = [];

        $order = $this->entity->find($orderId); //Utilizando o Eloquent

        foreach ($products as $product) {
            $orderProducts[$product['id']] = [
                'qty' => $product['qty'],
                'price' => $product['price'],
            ];
        }

        $order->products()->attach($orderProducts); // Deu problema na relação da ordem com os produtos.

        // foreach ($products as $product) {  // MÉTODO USANDO A FAÇADE DB
        //     array_push($orderProducts, [
        //         'order_id' => $orderId,
        //         'product_id' => $product['id'],
        //         'qty' => $product['qty'],
        //         'price' => $product['price'],
        //     ]);
        // }
        // DB::table('order_product')->insert($orderProducts);
    }
    
    public function getOrdersByClientId(int $idClient)
    {
        $orders = $this->entity
                        ->where('client_id', $idClient)
                        ->paginate();
    
        return $orders;
    }
    
}