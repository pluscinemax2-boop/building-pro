<x-mail::message>
# Payment Confirmation

Thank you for your payment! Your transaction has been successfully processed.

<x-mail::panel>
**Payment Details**

- **Receipt ID:** {{ $payment->id }}
- **Amount:** ₹{{ $amount }}
- **Payment Date:** {{ $paymentDate }}
- **Status:** {{ ucfirst($payment->status) }}
- **Method:** {{ ucfirst($payment->payment_method) }}
</x-mail::panel>

## Invoice Summary

Your subscription is now active. You have access to all premium features for your building.

<x-mail::button :url="route('building-admin.payments.show', $payment)">
View Receipt
</x-mail::button>

If you have any questions about your payment, please contact our support team.

Thanks,<br>
Building Manager Pro
</x-mail::message>
