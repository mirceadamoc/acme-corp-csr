<!doctype html><html><body>
<h1>Thank you for your donation!</h1>
<p>Campaign: {{ $donation->campaign->title }}</p>
<p>Amount: €{{ number_format((float)$donation->amount, 2) }}</p>
<p>Reference: {{ $donation->payment_reference }}</p>
</body></html>
