<?php

namespace App\Policies;

use App\Models\SharedList;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TodoListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @param TodoList $list
     * @return bool
     */
    public function view(User $user, TodoList $list): bool
    {
        return $list->owner_id === $user->id ||
            $user->accessedLists()->where('list_id', $list->id)->exists();
    }

    /**
     * Determine whether the user can check any list item.
     *
     * @param User $user
     * @param TodoList $list
     * @return bool
     */
    public function check(User $user, TodoList $list): bool
    {
        return $list->owner_id === $user->id ||
            $user->accessedRights()
                ->where('list_id', $list->id)
                ->get()->first()
                ->permission_level === SharedList::CHECK_ACCESS_CODE ||
            $user->accessedRights()
                ->where('list_id', $list->id)
                ->get()->first()
                ->permission_level === SharedList::EDIT_ACCESS_CODE;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TodoList  $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TodoList $list): bool
    {
        return $user->id === $list->owner_id ||
            $user->accessedRights()
                ->where('list_id', $list->id)
                ->get()->first()
                ->permission_level === SharedList::EDIT_ACCESS_CODE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TodoList  $list
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TodoList $list): bool
    {
        return $user->id === $list->owner_id;
    }

    /**
     * Determine whether the user can share the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TodoList  $list
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function share(User $user, TodoList $list): bool
    {
        return $user->id === $list->owner_id;
    }
}
