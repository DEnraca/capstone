<h2>Hello {{ $transaction->patient->getFullname() }}</h2>

<p>Your laboratory test results are attached to this email.</p>

<p>Transaction Code: {{ $transaction->code }}</p>

<p>If you have questions, please contact the clinic.</p>

<p>Thank you.</p>