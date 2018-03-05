(gc Amcisa-Laravel\.env) -replace 'amcisa.org', 'localhost' | Out-File Amcisa-Laravel\.env

(gc Amcisa-Vue\src\store.js) -replace 'amcisa.org', 'localhost' | Out-File Amcisa-Vue\src\store.js