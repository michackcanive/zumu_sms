
// sw.js
const CACHE_NAME = 'meu-app-cache-v1';
const urlsToCache = [
    '/',
    '/dist/css/adminlte.min.css',
    'dist/js/adminlte.js',
    'dist/js/adminlte.js',
    // ... adicione mais URLs de recursos que deseja cachear
];

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(urlsToCache);
        })
    );
});

self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request).then(function (response) {
            return response || fetch(event.request);
        })
    );
});



