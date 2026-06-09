<?php

namespace App\Services\Admin;

use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FaqService
{
    public function __construct(protected Faq $faq) {}

    public function getFaqs(array $filters = [])
    {
        return $this->faq->query()
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['display_on']), fn($q) => $q->where('display_on', $filters['display_on']))
            ->when(!empty($filters['question']), fn($q) => $q->where('question', 'like', '%'.$filters['question'].'%'))
            ->ordered()
            ->paginate(20)
            ->appends($filters);
    }

    public function storeFaq(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->faq->create($data);
        });
    }

    public function updateFaq(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $faq = $this->faq->findOrFail($id);
            $faq->update($data);
            return $faq->fresh();
        });
    }

    public function deleteFaq(int $id): bool
    {
        $faq = $this->faq->findOrFail($id);
        return $faq->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $faq = $this->faq->findOrFail($id);
        $faq->status = !$faq->status;
        $faq->save();
        return $faq->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $faq = $this->faq->findOrFail($id);
        $faq->order_level = $orderLevel;
        $faq->save();
        return true;
    }
}