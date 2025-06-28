<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\Auth;

class Controller extends RoutingController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function requirePermission(string $permission)
    {
        if (!Auth::user()->hasPermissionTo($permission))
            abort(403);
    }

    public function requireOrAbort(bool $condition, int $code = 403, string $message = ''): void
    {
        if ($condition)
            return;
        abort($code, $message);
    }

    public function requireCurrentUser(int $userId)
    {
        if (Auth::user()->id != $userId)
            abort(403);
    }

    /**
     * @template TModel
     * @param  class-string<TModel>  $modelClass
     * @return TModel
     */
    public function requireExistingId(string $modelClass, int $id, string $message = '')
    {
        $inst = $modelClass::where('id', $id)->first();
        if (!$inst) {
            abort(404, $message);
        }
        return $inst;
    }

    public function setUserId(Model $model, int|null $userId = null)
    {
        if ($userId == null)
            $userId = Auth::user()->id;
        $model->user_id = $userId;
    }
}
