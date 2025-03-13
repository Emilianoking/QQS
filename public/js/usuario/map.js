'use strict';

// Manejo del mapa
const locationSelect = document.getElementById('location-select');
const mapIframe = document.getElementById('map-iframe');

const locations = {
    uniminuto: {
        url: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.123456789012!2d-73.6337345!3d4.1125843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9b5c8d8d8d8d%3A0x1234567890abcdef!2sUniminuto%20Villavicencio%2C%20Meta%2C%20Colombia!5e0!3m2!1sen!2sco!4v1717747200!5m2!1sen!2sco"
    },
    unad: {
        url: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.123456789012!2d-73.7709!3d4.0067!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9b5c8d8d8d8d%3A0x1234567890abcdef!2sKm1%2C%20V%C3%ADa%20Villavicencio%20-%20Acac%C3%ADas%2C%20Acac%C3%ADas%2C%20Meta%2C%20Colombia!5e0!3m2!1sen!2sco!4v1717747200!5m2!1sen!2sco"
    }
};

locationSelect.addEventListener('change', () => {
    const selectedLocation = locationSelect.value;
    mapIframe.src = locations[selectedLocation].url;
});