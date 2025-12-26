<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmationMail;
use App\Mail\SubscriptionActivationMail;
use App\Mail\ComplaintUpdateMail;
use App\Mail\MaintenanceRequestMail;
use App\Mail\NoticeAnnouncementMail;
use App\Mail\EmergencyAlertMail;
use App\Mail\ForumReplyMail;
use App\Models\User;

class NotificationService
{
    /**
     * Send payment confirmation email
     */
    public static function sendPaymentConfirmation($payment, $recipient = null)
    {
        $recipient = $recipient ?? $payment->building->primaryAdmin();
        
        if ($recipient && $recipient->email) {
            Mail::to($recipient->email)->send(new PaymentConfirmationMail($payment));
            return true;
        }
        return false;
    }

    /**
     * Send subscription activation email
     */
    public static function sendSubscriptionActivation($subscription, $recipient = null)
    {
        $recipient = $recipient ?? $subscription->building->primaryAdmin();
        
        if ($recipient && $recipient->email) {
            Mail::to($recipient->email)->send(new SubscriptionActivationMail($subscription));
            return true;
        }
        return false;
    }

    /**
     * Send complaint update email
     */
    public static function sendComplaintUpdate($complaint, $updateType = 'created')
    {
        $recipient = $complaint->resident;
        
        if ($recipient && $recipient->email) {
            Mail::to($recipient->email)->send(new ComplaintUpdateMail($complaint, $updateType));
            return true;
        }
        return false;
    }

    /**
     * Send maintenance request email
     */
    public static function sendMaintenanceRequest($maintenanceRequest, $updateType = 'created', $recipient = null)
    {
        // If no recipient specified, send to requester and building admin
        if (!$recipient) {
            $recipients = [];
            
            if ($maintenanceRequest->requester && $maintenanceRequest->requester->email) {
                $recipients[] = $maintenanceRequest->requester->email;
            }
            
            if ($maintenanceRequest->building && $maintenanceRequest->building->primaryAdmin()) {
                $recipients[] = $maintenanceRequest->building->primaryAdmin()->email;
            }
            
            foreach ($recipients as $email) {
                Mail::to($email)->send(new MaintenanceRequestMail($maintenanceRequest, $updateType));
            }
            return true;
        }
        
        if ($recipient && $recipient->email) {
            Mail::to($recipient->email)->send(new MaintenanceRequestMail($maintenanceRequest, $updateType));
            return true;
        }
        return false;
    }

    /**
     * Send notice announcement email to all residents
     */
    public static function sendNoticeAnnouncement($notice, $building)
    {
        $residents = $building->residents()->where('email_notifications_enabled', true)->get();
        
        foreach ($residents as $resident) {
            if ($resident->email) {
                Mail::to($resident->email)->send(new NoticeAnnouncementMail($notice, $building));
            }
        }
        
        return $residents->count();
    }

    /**
     * Send emergency alert email to all building residents
     */
    public static function sendEmergencyAlert($alert)
    {
        $building = $alert->building;
        $residents = $building->residents()->where('email_notifications_enabled', true)->get();
        
        foreach ($residents as $resident) {
            if ($resident->email) {
                Mail::to($resident->email)->send(new EmergencyAlertMail($alert));
            }
        }
        
        return $residents->count();
    }

    /**
     * Send forum reply notification
     */
    public static function sendForumReply($forumPost, $reply, $originalAuthor = null)
    {
        if (!$originalAuthor) {
            $originalAuthor = $forumPost->author;
        }
        
        if ($originalAuthor && $originalAuthor->email && $originalAuthor->id !== $reply->author_id) {
            Mail::to($originalAuthor->email)->send(new ForumReplyMail($forumPost, $reply, $originalAuthor));
            return true;
        }
        return false;
    }

    /**
     * Bulk send email to multiple recipients
     */
    public static function sendBulk($view, $data, array $recipients)
    {
        $sent = 0;
        foreach ($recipients as $recipient) {
            if (is_string($recipient)) {
                Mail::view($view, $data)->send(function ($message) use ($recipient) {
                    $message->to($recipient);
                });
                $sent++;
            } elseif ($recipient instanceof User && $recipient->email) {
                Mail::view($view, $data)->send(function ($message) use ($recipient) {
                    $message->to($recipient->email);
                });
                $sent++;
            }
        }
        return $sent;
    }
}
