<?php

use App\Models\AdminLog;

if (! function_exists('admin_log')) {
    function admin_log(string $action, ?string $target = null, ?string $description = null): void
    {
        if (!auth()->check()) {
            return;
        }

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => $action,
            'target' => $target,
            'description' => $description,
        ]);
    }
}
