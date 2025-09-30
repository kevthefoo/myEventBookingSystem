use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BookingController;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;

// Make a booking
Route::post('/events/{event}/book', [BookingController::class, 'store'])->name('bookings.store');

// Cancel booking
Route::delete('/events/{event}/cancel', function(Event $event) {
    if (!auth()->check()) {
        return redirect('/login')->with('error', 'Please log in to cancel bookings.');
    }

    $deleted = DB::table('event_attendees')
                ->where('event_id', $event->id)
                ->where('user_id', auth()->id())
                ->delete();

    if ($deleted) {
        return redirect("/events/{$event->uuid}")->with('success', 'Booking cancelled successfully.');
    } else {
        return redirect("/events/{$event->uuid}")->with('error', 'No booking found to cancel.');
    }
});