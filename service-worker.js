// service-worker.js

const CACHE_NAME = 'bookmark-v2';

self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function(cache) {
            return cache.addAll([
                '/',
                '/index.php',
                '/style.css',
                '/script.js',
                '/icon.png'
                // Add more URLs of static assets here
            ]);
        })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            // Cache-first strategy
            return response || fetch(event.request).then(function(fetchResponse) {
                // Dynamic caching
                return caches.open(CACHE_NAME).then(function(cache) {
                    cache.put(event.request, fetchResponse.clone());
                    return fetchResponse;
                });
            }).catch(function(error) {
                // Error handling
                console.error('Error fetching:', error);
                // You can return a custom offline page here
            });
        })
    );
});
