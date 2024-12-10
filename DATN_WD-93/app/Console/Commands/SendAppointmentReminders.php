<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appoinment;
use App\Models\AvailableTimeslot;
use App\Mail\AppointmentReminderMail;
use Carbon\Carbon;
use Mail;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';

    protected $description = 'Gửi email nhắc nhở cho khách hàng trước 5 giờ lịch khám';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $targetTime = $now->addHours(5); // Thời gian hiện tại + 5 giờ

        // Lấy các lịch khám sắp diễn ra trong vòng 5 giờ tới
        $appointments = Appoinment::with(['timeSlot', 'user', 'doctor.user', 'doctor.clinic'])
            ->whereHas('timeSlot', function ($query) use ($targetTime) {
                $query->whereDate('date', '=', $targetTime->format('Y-m-d'))
                      ->whereTime('startTime', '<=', $targetTime->format('H:i:s'))
                      ->whereTime('startTime', '>=', now()->format('H:i:s'));
            })
            ->where('status_appoinment', 'da_xac_nhan')
            ->get();

        foreach ($appointments as $appointment) {
            Mail::to($appointment->user->email)->send(new AppointmentReminderMail($appointment, $appointment->user));
        }

        $this->info('Email nhắc nhở đã được gửi thành công!');
    }
}
