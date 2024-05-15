<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\FileManager
 *
 * @property int $id
 * @property string $origin_type
 * @property int $origin_id
 * @property string $file_link
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|FileManager newModelQuery()
 * @method static Builder|FileManager newQuery()
 * @method static Builder|FileManager query()
 * @method static Builder|FileManager whereCreatedAt($value)
 * @method static Builder|FileManager whereFileLink($value)
 * @method static Builder|FileManager whereId($value)
 * @method static Builder|FileManager whereOriginId($value)
 * @method static Builder|FileManager whereOriginType($value)
 * @method static Builder|FileManager whereUpdatedAt($value)
 * @property string|null $name
 * @method static Builder|FileManager whereName($value)
 * @mixin Eloquent
 */
class FileManager extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    public function fileDataMaping($file, $origin, $originId, $folder): array
    {
        $fileData['file'] = $file;
        $fileData['origin_type'] = $origin;
        $fileData['origin_id'] = $originId;
        $fileData['folder'] = $folder ?? 'upload';
        return $fileData;
    }

    public function upload($fileData): int
    {
        $res = 200;
        try {
            if ($fileData['file']) {
                $this->storeImage($fileData);
            }
        } catch (Exception $e) {
            $res = (int)$e->getCode();
        }
        return $res;
    }

    public function updateFile($fileData): int
    {
        $res = 200;
        try {
            if ($fileData['file']) {
                $filePath = str_replace('/', '\\', $fileData['storage_path']);
                if (file_exists(public_path($filePath))) {
                    unlink(public_path($filePath));
                }
                $this->storeImage($fileData);
            }
        } catch (Exception $e) {
            $res = (int)$e->getCode();
        }
        return $res;
    }

    private function storeImage($fileData): void
    {
        $fileName = time() . '.' . $fileData['file']->extension();
        $filePath = $fileData['file']->storeAs($fileData['folder'], $fileName, 'public');
        $this->name = $fileName;
        $this->origin_type = $fileData['origin_type'];
        $this->origin_id = $fileData['origin_id'];
        $this->file_link = '/storage/' . $filePath;
        $this->save();
    }
}
