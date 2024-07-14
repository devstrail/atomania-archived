<?php

namespace App\Http\Controllers\API;

use AllowDynamicProperties;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[AllowDynamicProperties] abstract class BaseCrudController extends BaseController
{
    protected string $title;
    protected string $modelClass;
    protected array $validationRules = [];
    private mixed $model;

    public function __construct(string $title, string $model, array $validationRules) {
        $this->title = $title;
        $this->modelClass = $model;
        $this->validationRules = $validationRules;
        $this->model = new $this->modelClass();
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('size', 10); // Number of items per page
        $page = $request->query('page', 1); // Current page number


        $query = $this->model;
        $this->extractOrderBy($request);


        $items = $query->orderByRaw($this->extractOrderBy($request))->paginate($perPage, ['*'], 'page', $page);
        $items['order'] = $this->extractOrderBy($request);
        return $this->sendResponse($items, "List all $this->title");
    }

    public function store(Request $request): JsonResponse {
        $validator = $this->validate($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $item = $this->model->create($request->all());

        return $this->sendResponse($item, "Item created");
    }

    public function show($id): JsonResponse {
        $item = $this->model->findOrFail($id);
        return $this->sendResponse($item, "Item with id $id found");
    }

    public function update(Request $request, $id) {
        $item = $this->model->findOrFail($id);

        $validator = $this->validate($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }
        return $this->sendResponse($item, "Item updated");
    }

    public function destroy($id): JsonResponse {
        $item = $this->model->findOrFail($id);
        $item->delete();
        return $this->sendResponse($item, "Item deleted successfully");
    }

    private function extractOrderBy(Request $request)
    {
        $orderBy = $request->query('orderBy', 'id'); // Default order by column
        // Parse orderBy parameter (e.g., 'name|asc,email|desc')
        $orderByClauses = [];
        if ($orderBy) {
            $orderByClauses = explode(',', $orderBy);
        }
        $orders = [];
        // Apply orderBy clauses
        foreach ($orderByClauses as $clause) {
            // Split by pipe and handle default 'asc' direction
            $parts = explode('|', $clause);
            $column = $parts[0]; // Column name
            $direction = $parts[1] ?? 'asc'; // Direction (default to 'asc')
            $orders[] = "$column $direction";
//            $orders[$column] = $direction;
        }
        return implode(', ', $orders);
    }
}
