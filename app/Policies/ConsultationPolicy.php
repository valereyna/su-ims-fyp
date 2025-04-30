<?php

namespace App\Policies;

use App\Models\Consultation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsultationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the consultation.
     */
    public function view(User $user, Consultation $consultation)
    {
        return $user->id === $consultation->student_id || $user->id === $consultation->advisor_id;
    }

    /**
     * Determine whether the user can update the consultation.
     */
    public function update(User $user, Consultation $consultation)
    {
        return $user->id === $consultation->student_id && $consultation->status === 'pending';
    }

    /**
     * Determine whether the user can approve the consultation.
     */
    public function approve(User $user, Consultation $consultation)
    {
        return $user->id === $consultation->advisor_id;
    }
}
