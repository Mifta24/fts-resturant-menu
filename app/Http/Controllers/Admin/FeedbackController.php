<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateFeedbackRequest;
use App\Models\Feedback;
use App\Notifications\FeedbackStatusUpdatedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function index(): View
    {
        return view('admin.feedback.index', [
            'feedback' => Feedback::with(['restaurant', 'user'])
                ->orderByDesc('created_at')
                ->paginate(20),
        ]);
    }

    public function update(UpdateFeedbackRequest $request, Feedback $feedback): RedirectResponse
    {
        $feedback->update($request->validated());

        if ($feedback->wasChanged(['status', 'admin_note']) && $feedback->user) {
            $feedback->user->notify(new FeedbackStatusUpdatedNotification($feedback));
        }

        return back()->with('status', 'feedback-updated');
    }
}
