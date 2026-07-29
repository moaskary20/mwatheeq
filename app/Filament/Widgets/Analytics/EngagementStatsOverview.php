<?php

namespace App\Filament\Widgets\Analytics;

use App\Filament\Resources\BlogCommentResource;
use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\ServiceRequestResource;
use App\Models\BlogComment;
use App\Models\ContactMessage;
use App\Models\ServiceRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EngagementStatsOverview extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;

    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $unreadContacts = ContactMessage::query()->where('is_read', false)->count();
        $unreadRequests = ServiceRequest::query()->where('is_read', false)->count();
        $pendingComments = BlogComment::query()->where('is_approved', false)->count();
        $contactsToday = ContactMessage::query()->whereDate('created_at', today())->count();
        $requestsToday = ServiceRequest::query()->whereDate('created_at', today())->count();
        $commentsToday = BlogComment::query()->whereDate('created_at', today())->count();

        return [
            Stat::make('رسائل تواصل غير مقروءة', number_format($unreadContacts))
                ->description('اليوم: '.number_format($contactsToday))
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unreadContacts > 0 ? 'danger' : 'success')
                ->url(ContactMessageResource::getUrl('index')),
            Stat::make('طلبات خدمات غير مقروءة', number_format($unreadRequests))
                ->description('اليوم: '.number_format($requestsToday))
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color($unreadRequests > 0 ? 'warning' : 'success')
                ->url(ServiceRequestResource::getUrl('index')),
            Stat::make('تعليقات بانتظار الموافقة', number_format($pendingComments))
                ->description('اليوم: '.number_format($commentsToday))
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color($pendingComments > 0 ? 'warning' : 'success')
                ->url(BlogCommentResource::getUrl('index')),
        ];
    }
}
