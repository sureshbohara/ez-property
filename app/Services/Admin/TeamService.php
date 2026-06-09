<?php

namespace App\Services\Admin;

use App\Models\Team;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class TeamService
{
    public function __construct(protected Team $team, protected MediaService $mediaService) {}

    public function getTeams(array $filters = []){
        return $this->team->query()
            ->when(!empty($filters['status']), function ($q) use ($filters) {
                $status = filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN);
                $q->where('status', $status);
            })
            ->when(!empty($filters['name']), function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storeTeam(array $data){
        return DB::transaction(function () use ($data) {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }
            return $this->team->create($data);
        });
    }

    public function updateTeam(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $team = $this->team->findOrFail($id);

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($team->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                $this->mediaService->deleteImageVariants($team->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $team->update($data);
            return $team->fresh();
        });
    }

    public function deleteTeam(int $id): bool
    {
        $team = $this->team->findOrFail($id);
        if ($team->image) {
            $this->mediaService->deleteImageVariants($team->image);
        }
        return $team->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $team = $this->team->findOrFail($id);
        $team->status = !$team->status;
        $team->save();
        return $team->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $team = $this->team->findOrFail($id);
        $team->order_level = $orderLevel;
        $team->save();
        return true;
    }
}