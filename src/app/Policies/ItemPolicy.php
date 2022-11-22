<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //Anyone
        return TRUE;
        // return $user->role->permissions->contains(function ($permission){
        //     return $permission->name == config('define.permission.item.view_list');
        // });
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Item $item)
    {
        //Anyone
        return TRUE;
        // return $user->role->permissions->contains(function ($permission){
        //     return $permission->name == config('define.permission.item.view_list');
        // });
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains(function ($permission){
            return $permission->name == config('define.permission.item.add');
        });
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Item $item)
    {
        return $user->role->permissions->contains(function ($permission){
            return $permission->name == config('define.permission.item.update');
        });
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Item $item)
    {
        return $user->role->permissions->contains(function ($permission){
            return $permission->name == config('define.permission.item.delete');
        });
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Item $item)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Item $item)
    {
        //
    }
}
