<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DatatableCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $collection = $this->collection;
        return [
            'recordsTotal' => $collection['total'],
            'recordsFiltered' => $collection['total'],
            'data' => $collection['data'],
            'draw' => $request->draw,
            'sum_total' => $collection['sum_total'] ?? 0,
        ];
    }
}
