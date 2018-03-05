COPY Amcisa-Vue\dist\index.html Amcisa-Laravel\resources\views\welcome.blade.php /Y

del Amcisa-Laravel\public_html\static\* /S /Q

XCOPY Amcisa-Vue\dist\static\* Amcisa-Laravel\public_html\static /s /i