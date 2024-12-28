<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use App\Models\HistoryLeads;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class LeadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HistoryLeads $lead): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HistoryLeads $lead): bool
    {
        if ($lead->user_id === Auth::user()->id || Auth::user()->role === 'admin' ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HistoryLeads $lead): bool
    {
        if ($lead->user_id === Auth::user()->id || Auth::user()->role === 'admin') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HistoryLeads $lead): bool
    {
        if ($lead->user_id === Auth::user()->id || Auth::user()->role === 'admin') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HistoryLeads $lead): bool
    {
        if ($lead->user_id === Auth::user()->id || Auth::user()->role === 'admin') {
            return true;
        } else {
            return false;
        }
    }
}
