<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Hoadon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification gửi khi có hóa đơn mới được tạo.
 * Kênh: database (Notification Center) + email.
 */
final class HoadonMoiNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Hoadon $hoadon,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Dữ liệu lưu vào bảng notifications (Notification Center).
     */
    public function toDatabase(object $notifiable): array
    {
        $loai = match ($this->hoadon->loai_hoadon) {
            Hoadon::LOAI_DEPOSIT => 'Phí thế chân',
            Hoadon::LOAI_PENALTY => 'Phí bồi thường thiết bị',
            default              => "Hóa đơn tháng {$this->hoadon->thang}/{$this->hoadon->nam}",
        };

        return [
            'type'       => 'hoadon_moi',
            'icon'       => 'receipt',
            'title'      => "Hóa đơn mới: {$loai}",
            'body'       => 'Số tiền: ' . number_format((int) $this->hoadon->tongtien, 0, ',', '.') . 'đ. Vui lòng thanh toán đúng hạn.',
            'action_url' => route('student.hoadoncuaem'),
            'hoadon_id'  => $this->hoadon->id,
            'tongtien'   => $this->hoadon->tongtien,
            'loai'       => $this->hoadon->loai_hoadon,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $loai = match ($this->hoadon->loai_hoadon) {
            Hoadon::LOAI_DEPOSIT => 'Phí thế chân',
            Hoadon::LOAI_PENALTY => 'Phí bồi thường thiết bị',
            default              => "Hóa đơn tháng {$this->hoadon->thang}/{$this->hoadon->nam}",
        };

        return (new MailMessage)
            ->subject("📄 [{$loai}] Thông báo hóa đơn mới – KTX")
            ->greeting('Xin chào ' . ($notifiable->name ?? 'Sinh viên') . ',')
            ->line("Bạn có hóa đơn mới: **{$loai}**")
            ->line('Số tiền: **' . number_format((int) $this->hoadon->tongtien, 0, ',', '.') . 'đ**')
            ->action('Xem chi tiết hóa đơn', route('student.hoadoncuaem'))
            ->line('Vui lòng thanh toán đúng hạn để tránh phát sinh phí trễ hạn.');
    }
}
