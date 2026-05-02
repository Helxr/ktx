<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Dangky;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification gửi khi Admin duyệt hồ sơ (approveProfile) hoặc xác nhận
 * thanh toán (confirmPayment → status COMPLETED).
 * Kênh: database (Notification Center) + email.
 */
final class HoSoDaDuyetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Dangky $dangky,
        private readonly string $buoc, // 'profile_approved' | 'payment_confirmed'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        [$title, $body, $icon] = match ($this->buoc) {
            'profile_approved' => [
                'Hồ sơ đã được duyệt ✅',
                'Hồ sơ đăng ký của bạn đã được Ban quản lý phê duyệt. Vui lòng hoàn tất thanh toán theo hướng dẫn trong email.',
                'user-check',
            ],
            'payment_confirmed' => [
                'Chào mừng cư dân mới! 🎉',
                'Thanh toán đã được xác nhận. Tài khoản của bạn đã được kích hoạt. Hãy đăng nhập để xem thông tin phòng.',
                'home',
            ],
            default => ['Cập nhật hồ sơ', 'Hồ sơ của bạn đã được cập nhật.', 'info'],
        };

        return [
            'type'       => 'hoso_' . $this->buoc,
            'icon'       => $icon,
            'title'      => $title,
            'body'       => $body,
            'action_url' => route('guest.lookup', ['token' => $this->dangky->lookup_token]),
            'dangky_id'  => $this->dangky->id,
            'buoc'       => $this->buoc,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return match ($this->buoc) {
            'profile_approved' => (new MailMessage)
                ->subject('✅ Hồ sơ đăng ký KTX đã được duyệt')
                ->greeting('Xin chào,')
                ->line('Hồ sơ đăng ký ký túc xá của bạn **đã được Ban quản lý phê duyệt**.')
                ->line('Vui lòng kiểm tra email kèm theo thông tin chuyển khoản và hoàn tất thanh toán để giữ chỗ.')
                ->action('Tra cứu đơn đăng ký', route('guest.lookup', ['token' => $this->dangky->lookup_token])),

            'payment_confirmed' => (new MailMessage)
                ->subject('🎉 Chào mừng bạn đến với KTX!')
                ->greeting('Chào mừng cư dân mới!')
                ->line('Thanh toán của bạn **đã được xác nhận thành công**.')
                ->line('Tài khoản sinh viên của bạn đã được tạo. Bạn có thể đăng nhập bằng email này để truy cập Dashboard.')
                ->action('Đăng nhập ngay', route('login')),

            default => (new MailMessage)->line('Hồ sơ của bạn đã được cập nhật.'),
        };
    }
}
