<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ClienteRepositoryInterface;
use Illuminate\Support\Facades\Http;

class ClienteRepository implements ClienteRepositoryInterface
{
    protected $url;
    protected $key;

    public function __construct()
    {
        $this->url = config('app.supabase_url', env('SUPABASE_URL'));
        $this->key = config('app.supabase_key', env('SUPABASE_KEY'));
    }

    protected function request()
    {
        return Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Accept' => 'application/json',
            'Prefer' => 'return=representation'
        ]);
    }

    public function getAll(int $page, int $perPage)
    {
        $offset = ($page - 1) * $perPage;
        
        // Busca dados
        $response = $this->request()->get($this->url . '/rest/v1/pwcliente', [
            'select' => '*, pwendereco(*), pwtelefone(*), pwclientefisico(*), pwclientejuridico(*)',
            'order' => 'codcliente.desc',
            'offset' => $offset,
            'limit' => $perPage,
        ]);
        $response->throw();
        
        // Busca total (simples request separado para contagem)
        $countResponse = Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Prefer' => 'count=exact' 
        ])->get($this->url . '/rest/v1/pwcliente', ['select' => 'codcliente', 'limit' => 1]);
        
        $range = $countResponse->header('Content-Range');
        $total = $range ? (int) explode('/', $range)[1] : 0;

        return ['data' => $response->json(), 'total' => $total];
    }

    public function findById(string $id)
    {
        $response = $this->request()->get($this->url . '/rest/v1/pwcliente', [
            'select' => '*, pwendereco(*), pwtelefone(*), pwclientefisico(*), pwclientejuridico(*)',
            'codcliente' => 'eq.' . $id,
            'limit' => 1
        ]);
        $response->throw();
        $data = $response->json();
        
        return $data[0] ?? null;
    }

    public function create(string $table, array $data)
    {
        $response = $this->request()->post($this->url . '/rest/v1/' . $table, $data);
        $response->throw();
        return $response->json()[0]; // Retorna o objeto criado
    }

    public function update(string $table, string $column, string $id, array $data)
    {
        $response = $this->request()->patch($this->url . '/rest/v1/' . $table . '?' . $column . '=eq.' . $id, $data);
        $response->throw();
        return $response->json()[0] ?? null;
    }

    public function delete(string $table, string $column, string $id)
    {
        $this->request()->delete($this->url . '/rest/v1/' . $table . '?' . $column . '=eq.' . $id)->throw();
    }
}