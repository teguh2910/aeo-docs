<?php

namespace App\Policies;

use App\Models\AeoDocument;
use App\Models\User;

class AeoDocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, AeoDocument $doc): bool
    {
        return $user->dept === $doc->dept || $user->id === $doc->created_by;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, AeoDocument $doc): bool
    {
        return $user->dept === $doc->dept || $user->id === $doc->created_by;
    }

    public function delete(User $user, AeoDocument $doc): bool
    {
        return $user->dept === $doc->dept || $user->id === $doc->created_by;
    }
}
