// Fonction pour insérer la carte dans le DOM
function loadMap() {
    var mapContainer = document.getElementById('map-container');
    var iframe = document.createElement('iframe');
    iframe.src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2801.6383756623154!2d-71.96901222441967!3d45.39646513795655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5486772fb09fab9f%3A0x7ae1f51f764badb7!2sRP%20Electronics!5e0!3m2!1sfr!2sca!4v1732980585536!5m2!1sfr!2sca";
    iframe.width = "100%";
    iframe.height = "450";
    iframe.style.border = "0";
    iframe.allowFullscreen = true;
    iframe.loading = "lazy";
    iframe.referrerPolicy = "no-referrer-when-downgrade";
    
    // Ajouter l'iframe à la section de la carte
    mapContainer.appendChild(iframe);
}

// Appeler la fonction lorsque la page est entièrement chargée
document.addEventListener('DOMContentLoaded', function() {
    loadMap();
});
