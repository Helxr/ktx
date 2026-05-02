<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Baohong;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification gửi khi Admin cập nhật trạng thái báo hỏng.
 * Kênh: database (Notification Center) + email.
 */
final class TrangThaiBaohongNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Baohong $baohong,
        private readonly string  $trangThaiMoi,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        $icon = match ($this->trangThaiMoi) {
            'Đang sửa' => 'wrench',
            'Đã xong'  => 'check-circle',
            'Đã hẹn'   => 'calendar',
            default    => 'tool',
        };

        $body = "Yêu cầu sửa chữa tại phòng {$this->baohong->phong?->tenphong} đã chuyển sang: **{$this->trangThaiMoi}**.";

        if ($this->baohong->do_sinh_vien_gay_ra && $this->baohong->phi_boi_thuong) {
            $body .= ' Phí bồi thường ' . number_format((int) $this->baohong->phi_boi_thuong, 0, ',', '.') . 'đ đã được cộng vào hóa đơn của bạn.';
        }

        return [
            'type'       => 'baohong_capnhat',
            'icon'       => $icon,
            'title'      => "Cập nhật sửa chữa: {$this->trangThaiMoi}",
            'body'       => $body,
            'action_url' => route('student.danhsachbaohong'),
            'baohong_id' => $this->baohong->id,
            'trang_thai' => $this->trangThaiMoi,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject("🔧 Cập nhật sửa chữa – {$this->trangThaiMoi}")
            ->greeting('Xin chào ' . ($notifiable->name ?? 'Sinh viên') . ',')
            ->line("Yêu cầu báo hỏng của bạn đã được cập nhật: **{$this->trangThaiMoi}**.");

        if ($this->baohong->noidung) {
            $mail->line('Ghi chú của Ban quản lý: ' . $this->baohong->noidung);
        }

        if ($this->baohong->do_sinh_vien_gay_ra && $this->baohong->phi_boi_thuong) {
            $mail->line('⚠️ Hư hỏng được xác định do sinh viên gây ra. Phí bồi thường **'
                . number_format((int) $this->baohong->phi_boi_thuong, 0, ',', '.') . 'đ** đã được cộng vào hóa đơn.');
        }

        return $mail->action('Xem chi tiết', route('student.danhsachbaohong'));
    }
}
