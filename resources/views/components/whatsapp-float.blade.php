@php
    // Numéro utilisé pour tous les liens WhatsApp du site (voir config/services.php).
    $waNumber = config('services.whatsapp.number');
    $waMessage = 'Bonjour, je suis intéressé(e) par vos produits.';
    $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);
@endphp

<a
    href="{{ $waLink }}"
    target="_blank"
    rel="noopener"
    aria-label="Contacter Boris Lumière sur WhatsApp"
    class="fixed bottom-5 right-5 z-50 w-14 h-14 rounded-full bg-green-500 hover:bg-green-600 transition shadow-xl grid place-items-center"
>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-7 h-7">
        <path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2zm0 18.2a8.2 8.2 0 0 1-4.2-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 1 1 12 20.2zm4.5-6.1c-.2-.1-1.5-.7-1.7-.8-.2-.1-.4-.1-.6.1-.2.2-.7.8-.8 1-.2.2-.3.2-.5.1-.2-.1-1-.4-2-1.2-.7-.7-1.2-1.5-1.4-1.7-.1-.2 0-.4.1-.5l.4-.4c.1-.1.2-.3.2-.4 0-.2 0-.3 0-.5s-.6-1.5-.9-2.1c-.2-.5-.5-.4-.6-.4h-.5c-.2 0-.5.1-.7.3-.2.2-.9.9-.9 2.2s1 2.6 1.1 2.7c.1.2 2 3 4.7 4.2.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.5-.1 1.5-.6 1.7-1.2.2-.6.2-1.1.2-1.2-.1-.1-.3-.2-.5-.3z"/>
    </svg>
</a>
