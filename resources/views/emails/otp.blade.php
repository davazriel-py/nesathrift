<div style="font-family: Arial, sans-serif; max-width: 480px; margin: auto; padding: 24px;">
    <h2 style="color:#2563eb;">NesaThrift</h2>
    <p>Halo <strong>{{ $user->name }}</strong>,</p>
    <p>Gunakan kode berikut untuk memverifikasi akunmu:</p>
    <p style="font-size: 32px; letter-spacing: 8px; font-weight: bold; background:#f1f5f9; padding:16px; text-align:center; border-radius:8px;">
        {{ $code }}
    </p>
    <p>Kode berlaku selama <strong>{{ $ttl }} menit</strong>. Jangan bagikan kode ini ke siapa pun.</p>
</div>