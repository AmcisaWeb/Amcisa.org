(gc -Raw Amcisa-Laravel\.env) -replace 'amcisa.org', 'localhost' | Set-Content Amcisa-Laravel\.env

(gc -Raw Amcisa-Vue\src\store.js) -replace 'amcisa.org', 'localhost' | Set-Content Amcisa-Vue\src\store.js