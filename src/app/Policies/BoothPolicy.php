<?php

namespace App\Policies;

use App\Models\Booth;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoothPolicy
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
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Booth $booth)
    {
        //Anyone
        return TRUE;
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
            return $permission->name == config('define.permission.booth.add');
        });
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Booth $booth)
    {
        return $user->role->permissions->contains(function ($permission){
            return $permission->name == config('define.permission.booth.update');
        });
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Booth $booth)
    {
        return $user->role->permissions->contains(function ($permission){
            return $permission->name == config('define.permission.booth.delete');
        });
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Booth $booth)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Booth $booth)
    {
        //
    }
}
