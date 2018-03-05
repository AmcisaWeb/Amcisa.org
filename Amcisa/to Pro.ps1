(gc Amcisa-Laravel\.env) -replace 'localhost', 'amcisa.org' | Out-File Amcisa-Laravel\.env

(gc Amcisa-Vue\src\store.js) -replace 'localhost', 'amcisa.org' | Out-File Amcisa-Vue\src\store.js