(gc -Raw Amcisa-Laravel\.env) -replace 'localhost', 'amcisa.org' | Set-Content Amcisa-Laravel\.env

(gc -Raw Amcisa-Vue\src\store.js) -replace 'localhost', 'amcisa.org' | Set-Content Amcisa-Vue\src\store.js